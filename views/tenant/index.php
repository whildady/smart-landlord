<?php
/** @var yii\web\View $this */
/** @var array $data */

use yii\helpers\Html;
use yii\helpers\Url; // HAPA: Kipengele hiki kilikuwa kimeondolewa, nimekirudisha

// Kupata route ya sasa inayotumika kwenye mfumo wa Tenant
$currentRoute = Yii::$app->controller->route;

$this->title = 'Tenant Dashboard - SmartLandlord';
?>

<style>
    .prodify-grid {
        background-color: #f8fafc; /* Rangi safi na tulivu ya kijivu hafifu */
    }
    .dark .prodify-grid {
        background-color: #0f172a; /* Rangi safi ya usiku (Deep Slate) */
    }
    
    /* Mfumo wa kisasa wa Skrola (Custom Scrollbar) kwa ajili ya kupandisha na kushusha sidebar */
    .sidebar-scroll::-webkit-scrollbar {
        width: 5px; /* Upana mdogo wa skrola ili isiharibu muonekano */
    }
    .sidebar-scroll::-webkit-scrollbar-track {
        background: transparent;
    }
    .sidebar-scroll::-webkit-scrollbar-thumb {
        background: #e2e8f0; /* Rangi laini ya skrola wakati wa kushusha/kupandisha */
        border-radius: 10px;
    }
    .sidebar-scroll:hover::-webkit-scrollbar-thumb {
        background: #cbd5e1; /* Inakuwa nzito kidogo mtumiaji akiweka kipanya (hover) */
    }
    .dark .sidebar-scroll::-webkit-scrollbar-thumb {
        background: #1e293b;
    }
    .dark .sidebar-scroll:hover::-webkit-scrollbar-thumb {
        background: #334155;
    }
</style>

