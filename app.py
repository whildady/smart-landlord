import streamlit as st
import yaml
import os
import re

st.set_page_config(
    page_title="Smart Landlord System",
    page_icon=None,
    layout="wide",
    initial_sidebar_state="expanded"
)

# ── Load YAML ──────────────────────────────────────────────────────────────────
base_path = os.path.dirname(os.path.abspath(__file__))
for name in ["presentation.yml", "presentation.yaml"]:
    yaml_path = os.path.join(base_path, name)
    if os.path.exists(yaml_path):
        break
else:
    st.error("presentation.yml not found.")
    st.stop()

with open(yaml_path, "r", encoding="utf-8") as f:
    data = yaml.safe_load(f)

slides = data["presentation_slides"]
total  = len(slides)

# ── Session state for slide index ──────────────────────────────────────────────
if "slide_idx" not in st.session_state:
    st.session_state.slide_idx = 0

def go_to(i):
    st.session_state.slide_idx = max(0, min(i, total - 1))

# ── CSS ────────────────────────────────────────────────────────────────────────
st.markdown("""
<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600&family=JetBrains+Mono:wght@400;500&display=swap');

*, *::before, *::after { box-sizing: border-box; }
html, body, [class*="css"], .stApp {
    font-family: 'DM Sans', sans-serif !important;
    background: #0D1117 !important;
    color: #C9D1D9 !important;
}
#MainMenu, footer, header { visibility: hidden; }
.block-container { padding: 0 2rem 2rem !important; max-width: 100% !important; }

/* ═══ SIDEBAR ════════════════════════════════════════════════════════════════ */
section[data-testid="stSidebar"] {
    background: #0D1117 !important;
    border-right: 1px solid #21262D !important;
}
section[data-testid="stSidebar"] * { color: #8B949E !important; }

.sb-header {
    padding: 24px 20px 18px;
    border-bottom: 1px solid #21262D;
    margin-bottom: 6px;
}
.sb-logo {
    font-family: 'DM Serif Display', serif;
    font-size: 1.05rem;
    color: #C9A84C !important;
    letter-spacing: 0.03em;
    display: block;
    margin-bottom: 4px;
}
.sb-sub { font-size: 0.68rem; color: #484F58 !important; letter-spacing: 0.08em; text-transform: uppercase; }
.sb-author { margin-top: 6px; font-size: 0.75rem; color: #6E7681 !important; }

/* nav items */
.nav-item {
    display: flex; align-items: flex-start; gap: 10px;
    padding: 9px 20px;
    border-left: 2px solid transparent;
}
.nav-item.active { background: #161B22; border-left-color: #C9A84C; }
.nav-num { font-family: 'JetBrains Mono', monospace; font-size: 0.62rem; color: #484F58 !important; min-width: 18px; padding-top: 2px; }
.nav-item.active .nav-num { color: #C9A84C !important; }
.nav-label { font-size: 0.76rem; color: #6E7681 !important; line-height: 1.4; }
.nav-item.active .nav-label { color: #E6EDF3 !important; font-weight: 500; }

/* progress */
.sb-progress { padding: 14px 20px 10px; border-top: 1px solid #21262D; margin-top: 6px; }
.sb-progress-label { font-size: 0.62rem; color: #484F58 !important; letter-spacing: 0.08em; text-transform: uppercase; margin-bottom: 7px; display: flex; justify-content: space-between; }
.sb-progress-track { height: 2px; background: #21262D; border-radius: 1px; overflow: hidden; }
.sb-progress-fill { height: 100%; background: linear-gradient(90deg, #C9A84C, #E8C96A); border-radius: 1px; }

/* ═══ MAIN CANVAS ════════════════════════════════════════════════════════════ */
.slide-canvas { padding: 40px 64px 60px; max-width: 1080px; }

.slide-tag {
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.62rem; letter-spacing: 0.18em; text-transform: uppercase;
    color: #C9A84C; margin-bottom: 10px; display: block;
}
.slide-title {
    font-family: 'DM Serif Display', serif;
    font-size: 2.6rem; font-weight: 400;
    color: #E6EDF3; line-height: 1.15; margin-bottom: 4px;
}
.stage-bar {
    width: 56px; height: 3px;
    background: linear-gradient(90deg, #C9A84C, #E8C96A);
    border-radius: 2px; margin: 14px 0 28px;
}

/* point list */
.point-list { display: flex; flex-direction: column; gap: 8px; }
.point-row {
    display: flex; align-items: flex-start; gap: 14px;
    padding: 14px 18px;
    background: #161B22; border: 1px solid #21262D; border-radius: 8px;
}
.point-dot { width: 6px; height: 6px; min-width: 6px; background: #C9A84C; border-radius: 50%; margin-top: 8px; }
.point-text { font-size: 0.97rem; color: #C9D1D9; line-height: 1.65; }

/* insight box */
.insight-box {
    background: #161B22; border: 1px solid #21262D;
    border-left: 3px solid #C9A84C; border-radius: 8px;
    padding: 18px 22px; margin: 16px 0;
}
.insight-tag { font-family: 'JetBrains Mono', monospace; font-size: 0.58rem; letter-spacing: 0.14em; text-transform: uppercase; color: #C9A84C; margin-bottom: 8px; display: block; }
.insight-text { font-size: 0.93rem; color: #8B949E; line-height: 1.75; }

/* role cards */
.role-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; margin-top: 6px; }
.role-card { background: #161B22; border: 1px solid #21262D; border-radius: 10px; padding: 22px; position: relative; overflow: hidden; }
.role-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px; }
.role-card-admin::before   { background: #F85149; }
.role-card-landlord::before { background: #C9A84C; }
.role-card-tenant::before  { background: #3FB950; }
.role-badge { display: inline-block; font-family: 'JetBrains Mono', monospace; font-size: 0.58rem; letter-spacing: 0.12em; text-transform: uppercase; padding: 3px 7px; border-radius: 3px; margin-bottom: 10px; }
.badge-admin    { background: rgba(248,81,73,0.12);  color: #F85149; }
.badge-landlord { background: rgba(201,168,76,0.12); color: #C9A84C; }
.badge-tenant   { background: rgba(63,185,80,0.12);  color: #3FB950; }
.role-name { font-family: 'DM Serif Display', serif; font-size: 1.15rem; color: #E6EDF3; margin-bottom: 8px; }
.role-desc { font-size: 0.84rem; color: #6E7681; line-height: 1.7; }

/* schema table */
.schema-wrap { display: flex; flex-direction: column; gap: 8px; margin-top: 4px; }
.schema-block { background: #161B22; border: 1px solid #21262D; border-radius: 8px; overflow: hidden; }
.schema-head {
    display: flex; align-items: center; justify-content: space-between;
    padding: 12px 18px; background: #1C2333; border-bottom: 1px solid #21262D;
}
.schema-name { font-family: 'JetBrains Mono', monospace; font-size: 0.72rem; color: #C9A84C; letter-spacing: 0.1em; text-transform: uppercase; }
.schema-purpose { font-size: 0.75rem; color: #484F58; max-width: 55%; text-align: right; }
.field-row { display: flex; align-items: center; padding: 7px 18px; gap: 14px; border-bottom: 1px solid rgba(13,17,23,0.6); }
.field-row:last-child { border-bottom: none; }
.field-row:nth-child(even) { background: rgba(13,17,23,0.3); }
.field-name { font-family: 'JetBrains Mono', monospace; font-size: 0.76rem; color: #79C0FF; min-width: 220px; }
.field-type { font-family: 'JetBrains Mono', monospace; font-size: 0.74rem; color: #56D364; }

/* feature list */
.feature-list { display: flex; flex-direction: column; gap: 7px; }
.feature-row { display: flex; align-items: flex-start; gap: 14px; padding: 13px 18px; background: #161B22; border: 1px solid #21262D; border-radius: 8px; }
.feature-check { font-family: 'JetBrains Mono', monospace; font-size: 0.68rem; color: #3FB950; min-width: 16px; padding-top: 3px; }
.feature-text { font-size: 0.93rem; color: #C9D1D9; line-height: 1.55; }
.feature-text strong { color: #E6EDF3; }

/* future list */
.future-list { display: flex; flex-direction: column; gap: 7px; }
.future-row { display: flex; align-items: flex-start; gap: 16px; padding: 13px 18px; background: #161B22; border: 1px solid #21262D; border-radius: 8px; }
.future-num { font-family: 'DM Serif Display', serif; font-size: 1.05rem; color: #C9A84C; min-width: 24px; line-height: 1.5; }
.future-text { font-size: 0.93rem; color: #8B949E; line-height: 1.6; }
.future-text strong { color: #C9D1D9; }

/* flow steps */
.flow-list { display: flex; flex-direction: column; gap: 0; }
.flow-step { display: flex; align-items: flex-start; gap: 0; position: relative; }
.flow-step:not(:last-child)::after { content: ''; position: absolute; left: 18px; top: 38px; width: 1px; height: calc(100% - 4px); background: #21262D; }
.flow-circle { width: 36px; height: 36px; min-width: 36px; background: #161B22; border: 1px solid #C9A84C; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-family: 'JetBrains Mono', monospace; font-size: 0.68rem; color: #C9A84C; margin-right: 16px; position: relative; z-index: 1; }
.flow-content { padding: 6px 0 22px; flex: 1; }
.flow-text { font-size: 0.95rem; color: #C9D1D9; line-height: 1.6; }

/* nav buttons */
.nav-btn-row {
    display: flex; align-items: center; gap: 12px;
    margin-top: 48px; padding-top: 20px;
    border-top: 1px solid #21262D;
}
.nav-counter { font-family: 'JetBrains Mono', monospace; font-size: 0.68rem; color: #484F58; letter-spacing: 0.1em; margin: 0 auto; }

/* streamlit button overrides */
.stButton > button {
    background: #161B22 !important;
    border: 1px solid #30363D !important;
    color: #C9D1D9 !important;
    border-radius: 6px !important;
    font-family: 'JetBrains Mono', monospace !important;
    font-size: 0.72rem !important;
    letter-spacing: 0.08em !important;
    padding: 8px 20px !important;
    transition: all 0.15s !important;
}
.stButton > button:hover {
    background: #21262D !important;
    border-color: #C9A84C !important;
    color: #C9A84C !important;
}
.stButton > button:disabled {
    opacity: 0.3 !important;
    cursor: not-allowed !important;
}

/* slide footer */
.slide-footer { margin-top: 16px; display: flex; justify-content: space-between; align-items: center; }
.footer-left { font-family: 'JetBrains Mono', monospace; font-size: 0.6rem; color: #30363D; letter-spacing: 0.08em; }
.footer-right { font-size: 0.68rem; color: #30363D; }

/* streamlit radio hide */
div[data-testid="stRadio"] { display: none !important; }
.stCheckbox label { color: #6E7681 !important; font-size: 0.76rem !important; }
</style>
""", unsafe_allow_html=True)

