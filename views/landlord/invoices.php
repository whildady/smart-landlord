<?php
/** @var yii\web\View $this */
use yii\helpers\Url;
use yii\helpers\Html;
// Kupata route ya sasa inayotumika kwenye mfumo
$currentRoute = Yii::$app->controller->route;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoices Registry | Smart Landlord</title>
    <script src="https://cdn.tailwindcss.com"></script>
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

    <aside id="sidebarNav" class="w-64 bg-white border-r border-slate-100 flex flex-col justify-between fixed top-0 left-0 h-screen z-50 shadow-2xl lg:shadow-none transform -translate-x-full lg:translate-x-0 transition-all duration-300 ease-in-out">
        <div class="flex flex-col h-full">
            <div class="h-16 flex items-center justify-between px-6 border-b border-slate-50">
                <span class="text-xs font-bold tracking-widest text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-violet-600 uppercase flex items-center gap-2.5">
                    <div class="w-2.5 h-2.5 bg-indigo-600 rounded-md animate-bounce"></div>
                    <span>Smart Landlord</span>
                </span>
                <button onclick="toggleSidebar(event)" class="lg:hidden text-slate-400 hover:text-slate-600 cursor-pointer p-1.5 rounded-xl hover:bg-slate-50 transition-all" title="Close Menu">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
            
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

    <div class="flex-1 flex flex-col min-w-0 w-full lg:pl-64">
        
        <header class="h-16 bg-white/80 backdrop-blur-md border-b border-slate-100 flex items-center justify-between px-8 sticky top-0 z-30">
            <div class="flex items-center gap-4">
                <button onclick="toggleSidebar(event)" id="menuBtn" class="lg:hidden text-slate-500 p-2 rounded-xl hover:bg-slate-50 cursor-pointer transition-all border border-slate-100" title="Open Navigation Menu">
                    <i data-lucide="menu" class="w-5 h-5"></i>
                </button>
                <div>
                    <h1 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">Financial Tracking</h1>
                    <p class="text-sm font-bold text-slate-800">Invoices Registry</p>
            
                </div>
            </div>
            
            <div class="flex items-center gap-5">
                <button onclick="openBillingModal(event)" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow-md shadow-indigo-100 hover:shadow-lg hover:shadow-indigo-200 transition-all duration-200 active:scale-98 cursor-pointer flex items-center gap-2">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    <span>Create Invoice</span>
                </button>

                <div class="flex items-center space-x-3.5 relative">
                    <!-- JavaScript ya Kudhibiti Default Theme (Light) na Kuzuia Flash ya Rangi -->