<div class="min-h-screen flex text-slate-900 dark:text-slate-50 font-sans antialiased">
    
    <aside class="hidden lg:flex flex-col w-64 bg-white dark:bg-slate-900 border-r border-slate-200/80 dark:border-slate-800/80 fixed h-full z-40">
        <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex items-center gap-3 flex-shrink-0">
            <div class="w-10 h-10 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold shadow-sm">
                <?= strtoupper(substr($data['tenantName'] ?? 'TN', 0, 2)) ?>
            </div>
            <div class="overflow-hidden">
                <h4 class="text-sm font-bold text-slate-800 dark:text-white truncate"><?= Html::encode($data['tenantName'] ?? 'Tenant User') ?></h4>
                <span class="text-xs text-slate-400 block truncate"><?= Html::encode($data['tenantEmail'] ?? 'tenant@smartlandlord.com') ?></span>
            </div>
        </div>

      <nav class="flex-1 px-4 py-6 space-y-6 overflow-y-auto sidebar-scroll">
            
    <!-- OVERVIEW SECTION -->
    <div class="tenant-menu-group">
        <button type="button" class="flex items-center justify-between w-full px-4 mb-2 focus:outline-hidden toggle-tenant-menu">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">Overview</span>
            <i data-lucide="chevron-down" class="w-3 h-3 text-slate-400 transition-transform duration-200 tenant-arrow"></i>
        </button>
    </div>

    <!-- FINANCE HUB SECTION -->
    <?php 
    $financeRoutes = ['tenant/rent-payments', 'tenant/utility-luku', 'tenant/dawasa-water', 'tenant/payment-history'];
    $isFinanceOpen = in_array($currentRoute, $financeRoutes);
    ?>
    <div class="tenant-menu-group">
        <button type="button" class="flex items-center justify-between w-full px-4 mb-2 focus:outline-hidden toggle-tenant-menu">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">Finance Hub</span>
            <!-- IMESASISHWA: Mshale sasa unabadilika ukiwa wazi au umefungwa wakati wa kupakiza ukurasa -->
            <i data-lucide="<?= $isFinanceOpen ? 'chevron-down' : 'chevron-right' ?>" class="w-3 h-3 text-slate-400 transition-transform duration-200 tenant-arrow"></i>
        </button>
        <div class="space-y-1 tenant-menu-content <?= $isFinanceOpen ? '' : 'hidden' ?>">
            <?php $isRent = ($currentRoute === 'tenant/rent-payments'); ?>
            <a href="<?= Url::to(['/tenant/rent-payments']) ?>" class="flex items-center justify-between px-4 py-3 text-sm rounded-xl transition-all duration-300 group <?= $isRent ? 'bg-indigo-50/80 dark:bg-indigo-950/40 text-indigo-900 dark:text-indigo-200 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-50/80 dark:hover:bg-slate-800/50 font-medium' ?>">
                <div class="flex items-center gap-3">
                    <i data-lucide="credit-card" class="w-4 h-4 transition-colors <?= $isRent ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-300' ?>"></i>
                    Rent Payments
                </div>
                <span class="text-[10px] bg-rose-100 text-rose-700 dark:bg-rose-950/40 dark:text-rose-400 font-bold px-2 py-0.5 rounded-full">1 Due</span>
            </a>
            
            <?php $isLuku = ($currentRoute === 'tenant/utility-luku'); ?>
            <a href="<?= Url::to(['/tenant/utility-luku']) ?>" class="flex items-center gap-3 px-4 py-3 text-sm rounded-xl transition-all duration-300 group <?= $isLuku ? 'bg-indigo-50/80 dark:bg-indigo-950/40 text-indigo-900 dark:text-indigo-200 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-50/80 dark:hover:bg-slate-800/50 font-medium' ?>">
                <i data-lucide="zap" class="w-4 h-4 transition-colors <?= $isLuku ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-300' ?>"></i>
                Utility & LUKU
            </a>
            
            <?php $isWater = ($currentRoute === 'tenant/dawasa-water'); ?>
            <a href="<?= Url::to(['/tenant/dawasa-water']) ?>" class="flex items-center gap-3 px-4 py-3 text-sm rounded-xl transition-all duration-300 group <?= $isWater ? 'bg-indigo-50/80 dark:bg-indigo-950/40 text-indigo-900 dark:text-indigo-200 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-50/80 dark:hover:bg-slate-800/50 font-medium' ?>">
                <i data-lucide="droplet" class="w-4 h-4 transition-colors <?= $isWater ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-300' ?>"></i>
                DAWASA & Water
            </a>
            
            <?php $isHistory = ($currentRoute === 'tenant/payment-history'); ?>
            <a href="<?= Url::to(['/tenant/payment-history']) ?>" class="flex items-center gap-3 px-4 py-3 text-sm rounded-xl transition-all duration-300 group <?= $isHistory ? 'bg-indigo-50/80 dark:bg-indigo-950/40 text-indigo-900 dark:text-indigo-200 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-50/80 dark:hover:bg-slate-800/50 font-medium' ?>">
                <i data-lucide="history" class="w-4 h-4 transition-colors <?= $isHistory ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-300' ?>"></i>
                Payment History
            </a>
        </div>
    </div>

    <!-- APPS SECTION -->
    <?php 
    $appsRoutes = ['tenant/mail', 'tenant/chat', 'tenant/files', 'tenant/kanban', 'tenant/calendar', 'tenant/wizard', 'tenant/forms'];
    $isAppsOpen = in_array($currentRoute, $appsRoutes);
    ?>
    <div class="tenant-menu-group">
        <button type="button" class="flex items-center justify-between w-full px-4 mb-2 focus:outline-hidden toggle-tenant-menu">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">Apps</span>
            <i data-lucide="<?= $isAppsOpen ? 'chevron-down' : 'chevron-right' ?>" class="w-3 h-3 text-slate-400 transition-transform duration-200 tenant-arrow"></i>
        </button>
        <div class="space-y-1 tenant-menu-content <?= $isAppsOpen ? '' : 'hidden' ?>">
            <?php $isMail = ($currentRoute === 'tenant/mail'); ?>
            <a href="<?= Url::to(['/tenant/mail']) ?>" class="flex items-center gap-3 px-4 py-3 text-sm rounded-xl transition-all duration-300 group <?= $isMail ? 'bg-indigo-50/80 dark:bg-indigo-950/40 text-indigo-900 dark:text-indigo-200 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-50/80 dark:hover:bg-slate-800/50 font-medium' ?>">
                <i data-lucide="mail" class="w-4 h-4 transition-colors <?= $isMail ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-300' ?>"></i>
                Mail
            </a>
            
            <?php $isChat = ($currentRoute === 'tenant/chat'); ?>
            <a href="<?= Url::to(['/tenant/chat']) ?>" class="flex items-center gap-3 px-4 py-3 text-sm rounded-xl transition-all duration-300 group <?= $isChat ? 'bg-indigo-50/80 dark:bg-indigo-950/40 text-indigo-900 dark:text-indigo-200 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-50/80 dark:hover:bg-slate-800/50 font-medium' ?>">
                <i data-lucide="message-square" class="w-4 h-4 transition-colors <?= $isChat ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-300' ?>"></i>
                Chat Center
            </a>
            
            <?php $isFiles = ($currentRoute === 'tenant/files'); ?>
            <a href="<?= Url::to(['/tenant/files']) ?>" class="flex items-center gap-3 px-4 py-3 text-sm rounded-xl transition-all duration-300 group <?= $isFiles ? 'bg-indigo-50/80 dark:bg-indigo-950/40 text-indigo-900 dark:text-indigo-200 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-50/80 dark:hover:bg-slate-800/50 font-medium' ?>">
                <i data-lucide="folder" class="w-4 h-4 transition-colors <?= $isFiles ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-300' ?>"></i>
                Files Cloud
            </a>
            
            <?php $isKanban = ($currentRoute === 'tenant/kanban'); ?>
            <a href="<?= Url::to(['/tenant/kanban']) ?>" class="flex items-center gap-3 px-4 py-3 text-sm rounded-xl transition-all duration-300 group <?= $isKanban ? 'bg-indigo-50/80 dark:bg-indigo-950/40 text-indigo-900 dark:text-indigo-200 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-50/80 dark:hover:bg-slate-800/50 font-medium' ?>">
                <i data-lucide="trello" class="w-4 h-4 transition-colors <?= $isKanban ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-300' ?>"></i>
                Kanban Board
            </a>
            
            <?php $isCalendar = ($currentRoute === 'tenant/calendar'); ?>
            <a href="<?= Url::to(['/tenant/calendar']) ?>" class="flex items-center gap-3 px-4 py-3 text-sm rounded-xl transition-all duration-300 group <?= $isCalendar ? 'bg-indigo-50/80 dark:bg-indigo-950/40 text-indigo-900 dark:text-indigo-200 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-50/80 dark:hover:bg-slate-800/50 font-medium' ?>">
                <i data-lucide="calendar" class="w-4 h-4 transition-colors <?= $isCalendar ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-300' ?>"></i>
                Calendar
            </a>
            
            <?php $isWizard = ($currentRoute === 'tenant/wizard'); ?>
            <a href="<?= Url::to(['/tenant/wizard']) ?>" class="flex items-center gap-3 px-4 py-3 text-sm rounded-xl transition-all duration-300 group <?= $isWizard ? 'bg-indigo-50/80 dark:bg-indigo-950/40 text-indigo-900 dark:text-indigo-200 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-50/80 dark:hover:bg-slate-800/50 font-medium' ?>">
                <i data-lucide="wand-2" class="w-4 h-4 transition-colors <?= $isWizard ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-300' ?>"></i>
                Wizard
            </a>
            
            <?php $isForms = ($currentRoute === 'tenant/forms'); ?>
            <a href="<?= Url::to(['/tenant/forms']) ?>" class="flex items-center gap-3 px-4 py-3 text-sm rounded-xl transition-all duration-300 group <?= $isForms ? 'bg-indigo-50/80 dark:bg-indigo-950/40 text-indigo-900 dark:text-indigo-200 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-50/80 dark:hover:bg-slate-800/50 font-medium' ?>">
                <i data-lucide="file-signature" class="w-4 h-4 transition-colors <?= $isForms ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-300' ?>"></i>
                Forms
            </a>
        </div>
    </div>

    <!-- MANAGEMENT SECTION -->
    <?php 
    $mgtRoutes = ['tenant/maintenance', 'tenant/notice-board', 'tenant/lease-agreement'];
    $isMgtOpen = in_array($currentRoute, $mgtRoutes);
    ?>
    <div class="tenant-menu-group">
        <button type="button" class="flex items-center justify-between w-full px-4 mb-2 focus:outline-hidden toggle-tenant-menu">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">Management</span>
            <i data-lucide="<?= $isMgtOpen ? 'chevron-down' : 'chevron-right' ?>" class="w-3 h-3 text-slate-400 transition-transform duration-200 tenant-arrow"></i>
        </button>
        <div class="space-y-1 tenant-menu-content <?= $isMgtOpen ? '' : 'hidden' ?>">
            <?php $isMaintenance = ($currentRoute === 'tenant/maintenance'); ?>
            <a href="<?= Url::to(['/tenant/maintenance']) ?>" class="flex items-center justify-between px-4 py-3 text-sm rounded-xl transition-all duration-300 group <?= $isMaintenance ? 'bg-indigo-50/80 dark:bg-indigo-950/40 text-indigo-900 dark:text-indigo-200 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-50/80 dark:hover:bg-slate-800/50 font-medium' ?>">
                <div class="flex items-center gap-3">
                    <i data-lucide="wrench" class="w-4 h-4 transition-colors <?= $isMaintenance ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-300' ?>"></i>
                    Maintenance
                </div>
                <span class="text-[10px] bg-amber-100 text-amber-800 dark:bg-amber-950/40 dark:text-amber-400 font-bold px-2 py-0.5 rounded-full">WIP</span>
            </a>
            
            <?php $isNotice = ($currentRoute === 'tenant/notice-board'); ?>
            <a href="<?= Url::to(['/tenant/notice-board']) ?>" class="flex items-center gap-3 px-4 py-3 text-sm rounded-xl transition-all duration-300 group <?= $isNotice ? 'bg-indigo-50/80 dark:bg-indigo-950/40 text-indigo-900 dark:text-indigo-200 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-50/80 dark:hover:bg-slate-800/50 font-medium' ?>">
                <i data-lucide="megaphone" class="w-4 h-4 transition-colors <?= $isNotice ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-300' ?>"></i>
                Notice Board
            </a>
            
            <?php $isLease = ($currentRoute === 'tenant/lease-agreement'); ?>
            <a href="<?= Url::to(['/tenant/lease-agreement']) ?>" class="flex items-center gap-3 px-4 py-3 text-sm rounded-xl transition-all duration-300 group <?= $isLease ? 'bg-indigo-50/80 dark:bg-indigo-950/40 text-indigo-900 dark:text-indigo-200 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-50/80 dark:hover:bg-slate-800/50 font-medium' ?>">
                <i data-lucide="file-text" class="w-4 h-4 transition-colors <?= $isLease ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-300' ?>"></i>
                Lease Agreement
            </a>
        </div>
    </div>
    
    <div class="pt-2 border-t border-slate-100 dark:border-slate-800/60 my-2"></div>

    <!-- SETTINGS SECTION -->
    <div>
        <?php $isSettings = ($currentRoute === 'tenant/settings'); ?>
        <a href="<?= Url::to(['/tenant/settings']) ?>" class="flex items-center gap-3 px-4 py-3 text-sm rounded-xl transition-all duration-300 group <?= $isSettings ? 'bg-indigo-50/80 dark:bg-indigo-950/40 text-indigo-900 dark:text-indigo-200 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-50/80 dark:hover:bg-slate-800/50 font-medium' ?>">
            <i data-lucide="settings" class="w-4 h-4 transition-colors <?= $isSettings ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-300' ?>"></i>
            Settings
        </a>
    </div>