def clean_title(t):
    return re.sub(r'^[\U0001F000-\U0001FFFF\u2600-\u26FF\u2700-\u27BF\s]+', '', t).strip()

TAGS = {
    "smart landlord":    "OVERVIEW",
    "problem":           "CONTEXT",
    "objectives":        "OBJECTIVES",
    "architecture":      "ARCHITECTURE",
    "flow":              "FLOW",
    "roles":             "ACCESS CONTROL",
    "features":          "FEATURES",
    "database design":   "DATABASE",
    "relationships":     "SCHEMA",
    "future":            "ROADMAP",
    "conclusion":        "SUMMARY",
}

def get_tag(title):
    tl = title.lower()
    for k, v in TAGS.items():
        if k in tl:
            return v
    return "SLIDE"

slide_titles = [s["title"] for s in slides]
idx = st.session_state.slide_idx
slide = slides[idx]

# ── SIDEBAR ────────────────────────────────────────────────────────────────────
with st.sidebar:
    st.markdown("""
    <div class="sb-header">
        <span class="sb-logo">Smart Landlord System</span>
        <span class="sb-sub">Academic Presentation &nbsp;·&nbsp; 2026</span>
        <div class="sb-author">Jimson John</div>
    </div>
    """, unsafe_allow_html=True)

    nav_html = ""
    for i, title in enumerate(slide_titles):
        active = "active" if i == idx else ""
        ct = clean_title(title)
        nav_html += f'<div class="nav-item {active}"><span class="nav-num">{str(i+1).zfill(2)}</span><span class="nav-label">{ct}</span></div>'
    st.markdown(nav_html, unsafe_allow_html=True)

    pct = int(((idx + 1) / total) * 100)
    st.markdown(f"""
    <div class="sb-progress">
        <div class="sb-progress-label"><span>PROGRESS</span><span>{idx+1} / {total}</span></div>
        <div class="sb-progress-track"><div class="sb-progress-fill" style="width:{pct}%"></div></div>
    </div>
    """, unsafe_allow_html=True)

    st.markdown("<div style='height:12px'></div>", unsafe_allow_html=True)
    show_schema = st.checkbox("View Database Schema", value=False)
    if show_schema:
        img_path = os.path.join(base_path, "image_7100aa.png")
        if os.path.exists(img_path):
            st.image(img_path, use_container_width=True)
        else:
            st.markdown("<div style='padding:10px 20px;font-size:0.72rem;color:#484F58'>Place image_7100aa.png in your project folder.</div>", unsafe_allow_html=True)

    # Sidebar quick-jump buttons
    st.markdown("<div style='height:16px'></div>", unsafe_allow_html=True)
    st.markdown("<div style='padding:0 20px 4px;font-size:0.6rem;color:#484F58;letter-spacing:0.1em;text-transform:uppercase'>Jump to slide</div>", unsafe_allow_html=True)
    cols = st.columns(5)
    for i in range(total):
        col = cols[i % 5]
        if col.button(str(i + 1), key=f"jump_{i}"):
            go_to(i)
            st.rerun()