<script>
    // Angalia kama mtumiaji alichagua dark mode huko nyuma, la sivyo mfumo utakaa kwenye Light Theme kama default
    if (localStorage.getItem('color-theme') === 'dark') {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
</script>
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
            </div>
        </header>

        <main class="p-8 max-w-7xl w-full mx-auto space-y-6 animate-fade-in-up">
            
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:border-emerald-200 group">
                    <div class="flex items-center justify-between">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Collected Revenue</p>
                        <span class="p-2 rounded-xl bg-emerald-50 text-emerald-600 group-hover:scale-110 transition-transform duration-300">
                            <i data-lucide="check-circle" class="w-4 h-4"></i>
                        </span>
                    </div>
                    <p class="text-xl font-black text-emerald-600 tracking-tight mt-3">
                        TZS <span id="totalCollectedCard">0</span>
                    </p>
                    <p class="text-[10px] text-slate-400 mt-2 flex items-center gap-1">
                        <span class="inline-block w-1 h-1 rounded-full bg-emerald-500"></span> Settled invoices this cycle
                    </p>
                </div>

                <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:border-amber-200 group">
                    <div class="flex items-center justify-between">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Pending Balance</p>
                        <span class="p-2 rounded-xl bg-amber-50 text-amber-600 group-hover:scale-110 transition-transform duration-300">
                            <i data-lucide="clock" class="w-4 h-4"></i>
                        </span>
                    </div>
                    <p class="text-xl font-black text-amber-600 tracking-tight mt-3">
                        TZS <span id="totalPendingCard">0</span>
                    </p>
                    <p class="text-[10px] text-slate-400 mt-2 flex items-center gap-1">
                        <span class="inline-block w-1 h-1 rounded-full bg-amber-400"></span> Awaiting tenant submission
                    </p>
                </div>

                <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:border-rose-200 group">
                    <div class="flex items-center justify-between">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Overdue Deficit</p>
                        <span class="p-2 rounded-xl bg-rose-50 text-rose-600 group-hover:scale-110 transition-transform duration-300">
                            <i data-lucide="alert-circle" class="w-4 h-4"></i>
                        </span>
                    </div>
                    <p class="text-xl font-black text-rose-600 tracking-tight mt-3">
                        TZS <span id="totalOverdueCard">0</span>
                    </p>
                    <p class="text-[10px] text-slate-400 mt-2 flex items-center gap-1">
                        <span class="inline-block w-1 h-1 rounded-full bg-rose-500"></span> Past due deadline thresholds
                    </p>
                </div>
            </div>

            <div class="bg-white border border-slate-100 rounded-2xl p-4 shadow-sm flex flex-col sm:flex-row gap-4 items-center justify-between">
                <div class="w-full sm:w-80 relative group">
                    <input type="text" id="searchInput" onkeyup="filterInvoices()" placeholder="Search by invoice number or tenant..." class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:border-indigo-600 focus:bg-white transition-all shadow-2xs">
                    <div class="absolute left-3 top-2.5 text-slate-400 group-focus-within:text-indigo-600 transition-colors">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </div>
                </div>
                <div class="flex gap-3 w-full sm:w-auto justify-end">
                    <select id="statusFilter" onchange="filterInvoices()" class="px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:border-indigo-600 focus:bg-white cursor-pointer transition-all shadow-2xs">
                        <option value="">All Statuses Framework</option>
                        <option value="paid">Paid Ledger</option>
                        <option value="unpaid">Unpaid / Outstanding</option>
                        <option value="overdue">Overdue Threshold</option>
                    </select>
                    <select id="sortFilter" onchange="sortInvoices()" class="px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:border-indigo-600 focus:bg-white cursor-pointer transition-all shadow-2xs">
                        <option value="newest">Sort By: Newest Entries</option>
                        <option value="oldest">Oldest Entries</option>
                        <option value="amount-high">Amount: High to Low</option>
                    </select>
                </div>
            </div>

            <div class="space-y-4">
                <div class="flex items-center justify-between px-1">
                    <h2 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Invoices Billing Registry</h2>
                    <span class="text-[11px] font-semibold text-slate-400 bg-slate-100 px-2.5 py-0.5 rounded-full" id="rowCountDisplay">0 Invoices Total</span>
                </div>
                
                <?php if(empty($invoices)) : ?>
                    <div id="noInvoicesCard" class="border border-slate-100 rounded-2xl p-14 text-center bg-white shadow-sm flex flex-col items-center">
                        <div class="w-12 h-12 bg-slate-50 text-slate-400 border border-slate-100 rounded-xl flex items-center justify-center mb-4 shadow-sm">
                            <i data-lucide="file-text" class="w-5 h-5"></i>
                        </div>
                        <p class="font-bold text-sm text-slate-700">No invoice statements matching requested records found.</p>
                        <p class="text-xs text-slate-400 mt-1 max-w-xs mx-auto">Manual generation paths are accessible via individual unit profiles or create action headers.</p>
                    </div>
                <?php else : ?>
                    <div class="bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden transition-all duration-300">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse" id="invoicesTable">
                                <thead>
                                    <tr class="bg-slate-50 border-b border-slate-100 text-[10px] font-bold text-slate-400 uppercase tracking-wider select-none">
                                        <th class="py-4 px-6">Invoice ID</th>
                                        <th class="py-4 px-4">Tenant / Space Asset</th>
                                        <th class="py-4 px-4">Billing Month</th>
                                        <th class="py-4 px-4">Amount Charged</th>
                                        <th class="py-4 px-4">Due Date Deadline</th>
                                        <th class="py-4 px-4">Status Flag</th>
                                        <th class="py-4 px-6 text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50 text-xs font-medium text-slate-600" id="invoicesTableBody">
                                    <?php foreach($invoices as $invoice) : ?>
                                        <tr class="hover:bg-indigo-50/10 transition-all duration-150 invoice-row" 
                                            data-id="<?php echo $invoice->id; ?>"
                                            data-tenant="<?php echo strtolower($invoice->tenant_name ?? ''); ?>"
                                            data-unit="<?php echo strtolower($invoice->unit_number ?? ''); ?>"
                                            data-amount="<?php echo $invoice->amount; ?>"
                                            data-status="<?php echo strtolower($invoice->status); ?>"
                                            data-date="<?php echo strtotime($invoice->due_date); ?>">
                                            
                                            <td class="py-4 px-6 font-bold text-slate-900 tracking-tight">#INV-<?php echo str_pad($invoice->id, 2, '0', STR_PAD_LEFT); ?></td>
                                            <td class="py-4 px-4">
                                                <div class="font-bold text-slate-800"><?php echo htmlspecialchars($invoice->tenant_name ?? 'Vacant Space'); ?></div>
                                                <div class="text-[11px] font-medium text-slate-400 mt-0.5 flex items-center gap-1">
                                                    <span class="inline-block w-1.5 h-1.5 rounded-sm bg-slate-200"></span> <?php echo htmlspecialchars($invoice->unit_number ?? 'N/A'); ?>
                                                </div>
                                            </td>
                                            <td class="py-4 px-4 text-slate-500 font-normal"><?php echo htmlspecialchars($invoice->billing_month); ?></td>
                                            <td class="py-4 px-4 font-bold text-indigo-600 tracking-tight">TZS <?php echo number_format($invoice->amount, 2); ?></td>
                                            <td class="py-4 px-4 text-slate-500 font-normal"><?php echo date('M d, Y', strtotime($invoice->due_date)); ?></td>
                                            <td class="py-4 px-4">
                                                <?php if(strtolower($invoice->status) == 'paid') : ?>
                                                    <span class="text-[9px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-md bg-emerald-50 text-emerald-700 border border-emerald-100 inline-block">Paid</span>
                                                <?php elseif(strtolower($invoice->status) == 'unpaid') : ?>
                                                    <span class="text-[9px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-md bg-amber-50 text-amber-700 border border-amber-100 inline-block">Unpaid</span>
                                                <?php else : ?>
                                                    <span class="text-[9px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-md bg-rose-50 text-rose-700 border border-rose-100 inline-block"><?php echo htmlspecialchars($invoice->status); ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="py-4 px-6 text-right space-x-1">
                                                <?php if(strtolower($invoice->status) !== 'paid') : ?>
                                                    <a href="<?= Url::to(['/landlord/mark-paid', 'id' => $invoice->id]) ?>" class="text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-600 hover:text-white hover:border-emerald-600 px-3 py-1.5 rounded-lg transition-all duration-150 inline-block shadow-sm cursor-pointer active:scale-95">
                                                        Settle
                                                    </a>
                                                <?php endif; ?>
                                                <button type="button" onclick="openDeleteModal(event, '<?php echo $invoice->id; ?>', '#INV-<?php echo str_pad($invoice->id, 2, '0', STR_PAD_LEFT); ?>')" class="text-slate-400 hover:text-rose-600 p-1.5 rounded-lg hover:bg-rose-50 border border-transparent hover:border-rose-100 transition-all duration-200 cursor-pointer inline-flex items-center justify-center align-middle active:scale-90" title="Void Invoice">
                                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div id="jsNoResultsCard" class="border border-slate-100 rounded-2xl p-14 text-center bg-white shadow-sm flex flex-col items-center hidden">
                        <div class="w-12 h-12 bg-slate-50 text-slate-400 border border-slate-100 rounded-xl flex items-center justify-center mb-4 shadow-sm">
                            <i data-lucide="search-x" class="w-5 h-5"></i>
                        </div>
                        <p class="font-bold text-sm text-slate-700">No matching registry entries found.</p>
                        <p class="text-xs text-slate-400 mt-1">Please refine your queries or parameters and attempt execution routines again.</p>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <div id="unitDeleteModal" class="fixed inset-0 bg-slate-950/40 backdrop-blur-sm flex items-center justify-center z-50 hidden opacity-0 transition-all duration-300">
        <div class="bg-white rounded-2xl w-full max-w-sm p-6 shadow-2xl border border-slate-100 mx-4 transform scale-95 transition-all duration-300" id="deleteModalContent">
            <div class="text-center">
                <span class="w-12 h-12 bg-rose-50 text-rose-600 rounded-xl flex items-center justify-center mx-auto mb-4 border border-rose-100 shadow-sm">
                    <i data-lucide="alert-triangle" class="w-5 h-5"></i>
                </span>
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Void Ledger Statement</h3>
                <p class="text-[13px] font-semibold text-slate-800 mt-2">Are you sure you want to void invoice <span id="delete_modal_unit_text" class="text-rose-600 font-extrabold"></span>?</p>
                <p class="text-xs text-slate-400 mt-1.5 leading-relaxed">
                    This process updates active property metrics, releases linked unit flags, and voids historical ledger rows permanently.
                </p>
            </div>
            
            <form id="deleteModalForm" method="POST" class="mt-5 flex space-x-2.5">
                <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>
                <button type="button" onclick="closeDeleteModal()" class="flex-1 py-2.5 text-xs font-bold text-slate-500 bg-slate-50 hover:bg-slate-100 rounded-xl border border-slate-200/70 transition-all cursor-pointer active:scale-98">
                    Cancel
                </button>
                <button type="submit" class="flex-1 py-2.5 text-xs font-bold bg-rose-600 hover:bg-rose-700 text-white rounded-xl shadow-md shadow-rose-100 transition-all cursor-pointer active:scale-98">
                    Confirm Void
                </button>
            </form>
        </div>
    </div>

    <div id="unitBillingModal" class="fixed inset-0 bg-slate-950/40 backdrop-blur-sm flex items-center justify-center z-50 hidden opacity-0 transition-all duration-300">
        <div class="bg-white rounded-2xl w-full max-w-md p-6 shadow-2xl border border-slate-100 mx-4 transform scale-95 transition-all duration-300" id="billingModalContent">
            <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                <h3 class="text-xs font-bold text-slate-800 uppercase tracking-widest flex items-center gap-2">
                    <i data-lucide="file-plus" class="w-4 h-4 text-indigo-600"></i>
                    <span class="normal-case text-sm font-extrabold">Generate Rent Invoice</span>
                </h3>
                <button onclick="closeBillingModal()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg hover:bg-slate-50 transition-colors text-xs font-bold cursor-pointer">✕</button>
            </div>
            
            <form action="<?= Url::to(['/landlord/invoices']) ?>" method="POST" class="mt-4 space-y-4">
                <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Target Workspace Unit Space</label>
                    <div class="relative">
                        <select name="tenant_info" id="modal_unit_id" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs font-medium focus:outline-none focus:border-indigo-600 focus:bg-white transition-all cursor-pointer appearance-none">
                            <option value="" disabled selected hidden>Select occupied asset framework...</option>
                            <?php if(!empty($active_tenants)) : ?>
                                <?php foreach($active_tenants as $u) : ?>
                                    <option value="<?php echo $u->tenant_id . '|' . $u->unit_id; ?>"><?php echo htmlspecialchars($u->unit_number); ?> — (<?php echo htmlspecialchars($u->tenant_name); ?>)</option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3.5 pointer-events-none text-slate-400">
                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Rent Amount (TZS)</label>
                    <input type="number" step="0.01" name="amount" id="modal_amount" required placeholder="e.g. 400000.00" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs font-medium focus:outline-none focus:border-indigo-600 focus:bg-white transition-all">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Billing Month</label>
                        <input type="text" name="billing_month" value="<?php echo date('May 2026'); ?>" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs font-medium focus:outline-none focus:border-indigo-600 focus:bg-white transition-all">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Due Date Deadline</label>
                        <input type="date" name="due_date" value="<?php echo date('Y-m-d', strtotime('+7 days')); ?>" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs font-medium focus:outline-none focus:border-indigo-600 focus:bg-white transition-all cursor-pointer">
                    </div>
                </div>

                <div class="pt-2 flex justify-end space-x-2.5">
                    <button type="button" onclick="closeBillingModal()" class="px-4 py-2 text-xs font-bold text-slate-500 hover:bg-slate-50 rounded-xl transition-all cursor-pointer">Cancel</button>
                    <button type="submit" class="px-5 py-2 text-xs font-bold bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl shadow-md shadow-indigo-100 hover:shadow-lg hover:shadow-indigo-200 transition-all cursor-pointer active:scale-98">Generate & Post</button>
                </div>
            </form>
        </div>
    </div>

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

        // Live Frontend Filter, Search and Math Calculations Logic
        function filterInvoices() {
            const searchValue = document.getElementById('searchInput').value.toLowerCase().trim();
            const statusValue = document.getElementById('statusFilter').value.toLowerCase();
            const rows = document.querySelectorAll('.invoice-row');
            const noResultsCard = document.getElementById('jsNoResultsCard');
            const invoicesTable = document.getElementById('invoicesTable');
            
            let visibleCount = 0;
            let liveCollected = 0;
            let livePending = 0;
            let liveOverdue = 0;

            rows.forEach(row => {
                const invoiceId = row.querySelector('td:first-child').innerText.toLowerCase();
                const tenantName = row.getAttribute('data-tenant') || '';
                const unitNumber = row.getAttribute('data-unit') || '';
                const status = row.getAttribute('data-status') || '';
                const amount = parseFloat(row.getAttribute('data-amount')) || 0;

                const matchesSearch = invoiceId.includes(searchValue) || tenantName.includes(searchValue) || unitNumber.includes(searchValue);
                const matchesStatus = statusValue === "" || status === statusValue;

                if (matchesSearch && matchesStatus) {
                    row.classList.remove('hidden');
                    visibleCount++;
                    
                    // Sum up values dynamically
                    if (status === 'paid') liveCollected += amount;
                    else if (status === 'unpaid') livePending += amount;
                    else liveOverdue += amount;
                } else {
                    row.classList.add('hidden');
                }
            });

            // Update Financial Display Cards
            document.getElementById('totalCollectedCard').innerText = liveCollected.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            document.getElementById('totalPendingCard').innerText = livePending.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            document.getElementById('totalOverdueCard').innerText = liveOverdue.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            document.getElementById('rowCountDisplay').innerText = visibleCount + ' Invoices Matching';

            if (visibleCount === 0 && rows.length > 0) {
                if(invoicesTable) invoicesTable.parentElement.parentElement.classList.add('hidden');
                if(noResultsCard) noResultsCard.classList.remove('hidden');
            } else {
                if(invoicesTable) invoicesTable.parentElement.parentElement.classList.remove('hidden');
                if(noResultsCard) noResultsCard.classList.add('hidden');
            }
        }

        function sortInvoices() {
            const sortBy = document.getElementById('sortFilter').value;
            const tbody = document.getElementById('invoicesTableBody');
            if(!tbody) return;
            const rows = Array.from(tbody.querySelectorAll('.invoice-row'));

            rows.sort((a, b) => {
                if (sortBy === 'newest') {
                    return parseInt(b.getAttribute('data-id')) - parseInt(a.getAttribute('data-id'));
                } else if (sortBy === 'oldest') {
                    return parseInt(a.getAttribute('data-id')) - parseInt(b.getAttribute('data-id'));
                } else if (sortBy === 'amount-high') {
                    return parseFloat(b.getAttribute('data-amount')) - parseFloat(a.getAttribute('data-amount'));
                }
            });

            rows.forEach(row => tbody.appendChild(row));
        }

        // Modal triggers
        function openBillingModal(event) {
            if (event) event.stopPropagation();
            const modal = document.getElementById('unitBillingModal');
            const content = document.getElementById('billingModalContent');
            modal.classList.remove('hidden');
            requestAnimationFrame(() => {
                modal.classList.remove('opacity-0');
                content.classList.remove('scale-95');
            });
        }

        function closeBillingModal() {
            const modal = document.getElementById('unitBillingModal');
            const content = document.getElementById('billingModalContent');
            modal.classList.add('opacity-0');
            content.classList.add('scale-95');
            setTimeout(() => modal.classList.add('hidden'), 300);
        }

        function openDeleteModal(event, id, invNumber) {
            if (event) event.stopPropagation();
            const form = document.getElementById('deleteModalForm');
            form.action = "<?= Url::to(['/landlord/delete-invoice', 'id' => 'INV_ID']) ?>".replace('INV_ID', id);
            document.getElementById('delete_modal_unit_text').innerText = invNumber;

            const modal = document.getElementById('unitDeleteModal');
            const content = document.getElementById('deleteModalContent');
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                content.classList.remove('scale-95');
            }, 10);
        }

        function closeDeleteModal() {
            const modal = document.getElementById('unitDeleteModal');
            const content = document.getElementById('deleteModalContent');
            modal.classList.add('opacity-0');
            content.classList.add('scale-95');
            setTimeout(() => modal.classList.add('hidden'), 300);
        }

        // Global onbounds trigger setup
        document.addEventListener('DOMContentLoaded', () => {
            filterInvoices();
        });

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

            if (window.innerWidth < 1024 && sidebar && !sidebar.classList.contains('-translate-x-full') && !sidebar.contains(event.target) && !menuBtn.contains(event.target)) {
                sidebar.classList.add('-translate-x-full');
            }
        });
    </script>
</body>
</html>