</nav>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="p-4 border-t border-slate-100 dark:border-slate-800/60 bg-gradient-to-b from-transparent to-slate-50/50 dark:to-slate-900/40">
    <form id="logout-form" action="<?= \yii\helpers\Url::to(['/site/logout']) ?>" method="post" style="display: none;">
        <?= \yii\helpers\Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>
    </form>

    <a href="#" 
       onclick="handleInstagramLogout(event)" 
       class="flex items-center justify-between px-4 py-3 text-xs font-bold uppercase tracking-wider text-rose-600 hover:text-rose-700 bg-transparent hover:bg-rose-500/[0.06] dark:hover:bg-rose-500/[0.08] rounded-xl transition-all duration-300 ease-out group select-none cursor-pointer">
        
        <div class="flex items-center">
            <i data-lucide="log-out" class="w-4 h-4 mr-3 stroke-[2.5] group-hover:translate-x-0.5 group-hover:scale-105 transition-all duration-300 ease-out text-rose-500 dark:text-rose-400"></i>
            <span>Sign Out</span>
        </div>
        <i data-lucide="chevron-right" class="w-3.5 h-3.5 opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300 ease-out text-rose-400"></i>
    </a>
</div>

<script>
function handleInstagramLogout(event) {
    event.preventDefault();

    // Kuchukua data kwa usalama kutoka PHP
    const currentEmail = "<?= isset($data['tenantEmail']) ? \yii\helpers\Html::encode($data['tenantEmail']) : 'tenant@smartlandlord.com' ?>";
    const currentName = "<?= isset($data['tenantName']) ? \yii\helpers\Html::encode($data['tenantName']) : 'Tenant' ?>";

    // Kusanidi muonekano wa SweetAlert (Herufi mbili tu: Swal)
    const SwalInstagram = Swal.mixin({
        customClass: {
            popup: 'rounded-3xl border border-slate-100 dark:border-slate-800 bg-white dark:bg-slate-900 font-sans text-slate-800 dark:text-white p-6',
            title: 'text-lg font-bold text-slate-900 dark:text-white pt-2',
            htmlContainer: 'text-sm text-slate-500 dark:text-slate-400 my-3',
            confirmButton: 'px-5 py-2.5 text-xs font-bold uppercase tracking-wider rounded-xl mx-2 bg-rose-600 text-white hover:bg-rose-700 transition-colors',
            cancelButton: 'px-5 py-2.5 text-xs font-bold uppercase tracking-wider rounded-xl mx-2 bg-slate-500 text-white hover:bg-slate-600 transition-colors'
        },
        buttonsStyling: false // Ili itumie madarasa yetu ya Tailwind hapo juu
    });

    // 1. Popup ya kwanza: Kuuliza kama ana uhakika
    SwalInstagram.fire({
        title: 'Log out of your account?',
        text: `You will need to enter your password next time you log in as ${currentName}.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Log Out',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            
            // 2. Popup ya pili: Save login info?
            SwalInstagram.fire({
                title: 'Save Login Info?',
                text: "We'll remember your login details so you won't need to enter them again.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Save Info',
                cancelButtonText: 'Not Now',
                // Kubadilisha rangi ya kitufe kuwa ya Blue kwa ajili ya "Save Info"
                customClass: {
                    popup: 'rounded-3xl border border-slate-100 dark:border-slate-800 bg-white dark:bg-slate-900 font-sans text-slate-800 dark:text-white p-6',
                    title: 'text-lg font-bold text-slate-900 dark:text-white pt-2',
                    htmlContainer: 'text-sm text-slate-500 dark:text-slate-400 my-3',
                    confirmButton: 'px-5 py-2.5 text-xs font-bold uppercase tracking-wider rounded-xl mx-2 bg-blue-600 text-white hover:bg-blue-700 transition-colors',
                    cancelButton: 'px-5 py-2.5 text-xs font-bold uppercase tracking-wider rounded-xl mx-2 bg-slate-500 text-white hover:bg-slate-600 transition-colors'
                }
            }).then((saveResult) => {
                if (saveResult.isConfirmed) {
                    // Kuhifadhi kweli kwenye LocalStorage
                    localStorage.setItem('saved_tenant_email', currentEmail);
                    localStorage.setItem('saved_tenant_name', currentName);
                    localStorage.setItem('remember_me', 'true');
                    
                    document.getElementById('logout-form').submit();
                } else {
                    // Futa kama amekataa
                    localStorage.removeItem('saved_tenant_email');
                    localStorage.removeItem('saved_tenant_name');
                    localStorage.removeItem('remember_me');
                    
                    document.getElementById('logout-form').submit();
                }
            });

        }
    });
}
</script>

<script>
    document.querySelectorAll('.toggle-tenant-menu').forEach(btn => {
        btn.addEventListener('click', () => {
            const group = btn.closest('.tenant-menu-group');
            const content = group.querySelector('.tenant-menu-content');
            const arrow = btn.querySelector('.tenant-arrow');
            
            content.classList.toggle('hidden');
            
            if (content.classList.contains('hidden')) {
                arrow.setAttribute('data-lucide', 'chevron-right');
            } else {
                arrow.setAttribute('data-lucide', 'chevron-down');
            }
            
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    });
</script>
    </aside>

    <div class="flex-1 lg:pl-64 min-h-screen prodify-grid pb-24 md:pb-12">
        
        <header class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border-b border-slate-200/60 dark:border-slate-800/60 sticky top-0 z-30 px-6 py-4">
            <div class="max-w-5xl mx-auto flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <span class="text-xs font-semibold text-slate-400 block"><?= date('D, M d, Y') ?></span>
                    <h1 class="text-2xl font-black tracking-tight text-slate-900 dark:text-white mt-0.5">
                        Hello, <?= Html::encode(explode(' ', $data['tenantName'] ?? 'User')[0]) ?>
                    </h1>
                    <p class="text-sm text-indigo-600 dark:text-indigo-400 font-medium">Everything looks good with your residence today.</p>
                </div>
                
                <div class="flex flex-wrap gap-2">
                    <button class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold px-4 py-2 rounded-full shadow-sm transition-all active:scale-95">
                        ✨ Ask AI Assistant
                    </button>
                    <button class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-200 text-xs font-bold px-4 py-2 rounded-full shadow-2xs hover:bg-slate-50 transition-all">
                        💬 Contact Admin
                    </button>
                </div>
            </div>
        </header>

        <main class="max-w-5xl mx-auto px-6 mt-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2 space-y-8">
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    
                    <div class="bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800/80 rounded-2xl p-5 shadow-2xs flex flex-col justify-between">
                        <div>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">My Residence</span>
                            <h3 class="text-lg font-bold text-slate-800 dark:text-white mt-1"><?= Html::encode($data['propertyName'] ?? 'N/A') ?></h3>
                            <p class="text-xs text-slate-500 mt-1"><?= Html::encode($data['unitNumber'] ?? 'N/A') ?></p>
                        </div>
                        <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-800">
                            <span class="text-xs font-semibold bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400 px-2.5 py-1 rounded-md">Active Lease</span>
                        </div>
                    </div>

                    <div class="md:col-span-2 bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800/80 rounded-2xl p-5 shadow-2xs flex flex-col justify-between relative overflow-hidden">
                        <div class="flex justify-between items-start">
                            <div>
                                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Upcoming Rent Invoice</span>
                                <h2 class="text-2xl font-black tracking-tight text-slate-900 dark:text-white mt-1"><?= Html::encode($data['rentAmount'] ?? 'Tsh 0') ?></h2>
                                <p class="text-xs text-slate-400 mt-0.5">Due Date: <?= Html::encode($data['dueDate'] ?? 'N/A') ?></p>
                            </div>
                            <span class="px-2.5 py-1 rounded-md text-[11px] font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-950/40 dark:text-emerald-400">
                                ● <?= Html::encode($data['rentStatus'] ?? 'Unknown') ?>
                            </span>
                        </div>
                        <div class="mt-6 flex justify-end gap-2">
                            <button class="bg-slate-900 hover:bg-slate-800 dark:bg-white dark:hover:bg-slate-100 text-white dark:text-slate-900 text-xs font-bold px-4 py-2.5 rounded-xl transition-all shadow-sm">
                                Pay via Mobile Money
                            </button>
                        </div>
                    </div>
                </div>

                <div class="bg-amber-50/60 dark:bg-amber-950/20 border border-amber-200/60 dark:border-amber-900/40 rounded-2xl p-5">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <span class="text-2xl">⚡</span>
                            <div>
                                <h4 class="text-sm font-bold text-amber-900 dark:text-amber-200">Current LUKU Token</h4>
                                <p class="text-xs text-amber-700/80 dark:text-amber-400/80 mt-0.5">Electricity prepaid token uploaded by management.</p>
                            </div>
                        </div>
                        <div class="bg-white dark:bg-slate-900 border border-amber-200 dark:border-amber-800/60 font-mono text-sm font-bold px-4 py-2.5 rounded-xl text-center tracking-wider text-slate-800 dark:text-amber-300 shadow-3xs select-all">
                            <?= Html::encode($data['lukuToken'] ?? '0000 - 0000 - 0000 - 0000') ?>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Service & Utility Bills</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <?php if (isset($data['utilityBills'])): foreach ($data['utilityBills'] as $bill): ?>
                            <div class="bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800/80 rounded-2xl p-4 flex items-center justify-between shadow-3xs">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-slate-50 dark:bg-slate-800 flex items-center justify-center text-lg">
                                        <?= $bill['icon'] ?>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-slate-800 dark:text-slate-200"><?= Html::encode($bill['name']) ?></h4>
                                        <p class="text-xs text-slate-400 font-semibold mt-0.5"><?= Html::encode($bill['amount']) ?></p>
                                    </div>
                                </div>
                                <span class="text-[11px] font-bold px-2.5 py-1 rounded-md <?= $bill['status'] === 'Paid' ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/30 dark:text-emerald-400' : 'bg-rose-50 text-rose-700 dark:bg-rose-950/30 dark:text-rose-400' ?>">
                                    <?= Html::encode($bill['status']) ?>
                                </span>
                            </div>
                        <?php endforeach; endif; ?>
                    </div>
                </div>
            </div>

            <div class="space-y-8">
                
                <div class="bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800/80 rounded-2xl p-5 shadow-2xs">
                    <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100 dark:border-slate-800">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">Notice Board</h3>
                        <span class="w-2 h-2 rounded-full bg-indigo-600 animate-pulse"></span>
                    </div>
                    <div class="space-y-4">
                        <?php if (isset($data['announcements'])): foreach ($data['announcements'] as $announce): ?>
                            <div class="space-y-1">
                                <div class="flex justify-between items-center">
                                    <h4 class="text-xs font-bold text-slate-800 dark:text-slate-200"><?= Html::encode($announce['title']) ?></h4>
                                    <span class="text-[10px] font-medium text-slate-400"><?= Html::encode($announce['date']) ?></span>
                                </div>
                                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed"><?= Html::encode($announce['body']) ?></p>
                            </div>
                            <hr class="border-slate-100 dark:border-slate-800 last:hidden">
                        <?php endforeach; endif; ?>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800/80 rounded-2xl p-5 shadow-2xs space-y-4">
                    <div class="flex justify-between items-center">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">Maintenance</h3>
                        <button class="text-xs font-bold text-indigo-600 dark:text-indigo-400 hover:underline">
                            + File Request
                        </button>
                    </div>

                    <div class="space-y-3">
                        <?php if (isset($data['recentRequests'])): foreach ($data['recentRequests'] as $request): ?>
                            <div class="p-3.5 bg-slate-50 dark:bg-slate-800/40 border border-slate-100 dark:border-slate-800 rounded-xl space-y-2">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <span class="text-[9px] uppercase font-bold text-indigo-600 dark:text-indigo-400 tracking-wider"><?= Html::encode($request['type']) ?></span>
                                        <h4 class="text-xs font-bold text-slate-800 dark:text-slate-200 mt-0.5"><?= Html::encode($request['title']) ?></h4>
                                    </div>
                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-md bg-amber-100 text-amber-800 dark:bg-amber-950/40 dark:text-amber-400">
                                        <?= Html::encode($request['status']) ?>
                                    </span>
                                </div>
                                <p class="text-[11px] text-slate-400 font-medium pt-1.5 border-t border-slate-200/40 dark:border-slate-700/60">
                                    Reported: <?= Html::encode($request['date']) ?>
                                </p>
                            </div>
                        <?php endforeach; endif; ?>
                    </div>
                </div>
            </div>
        </main>
    </div>

</div>