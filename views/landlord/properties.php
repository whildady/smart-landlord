<?php
/** @var yii\web\View $this */
use yii\helpers\Url;
use yii\helpers\Html;
$currentRoute = Yii::$app->controller->route;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Properties | Smart Landlord</title>
    <!-- Production-Stable Tailwind v3 Script Tag -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Lucide Icons for clean micro-interactions -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        /* Premium Global Animations aligning with Dashboard */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(16px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-fade-in-up {
            animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        /* Custom smooth scrollbar for premium feel */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>
<body class="bg-[#f8fafc] font-sans antialiased text-slate-900 flex min-h-screen relative overflow-x-hidden">

    <!-- FIXED PREMIUM SIDEBAR -->
    <aside id="sidebarNav" class="w-64 bg-white border-r border-slate-100 flex flex-col justify-between fixed top-0 left-0 h-screen z-50 shadow-2xl lg:shadow-none transform -translate-x-full lg:translate-x-0 transition-all duration-300 ease-in-out">
        <div class="flex flex-col h-full">
            <!-- Sidebar Header -->
            <div class="h-16 flex items-center justify-between px-6 border-b border-slate-50">
                <span class="text-xs font-bold tracking-widest text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-violet-600 uppercase flex items-center gap-2.5">
                    <div class="w-2.5 h-2.5 bg-indigo-600 rounded-md animate-bounce"></div>
                    <span>Smart Landlord</span>
                </span>
                <button onclick="toggleSidebar(event)" class="lg:hidden text-slate-400 hover:text-slate-600 cursor-pointer p-1.5 rounded-xl hover:bg-slate-50 transition-all" title="Close Menu">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
            
            <!-- Navigation Links with Micro-interactions -->
      <nav class="p-4 space-y-4 flex-1 overflow-y-auto sidebar-scroll">
                
    <div class="menu-group">
        <button type="button" class="flex items-center justify-between w-full px-4 mb-2 focus:outline-hidden toggle-menu-btn">
            <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Core Modules</span>
            <i data-lucide="chevron-down" class="w-3 h-3 text-slate-400 transition-transform duration-200 arrow-icon"></i>
        </button>
        <div class="space-y-1 menu-content">
            <?php $isDashboard = ($currentRoute === 'landlord/dashboard'); ?>
            <a href="<?= Url::to(['/landlord/dashboard']) ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs transition-all duration-300 group <?= $isDashboard ? 'bg-indigo-50/80 dark:bg-indigo-950/40 text-indigo-900 dark:text-indigo-200 font-semibold' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-50/80 dark:hover:bg-slate-800/50 font-medium' ?>">
                <i data-lucide="layout-dashboard" class="w-4 h-4 transition-colors <?= $isDashboard ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-300' ?>"></i>
                Dashboard
            </a>
            
            <?php $isProperties = ($currentRoute === 'landlord/properties'); ?>
            <a href="<?= Url::to(['/landlord/properties']) ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs transition-all duration-300 group <?= $isProperties ? 'bg-indigo-50/80 dark:bg-indigo-950/40 text-indigo-900 dark:text-indigo-200 font-semibold' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-50/80 dark:hover:bg-slate-800/50 font-medium' ?>">
                <i data-lucide="building-2" class="w-4 h-4 transition-colors <?= $isProperties ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-300' ?>"></i>
                My Properties
            </a>
            
            <?php $isTenants = ($currentRoute === 'landlord/tenants'); ?>
            <a href="<?= Url::to(['/landlord/tenants']) ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs transition-all duration-300 group <?= $isTenants ? 'bg-indigo-50/80 dark:bg-indigo-950/40 text-indigo-900 dark:text-indigo-200 font-semibold' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-50/80 dark:hover:bg-slate-800/50 font-medium' ?>">
                <i data-lucide="users" class="w-4 h-4 transition-colors <?= $isTenants ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-300' ?>"></i>
                Tenants Management
            </a>
        </div>
    </div>

    <?php 
    $financeRoutes = ['landlord/invoices', 'landlord/utility-splitter', 'landlord/expenses', 'landlord/reports'];
    $isFinanceOpen = in_array($currentRoute, $financeRoutes);
    ?>
    <div class="menu-group">
        <button type="button" class="flex items-center justify-between w-full px-4 mb-2 focus:outline-hidden toggle-menu-btn">
            <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Finance & Billing</span>
            <i data-lucide="chevron-down" class="w-3 h-3 text-slate-400 transition-transform duration-200 arrow-icon" style="<?= $isFinanceOpen ? 'transform: rotate(90deg);' : '' ?>"></i>
        </button>
        <div class="space-y-1 menu-content <?= $isFinanceOpen ? '' : 'hidden' ?>">
            <?php $isInvoices = ($currentRoute === 'landlord/invoices'); ?>
            <a href="<?= Url::to(['/landlord/invoices']) ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs transition-all duration-300 group <?= $isInvoices ? 'bg-indigo-50/80 dark:bg-indigo-950/40 text-indigo-900 dark:text-indigo-200 font-semibold' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-50/80 dark:hover:bg-slate-800/50 font-medium' ?>">
                <i data-lucide="receipt" class="w-4 h-4 transition-colors <?= $isInvoices ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-300' ?>"></i>
                Invoices & Billing
            </a>
            
            <?php $isUtility = ($currentRoute === 'landlord/utility-splitter'); ?>
            <a href="<?= Url::to(['/landlord/utility-splitter']) ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs transition-all duration-300 group <?= $isUtility ? 'bg-indigo-50/80 dark:bg-indigo-950/40 text-indigo-900 dark:text-indigo-200 font-semibold' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-50/80 dark:hover:bg-slate-800/50 font-medium' ?>">
                <i data-lucide="zap" class="w-4 h-4 transition-colors <?= $isUtility ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-300' ?>"></i>
                Utility Splitter
            </a>

            <?php $isExpenses = ($currentRoute === 'landlord/expenses'); ?>
            <a href="<?= Url::to(['/landlord/expenses']) ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs transition-all duration-300 group <?= $isExpenses ? 'bg-indigo-50/80 dark:bg-indigo-950/40 text-indigo-900 dark:text-indigo-200 font-semibold' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-50/80 dark:hover:bg-slate-800/50 font-medium' ?>">
                <i data-lucide="wallet" class="w-4 h-4 transition-colors <?= $isExpenses ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-300' ?>"></i>
                Expenses Tracker
            </a>

            <?php $isReports = ($currentRoute === 'landlord/reports'); ?>
            <a href="<?= Url::to(['/landlord/reports']) ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs transition-all duration-300 group <?= $isReports ? 'bg-indigo-50/80 dark:bg-indigo-950/40 text-indigo-900 dark:text-indigo-200 font-semibold' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-50/80 dark:hover:bg-slate-800/50 font-medium' ?>">
                <i data-lucide="bar-chart-3" class="w-4 h-4 transition-colors <?= $isReports ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-300' ?>"></i>
                Financial Reports
            </a>
        </div>
    </div>

    <?php 
    $operationsRoutes = ['landlord/leases', 'landlord/maintenance', 'landlord/notices'];
    $isOperationsOpen = in_array($currentRoute, $operationsRoutes);
    ?>
    <div class="menu-group">
        <button type="button" class="flex items-center justify-between w-full px-4 mb-2 focus:outline-hidden toggle-menu-btn">
            <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Operations</span>
            <i data-lucide="chevron-right" class="w-3 h-3 text-slate-400 transition-transform duration-200 arrow-icon" style="<?= $isOperationsOpen ? 'transform: rotate(90deg);' : '' ?>"></i>
        </button>
        <div class="space-y-1 menu-content <?= $isOperationsOpen ? '' : 'hidden' ?>">
            <?php $isLeases = ($currentRoute === 'landlord/leases'); ?>
            <a href="<?= Url::to(['/landlord/leases']) ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs transition-all duration-300 group <?= $isLeases ? 'bg-indigo-50/80 dark:bg-indigo-950/40 text-indigo-900 dark:text-indigo-200 font-semibold' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-50/80 dark:hover:bg-slate-800/50 font-medium' ?>">
                <i data-lucide="file-text" class="w-4 h-4 transition-colors <?= $isLeases ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-300' ?>"></i>
                Lease Agreements
            </a>

            <?php $isMaintenance = ($currentRoute === 'landlord/maintenance'); ?>
            <a href="<?= Url::to(['/landlord/maintenance']) ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs transition-all duration-300 group <?= $isMaintenance ? 'bg-indigo-50/80 dark:bg-indigo-950/40 text-indigo-900 dark:text-indigo-200 font-semibold' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-50/80 dark:hover:bg-slate-800/50 font-medium' ?>">
                <i data-lucide="wrench" class="w-4 h-4 transition-colors <?= $isMaintenance ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-300' ?>"></i>
                Maintenance Tasks
            </a>

            <?php $isNotices = ($currentRoute === 'landlord/notices'); ?>
            <a href="<?= Url::to(['/landlord/notices']) ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs transition-all duration-300 group <?= $isNotices ? 'bg-indigo-50/80 dark:bg-indigo-950/40 text-indigo-900 dark:text-indigo-200 font-semibold' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-50/80 dark:hover:bg-slate-800/50 font-medium' ?>">
                <i data-lucide="megaphone" class="w-4 h-4 transition-colors <?= $isNotices ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-300' ?>"></i>
                Notice Broadcast
            </a>
        </div>
    </div>

    <?php 
    $appsRoutes = ['landlord/chat', 'landlord/documents', 'landlord/calendar'];
    $isAppsOpen = in_array($currentRoute, $appsRoutes);
    ?>
    <div class="menu-group">
        <button type="button" class="flex items-center justify-between w-full px-4 mb-2 focus:outline-hidden toggle-menu-btn">
            <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Apps & Tools</span>
            <i data-lucide="chevron-right" class="w-3 h-3 text-slate-400 transition-transform duration-200 arrow-icon" style="<?= $isAppsOpen ? 'transform: rotate(90deg);' : '' ?>"></i>
        </button>
        <div class="space-y-1 menu-content <?= $isAppsOpen ? '' : 'hidden' ?>">
            <?php $isChat = ($currentRoute === 'landlord/chat'); ?>
            <a href="<?= Url::to(['/landlord/chat']) ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs transition-all duration-300 group <?= $isChat ? 'bg-indigo-50/80 dark:bg-indigo-950/40 text-indigo-900 dark:text-indigo-200 font-semibold' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-50/80 dark:hover:bg-slate-800/50 font-medium' ?>">
                <i data-lucide="message-square" class="w-4 h-4 transition-colors <?= $isChat ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-300' ?>"></i>
                Tenant Chat Feed
            </a>

            <?php $isDocs = ($currentRoute === 'landlord/documents'); ?>
            <a href="<?= Url::to(['/landlord/documents']) ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs transition-all duration-300 group <?= $isDocs ? 'bg-indigo-50/80 dark:bg-indigo-950/40 text-indigo-900 dark:text-indigo-200 font-semibold' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-50/80 dark:hover:bg-slate-800/50 font-medium' ?>">
                <i data-lucide="folder-open" class="w-4 h-4 transition-colors <?= $isDocs ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-300' ?>"></i>
                Document Cloud
            </a>

            <?php $isCalendar = ($currentRoute === 'landlord/calendar'); ?>
            <a href="<?= Url::to(['/landlord/calendar']) ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs transition-all duration-300 group <?= $isCalendar ? 'bg-indigo-50/80 dark:bg-indigo-950/40 text-indigo-900 dark:text-indigo-200 font-semibold' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-50/80 dark:hover:bg-slate-800/50 font-medium' ?>">
                <i data-lucide="calendar" class="w-4 h-4 transition-colors <?= $isCalendar ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-300' ?>"></i>
                Event Calendar
            </a>
        </div>
    </div>

    <?php 
    $settingsRoutes = ['landlord/staff', 'landlord/settings'];
    $isSettingsOpen = in_array($currentRoute, $settingsRoutes);
    ?>
    <div class="menu-group">
        <button type="button" class="flex items-center justify-between w-full px-4 mb-2 focus:outline-hidden toggle-menu-btn">
            <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Settings</span>
            <i data-lucide="chevron-right" class="w-3 h-3 text-slate-400 transition-transform duration-200 arrow-icon" style="<?= $isSettingsOpen ? 'transform: rotate(90deg);' : '' ?>"></i>
        </button>
        <div class="space-y-1 menu-content <?= $isSettingsOpen ? '' : 'hidden' ?>">
            <?php $isStaff = ($currentRoute === 'landlord/staff'); ?>
            <a href="<?= Url::to(['/landlord/staff']) ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs transition-all duration-300 group <?= $isStaff ? 'bg-indigo-50/80 dark:bg-indigo-950/40 text-indigo-900 dark:text-indigo-200 font-semibold' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-50/80 dark:hover:bg-slate-800/50 font-medium' ?>">
                <i data-lucide="shield-check" class="w-4 h-4 transition-colors <?= $isStaff ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-300' ?>"></i>
                Staff & Permissions
            </a>

            <?php $isSettings = ($currentRoute === 'landlord/settings'); ?>
            <a href="<?= Url::to(['/landlord/settings']) ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs transition-all duration-300 group <?= $isSettings ? 'bg-indigo-50/80 dark:bg-indigo-950/40 text-indigo-900 dark:text-indigo-200 font-semibold' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-50/80 dark:hover:bg-slate-800/50 font-medium' ?>">
                <i data-lucide="settings" class="w-4 h-4 transition-colors <?= $isSettings ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-300' ?>"></i>
                System Settings
            </a>
        </div>
    </div>

</nav>

<script>
    document.querySelectorAll('.toggle-menu-btn').forEach(button => {
        button.addEventListener('click', () => {
            const group = button.closest('.menu-group');
            const content = group.querySelector('.menu-content');
            const arrow = button.querySelector('.arrow-icon');
            
            // Toggle kuficha na kuonesha menu links
            content.classList.toggle('hidden');
            
            // Mfumo wa kuzungusha kishale (kama kundi limefunguliwa au kufungwa)
            if (content.classList.contains('hidden')) {
                arrow.style.transform = 'rotate(0deg)';
            } else {
                arrow.style.transform = 'rotate(90deg)';
            }
        });
    });
</script>

            <!-- Sidebar Footer -->
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
        </div>
    </aside>
    <?= Html::beginForm(['/user/logout'], 'post', ['id' => 'logout-form', 'class' => 'hidden']) . Html::endForm() ?>

    <!-- MAIN CONTENT CONTAINER -->
    <div class="flex-1 flex flex-col min-w-0 w-full lg:pl-64">
        
        <!-- HEADER -->
        <header class="h-16 bg-white/80 backdrop-blur-md border-b border-slate-100 flex items-center justify-between px-8 sticky top-0 z-30">
            <div class="flex items-center gap-4">
                <button onclick="toggleSidebar(event)" id="menuBtn" class="lg:hidden text-slate-500 p-2 rounded-xl hover:bg-slate-50 cursor-pointer transition-all border border-slate-100" title="Open Navigation Menu">
                    <i data-lucide="menu" class="w-5 h-5"></i>
                </button>
                <h1 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Property Portfolio</h1>
                <div class="w-full sm:w-80 relative group">
                    <input type="text" id="searchInput" onkeyup="filterProperties()" placeholder="Search by property name or address..." class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:border-indigo-600 focus:bg-white transition-all shadow-2xs">
                    <div class="absolute left-3 top-2.5 text-slate-400 group-focus-within:text-indigo-600 transition-colors">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </div>
                </div>
            </div>
            
            <!-- PROFILE AREA -->
            <div class="flex items-center space-x-3.5 relative">
                <div class="text-right hidden sm:block">
                    <p class="text-xs font-semibold text-slate-800"><?php echo Html::encode(Yii::$app->user->identity->name ?? 'User'); ?></p>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mt-0.5"><?php echo Html::encode(Yii::$app->user->identity->role ?? 'Landlord'); ?></p>
                </div>
                
                <button onclick="toggleProfilePopup(event)" id="profileBtn" class="w-9 h-9 rounded-xl relative overflow-hidden shadow-sm border border-slate-200/60 group cursor-pointer block focus:outline-none transition-transform active:scale-95">
                    <?php if(false) : ?>
                        <img src="<?= Url::to(['/public/uploads/profile/']) ?><?php echo ''; ?>" alt="Profile" class="w-full h-full object-cover">
                    <?php else : ?>
                        <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Default Profile" class="w-full h-full object-cover">
                    <?php endif; ?>
                    <div class="absolute inset-0 bg-slate-950/0 group-hover:bg-slate-950/5 transition-colors duration-200"></div>
                </button>

                <!-- PROFILE POPUP -->
                <div id="profilePopup" class="absolute right-0 top-14 w-72 bg-white border border-slate-100 rounded-2xl shadow-2xl p-5 flex flex-col items-center space-y-4 transition-all duration-200 ease-out transform scale-95 opacity-0 pointer-events-none z-50 hidden">
                    <div class="w-full flex justify-between items-center pb-2 border-b border-slate-50">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Account Overview</span>
                        <button onclick="toggleProfilePopup(event)" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg hover:bg-slate-50 cursor-pointer">
                            <i data-lucide="x" class="w-4 h-4"></i>
                        </button>
                    </div>

                    <div class="w-14 h-14 rounded-xl relative overflow-hidden shadow-sm border border-slate-200">
                        <?php if(false) : ?>
                            <img src="<?= Url::to(['/public/uploads/profile/']) ?><?php echo ''; ?>" alt="Profile" class="w-full h-full object-cover">
                        <?php else : ?>
                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Default Profile" class="w-full h-full object-cover">
                        <?php endif; ?>
                    </div>

                    <div class="text-center">
                        <h4 class="text-xs font-semibold text-slate-900"><?php echo Html::encode(Yii::$app->user->identity->name ?? 'User'); ?></h4>
                        <p class="text-[10px] font-bold text-indigo-600 uppercase tracking-wider mt-0.5"><?php echo Html::encode(Yii::$app->user->identity->role ?? 'Landlord'); ?></p>
                    </div>

                    <form action="<?= Url::to(['/landlord/update-profile-image']) ?>" method="POST" enctype="multipart/form-data" class="w-full pt-1">
                <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>
                        <label class="w-full flex items-center justify-center gap-2 px-3 py-2.5 bg-slate-50 hover:bg-slate-100/80 text-slate-700 font-semibold text-xs rounded-xl transition-all cursor-pointer border border-slate-100 shadow-sm">
                            <i data-lucide="camera" class="w-3.5 h-3.5 text-slate-400"></i>
                            <span>Upload New Photo</span>
                            <input type="file" name="profile_image" accept="image/*" class="hidden" onchange="this.form.submit()">
                        </label>
                    </form>
                </div>
            </div>
        </header>

        <!-- MAIN CONTENT AREA -->
        <main class="p-8 max-w-7xl w-full mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8 animate-fade-in-up">
            
            <!-- LEFT AREA: PROPERTIES LIST -->
            <div class="lg:col-span-2 space-y-4">
                <h2 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Registered Properties</h2>
                
                <?php if(empty($properties)) : ?>
                    <div class="border border-dashed border-slate-200 rounded-2xl p-12 text-center bg-white shadow-sm flex flex-col items-center justify-center">
                        <div class="w-12 h-12 bg-slate-50 text-slate-400 rounded-xl flex items-center justify-center mb-4 border border-slate-100">
                            <i data-lucide="building" class="w-6 h-6"></i>
                        </div>
                        <p class="font-semibold text-xs text-slate-700">No properties registered under your portfolio yet.</p>
                        <p class="text-[11px] text-slate-400 mt-1">Fill out the structure setup matrix form to anchor assets.</p>
                    </div>
                <?php else : ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <?php foreach($properties as $property) : ?>
                            <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm hover:shadow-xl hover:-translate-y-1 hover:border-indigo-100 transition-all duration-300 flex flex-col justify-between relative group">
                                
                                <!-- Delete Trigger Button -->
                                <button type="button" 
                                        onclick="openPropertyDeleteModal('<?php echo $property->id; ?>', '<?php echo addslashes($property->name); ?>')" 
                                        class="absolute top-5 right-5 text-slate-400 hover:text-rose-600 p-2 rounded-xl hover:bg-rose-50/50 transition-all duration-200 cursor-pointer flex items-center justify-center border border-transparent hover:border-rose-100/30" 
                                        title="Delete Property">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>

                                <div>
                                    <span class="text-[9px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-lg <?php echo ($property->type == 'commercial') ? 'bg-amber-50 text-amber-700 border border-amber-100' : 'bg-indigo-50 text-indigo-700 border border-indigo-100'; ?>">
                                        <?php echo htmlspecialchars($property->type); ?>
                                    </span>
                                    <h3 class="text-sm font-bold text-slate-800 mt-4 tracking-tight pr-6"><?php echo htmlspecialchars($property->name); ?></h3>
                                    <p class="text-[11px] text-slate-400 mt-1.5 flex items-center gap-1.5 font-medium">
                                        <i data-lucide="map-pin" class="w-3.5 h-3.5 text-slate-300 shrink-0"></i>
                                        <span class="truncate"><?php echo htmlspecialchars($property->address); ?></span>
                                    </p>
                                </div>
                                
                                <div class="mt-6 pt-4 border-t border-slate-50 flex justify-between items-center">
                                    <span class="text-[10px] font-bold text-slate-500 bg-slate-50 px-2.5 py-0.5 rounded-lg border border-slate-100">
                                        <?php echo $property->total_units; ?> <?php echo ($property->total_units == 1) ? 'Unit' : 'Units'; ?>
                                    </span>
                                    <a href="<?= Url::to(['/landlord/units', 'property_id' => $property->id]) ?>" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700 transition-colors group-hover:translate-x-0.5 transition-transform flex items-center gap-1">
                                     <span>Manage Units</span>
                                      <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                                    </a>                   
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- RIGHT AREA: STICKY FORM COMPONENT -->
            <div class="h-fit lg:sticky lg:top-24">
                <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm">
                    <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-5">Add New Property</h3>
                    
                    <form action="<?= Url::to(['/landlord/properties']) ?>" method="POST" class="space-y-4">
                <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Property Name</label>
                            <input type="text" name="name" value="<?php echo $name; ?>" 
                                   placeholder="e.g. Sinza Executive Apartments"
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border <?php echo (!empty($name_err)) ? 'border-rose-400 ring-1 ring-rose-400' : 'border-slate-200/80'; ?> rounded-xl text-xs font-medium focus:outline-none focus:border-indigo-600 focus:bg-white transition-all">
                            <?php if(!empty($name_err)): ?>
                                <p class="text-[11px] text-rose-500 mt-1"><?php echo $name_err; ?></p>
                            <?php endif; ?>
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Location / Address</label>
                            <input type="text" name="address" value="<?php echo $address; ?>" 
                                   placeholder="e.g. Shekilango Road, Dar es Salaam"
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border <?php echo (!empty($address_err)) ? 'border-rose-400 ring-1 ring-rose-400' : 'border-slate-200/80'; ?> rounded-xl text-xs font-medium focus:outline-none focus:border-indigo-600 focus:bg-white transition-all">
                            <?php if(!empty($address_err)): ?>
                                <p class="text-[11px] text-rose-500 mt-1"><?php echo $address_err; ?></p>
                            <?php endif; ?>
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Property Classification</label>
                            <div class="relative">
                                <select name="type" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl text-xs font-medium focus:outline-none focus:border-indigo-600 focus:bg-white transition-all cursor-pointer appearance-none">
                                    <option value="residential">Residential (Apartments/Houses)</option>
                                    <option value="commercial">Commercial (Offices/Frame)</option>
                                    <option value="mixed">Mixed-Use Building</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3.5 pointer-events-none text-slate-400">
                                    <i data-lucide="chevron-down" class="w-4 h-4"></i>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="w-full py-2.5 px-4 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white text-xs font-bold rounded-xl shadow-md shadow-indigo-100 transition-all cursor-pointer mt-2">
                            Save Asset Structure
                        </button>
                    </form>
                </div>
            </div>

        </main>
    </div>

    <!-- PREMIUM DELETE MODAL CONFIGURATION -->
    <div id="propertyDeleteModal" class="fixed inset-0 bg-slate-950/40 backdrop-blur-sm flex items-center justify-center z-50 hidden opacity-0 transition-all duration-300">
        <div class="bg-white rounded-2xl w-full max-w-sm p-6 shadow-2xl border border-slate-100 mx-4 transform scale-95 transition-all duration-300" id="propDeleteModalContent">
            <div class="text-center">
                <span class="w-11 h-11 bg-rose-50 text-rose-600 rounded-xl flex items-center justify-center mx-auto mb-4 border border-rose-100">
                    <i data-lucide="alert-triangle" class="w-5 h-5"></i>
                </span>
                <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Delete Structure Asset</h3>
                <p class="text-xs text-slate-400 mt-2 leading-relaxed">
                    Are you sure you want to permanently delete <span id="delete_modal_prop_text" class="font-bold text-slate-700"></span>? This process will automatically remove all nested units and invoices. This action is irreversible.
                </p>
            </div>
            
            <form id="propDeleteModalForm" method="POST" class="mt-6 flex space-x-2.5">
                <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>
                <button type="button" onclick="closePropertyDeleteModal()" class="flex-1 py-2.5 text-xs font-bold text-slate-500 bg-slate-50 hover:bg-slate-100 rounded-xl border border-slate-200 transition-colors cursor-pointer">
                    Cancel
                </button>
                <button type="submit" class="flex-1 py-2.5 text-xs font-bold bg-rose-600 hover:bg-rose-700 text-white rounded-xl shadow-sm transition-all cursor-pointer">
                    Confirm Delete
                </button>
            </form>
        </div>
    </div>

    <!-- JAVASCRIPT LOGIC OPERATIONS -->
    <script>
        // Initialize Lucide Icons
        lucide.createIcons();

        function toggleSidebar(event) {
            if (event) event.stopPropagation();
            const sidebar = document.getElementById('sidebarNav');
            sidebar.classList.toggle('-translate-x-full');
        }

        function toggleProfilePopup(event) {
            if (event) event.stopPropagation();
            const popup = document.getElementById('profilePopup');
            
            if (popup.classList.contains('hidden')) {
                popup.classList.remove('hidden');
                requestAnimationFrame(() => {
                    popup.classList.remove('opacity-0', 'scale-95', 'pointer-events-none');
                    popup.classList.add('opacity-100', 'scale-100');
                });
            } else {
                popup.classList.remove('opacity-100', 'scale-100');
                popup.classList.add('opacity-0', 'scale-95', 'pointer-events-none');
                setTimeout(() => popup.classList.add('hidden'), 200);
            }
        }

        function openPropertyDeleteModal(propertyId, propertyName) {
            const form = document.getElementById('propDeleteModalForm');
            form.action = "<?= Url::to(['/landlord/delete-property', 'id' => 'PROP_ID']) ?>".replace('PROP_ID', propertyId);
            document.getElementById('delete_modal_prop_text').innerText = propertyName;

            const modal = document.getElementById('propertyDeleteModal');
            const content = document.getElementById('propDeleteModalContent');
            
            modal.classList.remove('hidden');
            setTimeout(() => { 
                modal.classList.remove('opacity-0'); 
                content.classList.remove('scale-95'); 
            }, 10);
        }

        function closePropertyDeleteModal() {
            const modal = document.getElementById('propertyDeleteModal');
            const content = document.getElementById('propDeleteModalContent');
            
            modal.classList.add('opacity-0'); 
            content.classList.add('scale-95'); 
            setTimeout(() => { 
                modal.classList.add('hidden'); 
            }, 300);
        }

        // Click outside controller bounds logic
        document.addEventListener('click', function(event) {
            const popup = document.getElementById('profilePopup');
            const profileBtn = document.getElementById('profileBtn');
            const sidebar = document.getElementById('sidebarNav');
            const menuBtn = document.getElementById('menuBtn');
            
            if (popup && !popup.classList.contains('hidden') && !popup.contains(event.target) && !profileBtn.contains(event.target)) {
                popup.classList.remove('opacity-100', 'scale-100');
                popup.classList.add('opacity-0', 'scale-95', 'pointer-events-none');
                setTimeout(() => popup.classList.add('hidden'), 200);
            }

            if (window.innerWidth < 1024 && !sidebar.classList.contains('-translate-x-full') && !sidebar.contains(event.target) && !menuBtn.contains(event.target)) {
                sidebar.classList.add('-translate-x-full');
            }
        });
    </script>

</body>
</html>