# ── MAIN SLIDE ─────────────────────────────────────────────────────────────────
ct = clean_title(slide["title"])
tag = get_tag(slide["title"])

st.markdown(f"""
<div class="slide-canvas">
    <span class="slide-tag">{tag}</span>
    <h1 class="slide-title">{ct}</h1>
    <div class="stage-bar"></div>
""", unsafe_allow_html=True)

# ── BULLET POINTS ──────────────────────────────────────────────────────────────
is_flow_slide = "flow" in slide["title"].lower()

if "points" in slide and not is_flow_slide:
    rows = "".join(f'<div class="point-row"><div class="point-dot"></div><div class="point-text">{p}</div></div>' for p in slide["points"])
    st.markdown(f'<div class="point-list">{rows}</div>', unsafe_allow_html=True)

# ── FLOW STEPS ─────────────────────────────────────────────────────────────────
if "points" in slide and is_flow_slide:
    steps = ""
    for i, p in enumerate(slide["points"], 1):
        text = re.sub(r'^[①②③④⑤⑥\d\.\s]+', '', p).strip()
        steps += f'<div class="flow-step"><div class="flow-circle">{i:02d}</div><div class="flow-content"><div class="flow-text">{text}</div></div></div>'
    st.markdown(f'<div class="flow-list">{steps}</div>', unsafe_allow_html=True)

# ── INSIGHT BOX ────────────────────────────────────────────────────────────────
if "explanation" in slide:
    st.markdown(f"""
    <div class="insight-box">
        <span class="insight-tag">Key Insight</span>
        <div class="insight-text">{slide["explanation"]}</div>
    </div>""", unsafe_allow_html=True)

# ── ROLE CARDS ─────────────────────────────────────────────────────────────────
if "core_logic" in slide:
    cfg = {
        "admin":    ("role-card-admin",    "badge-admin",    "Admin"),
        "landlord": ("role-card-landlord", "badge-landlord", "Landlord"),
        "tenant":   ("role-card-tenant",   "badge-tenant",   "Tenant"),
    }
    cards = ""
    for key, val in slide["core_logic"].items():
        card_cls, badge_cls, label = cfg.get(key, ("role-card-admin", "badge-admin", key.title()))
        cards += f'<div class="role-card {card_cls}"><div class="role-badge {badge_cls}">{label.upper()}</div><div class="role-name">{label}</div><div class="role-desc">{val}</div></div>'
    st.markdown(f'<div class="role-grid">{cards}</div>', unsafe_allow_html=True)

# ── SCHEMA BREAKDOWN ───────────────────────────────────────────────────────────
if "schema_breakdown" in slide:
    blocks = ""
    for tier, details in slide["schema_breakdown"].items():
        label   = tier.replace("_", " ").upper()
        purpose = details.get("purpose", "")
        fields  = details.get("tables", [])
        rows_html = ""
        for item in fields:
            # Split on middle dot · or em dash —
            if " · " in item:
                parts = item.split(" · ", 1)
                fname, ftype = parts[0].strip(), parts[1].strip()
            elif " — " in item:
                parts = item.split(" — ", 1)
                fname, ftype = parts[0].strip(), parts[1].strip()
            else:
                fname, ftype = item.strip(), ""
            rows_html += f'<div class="field-row"><span class="field-name">{fname}</span><span class="field-type">{ftype}</span></div>'

        blocks += f"""
        <div class="schema-block">
            <div class="schema-head">
                <span class="schema-name">{label}</span>
                <span class="schema-purpose">{purpose}</span>
            </div>
            <div>{rows_html}</div>
        </div>"""
    st.markdown(f'<div class="schema-wrap">{blocks}</div>', unsafe_allow_html=True)

# ── FEATURES ───────────────────────────────────────────────────────────────────
if "automation_features" in slide:
    rows = ""
    for f in slide["automation_features"]:
        if " — " in f:
            name, rest = f.split(" — ", 1)
            text = f"<strong>{name.strip()}</strong> &mdash; {rest.strip()}"
        else:
            text = f
        rows += f'<div class="feature-row"><span class="feature-check">OK</span><div class="feature-text">{text}</div></div>'
    st.markdown(f'<div class="feature-list">{rows}</div>', unsafe_allow_html=True)

# ── FUTURE WORK ────────────────────────────────────────────────────────────────
if "future_work" in slide:
    rows = ""
    for i, item in enumerate(slide["future_work"], 1):
        if " — " in item:
            name, rest = item.split(" — ", 1)
            text = f"<strong>{name.strip()}</strong> &mdash; {rest.strip()}"
        else:
            text = item
        rows += f'<div class="future-row"><span class="future-num">{i:02d}</span><div class="future-text">{text}</div></div>'
    st.markdown(f'<div class="future-list">{rows}</div>', unsafe_allow_html=True)

# ── INFRASTRUCTURE ─────────────────────────────────────────────────────────────
if "infrastructure" in slide:
    rows = "".join(f'<div class="point-row"><div class="point-dot"></div><div class="point-text">{item}</div></div>' for item in slide["infrastructure"])
    st.markdown(f'<div class="point-list">{rows}</div>', unsafe_allow_html=True)

st.markdown('</div>', unsafe_allow_html=True)

# ── NAVIGATION BUTTONS ─────────────────────────────────────────────────────────
st.markdown("<div style='max-width:1080px;padding:0 64px'>", unsafe_allow_html=True)
col_prev, col_mid, col_next = st.columns([1, 3, 1])

with col_prev:
    if st.button("← PREV", disabled=(idx == 0), key="prev_btn"):
        go_to(idx - 1)
        st.rerun()

with col_mid:
    slide_label = clean_title(slide["title"]).upper()
    counter_html = f"<div style='text-align:center;font-family:JetBrains Mono,monospace;font-size:0.65rem;color:#484F58;letter-spacing:0.12em;padding-top:10px'>{slide_label} &middot; {idx+1} / {total}</div>"
    st.markdown(counter_html, unsafe_allow_html=True)

with col_next:
    if st.button("NEXT →", disabled=(idx == total - 1), key="next_btn"):
        go_to(idx + 1)
        st.rerun()

st.markdown("</div>", unsafe_allow_html=True)
