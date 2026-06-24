<?php
/** @var yii\web\View $this */
use yii\helpers\Url;
use yii\helpers\Html;
// Kupata route ya sasa inayotumika kwenye mfumo
$currentRoute = Yii::$app->controller->route;
?>
<!DOCTYPE html>
<html lang="en" class="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premium Landlord Dashboard</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {}
            }
        }
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <style>
        /* Premium Global Animations */
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
        html.dark ::-webkit-scrollbar-thumb {
            background: #334155;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        
        /* Sidebar layout and scroll tweak */
        .sidebar-scroll::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        .dark .sidebar-scroll::-webkit-scrollbar-thumb {
            background: #334155;
        }
    </style>
    
    <script>
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="bg-[#f8fafc] dark:bg-[#090d16] font-sans antialiased text-slate-900 dark:text-slate-100 flex min-h-screen relative overflow-x-hidden transition-colors duration-300">

    <aside id="sidebarNav" class="w-64 bg-white dark:bg-[#0f172a] border-r border-slate-100 dark:border-slate-800/60 flex flex-col justify-between fixed top-0 left-0 h-screen z-50 shadow-2xl lg:shadow-none transform -translate-x-full lg:translate-x-0 transition-all duration-300 ease-in-out">
        <div class="flex flex-col h-full">
            <div class="h-16 flex items-center justify-between px-6 border-b border-slate-50 dark:border-slate-800/40">
                <span class="text-xs font-bold tracking-widest text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-violet-600 dark:from-indigo-400 dark:to-violet-400 uppercase flex items-center gap-2.5">
                    <div class="w-2.5 h-2.5 bg-indigo-600 dark:bg-indigo-400 rounded-md animate-bounce"></div>
                    <span>Smart Landlord</span>
                </span>
                <button onclick="toggleSidebar(event)" class="lg:hidden text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 cursor-pointer p-1.5 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 transition-all" title="Close Menu">
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
        </div>
    </aside>

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
        
        <header class="h-16 bg-white/80 dark:bg-[#0f172a]/80 backdrop-blur-md border-b border-slate-100 dark:border-slate-800/60 flex items-center justify-between px-8 sticky top-0 z-30 transition-colors duration-300">
            <div class="flex items-center gap-4">
                <button onclick="toggleSidebar(event)" id="menuBtn" class="lg:hidden text-slate-500 dark:text-slate-400 p-2 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 cursor-pointer transition-all border border-slate-100 dark:border-slate-800" title="Open Navigation Menu">
                    <i data-lucide="menu" class="w-5 h-5"></i>
                </button>
                <h1 class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Message and Conversations</h1>
            </div>
            
            <div class="flex items-center space-x-4 relative">
                
                <button id="theme-toggle" class="p-2 text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition-all cursor-pointer border border-slate-100 dark:border-slate-800 active:scale-95" title="Toggle Dark/Light Mode">
                    <i id="theme-toggle-dark-icon" data-lucide="moon" class="w-4 h-4 hidden"></i>
                    <i id="theme-toggle-light-icon" data-lucide="sun" class="w-4 h-4 hidden"></i>
                </button>
               <!-- Notification Bell Button -->
<div class="relative">
    <button id="notificationBtn" onclick="toggleNotificationPopup(event)" class="p-2 text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition-all cursor-pointer border border-slate-100 dark:border-slate-800 active:scale-95 relative" title="Notifications">
        <i data-lucide="bell" class="w-4 h-4"></i>
        <!-- Red Badge Count (Kama inavyoonekana kwenye image_9c3aef.png) -->
        <span id="notificationBadge" class="absolute top-1 right-1.5 w-2 h-2 bg-rose-500 rounded-full ring-2 ring-white dark:ring-[#0f172a]"></span>
    </button>

    <!-- Notification Dropdown Card -->
    <div id="notificationPopup" class="absolute right-0 top-14 w-80 sm:w-96 bg-white dark:bg-[#0f172a] border border-slate-100 dark:border-slate-800 rounded-2xl shadow-2xl flex flex-col transition-all duration-200 ease-out transform scale-95 opacity-0 pointer-events-none z-50 hidden overflow-hidden">
        
        <!-- Header ya Card -->
        <div class="p-4 flex justify-between items-center border-b border-slate-50 dark:border-slate-800/60 bg-white dark:bg-[#0f172a]">
            <div class="flex items-center gap-2">
                <span class="text-xs font-bold text-slate-800 dark:text-white">Notifications</span>
                <span id="notifCountBadge" class="text-[10px] font-bold text-slate-500 bg-slate-100 dark:bg-slate-800 px-2 py-0.5 rounded-full">4</span>
            </div>
            <button onclick="markAllNotificationsRead(event)" class="text-[11px] text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 flex items-center gap-1 font-medium cursor-pointer transition-colors">
                <i data-lucide="check-check" class="w-3.5 h-3.5"></i>
                Mark all read
            </button>
        </div>

        <!-- Orodha ya Taarifa (Scrollable List) -->
        <div class="max-h-80 overflow-y-auto sidebar-scroll bg-slate-50/[0.15] dark:bg-slate-900/[0.02]" id="notifListContainer">
            
            <!-- Notification Item 1 (Unread) -->
            <div class="p-4 flex items-start gap-3 border-b border-slate-50 dark:border-slate-800/40 hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-all group relative notif-item unread">
                <div class="w-8 h-8 rounded-full bg-amber-50 dark:bg-amber-950/40 flex items-center justify-center flex-shrink-0 text-amber-600 dark:text-amber-400 border border-amber-100/30">
                    <i data-lucide="wallet" class="w-4 h-4"></i>
                </div>
                <div class="flex-1 min-w-0 pr-3">
                    <h4 class="text-xs font-bold text-slate-800 dark:text-slate-200">New payment received</h4>
                    <p class="text-[11px] text-slate-400 dark:text-slate-400 mt-0.5 truncate">Emma Wilson paid $1,499.00 for Apt 4B...</p>
                    <span class="text-[10px] text-slate-400 dark:text-slate-500 block mt-1">2 min ago</span>
                </div>
                <span class="w-1.5 h-1.5 bg-slate-900 dark:bg-indigo-400 rounded-full absolute right-4 top-5 notif-dot"></span>
            </div>

            <!-- Notification Item 2 (Unread) -->
            <div class="p-4 flex items-start gap-3 border-b border-slate-50 dark:border-slate-800/40 hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-all group relative notif-item unread">
                <div class="w-8 h-8 rounded-full bg-indigo-50 dark:bg-indigo-950/40 flex items-center justify-center flex-shrink-0 text-indigo-600 dark:text-indigo-400 border border-indigo-100/30">
                    <i data-lucide="wrench" class="w-4 h-4"></i>
                </div>
                <div class="flex-1 min-w-0 pr-3">
                    <h4 class="text-xs font-bold text-slate-800 dark:text-slate-200">Maintenance request</h4>
                    <p class="text-[11px] text-slate-400 dark:text-slate-400 mt-0.5 truncate">Sofia Garcia reported a kitchen sink leak...</p>
                    <span class="text-[10px] text-slate-400 dark:text-slate-500 block mt-1">15 min ago</span>
                </div>
                <span class="w-1.5 h-1.5 bg-slate-900 dark:bg-indigo-400 rounded-full absolute right-4 top-5 notif-dot"></span>
            </div>

            <!-- Notification Item 3 (Unread) -->
            <div class="p-4 flex items-start gap-3 border-b border-slate-50 dark:border-slate-800/40 hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-all group relative notif-item unread">
                <div class="w-8 h-8 rounded-full bg-emerald-50 dark:bg-emerald-950/40 flex items-center justify-center flex-shrink-0 text-emerald-600 dark:text-emerald-400 border border-emerald-100/30">
                    <i data-lucide="user-plus" class="w-4 h-4"></i>
                </div>
                <div class="flex-1 min-w-0 pr-3">
                    <h4 class="text-xs font-bold text-slate-800 dark:text-slate-200">New tenant registered</h4>
                    <p class="text-[11px] text-slate-400 dark:text-slate-400 mt-0.5 truncate">James Chen completed lease registration...</p>
                    <span class="text-[10px] text-slate-400 dark:text-slate-500 block mt-1">1 hour ago</span>
                </div>
                <span class="w-1.5 h-1.5 bg-slate-900 dark:bg-indigo-400 rounded-full absolute right-4 top-5 notif-dot"></span>
            </div>

            <!-- Notification Item 4 (Read) -->
            <div class="p-4 flex items-start gap-3 border-b border-slate-50 dark:border-slate-800/40 hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-all group relative notif-item opacity-75">
                <div class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center flex-shrink-0 text-slate-500 dark:text-slate-400">
                    <i data-lucide="megaphone" class="w-4 h-4"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="text-xs font-semibold text-slate-600 dark:text-slate-400">Notice Broadcast Sent</h4>
                    <p class="text-[11px] text-slate-400 dark:text-slate-500 mt-0.5 truncate">Scheduled water maintenance notice sent to all blocks...</p>
                    <span class="text-[10px] text-slate-400 dark:text-slate-500 block mt-1">2 hours ago</span>
                </div>
            </div>

        </div>

        <!-- Footer ya Card -->
        <a href="<?= Url::to(['/landlord/notifications']) ?>" class="p-3.5 text-center text-xs font-semibold text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white bg-white dark:bg-[#0f172a] border-t border-slate-100 dark:border-slate-800/60 block transition-colors tracking-wide">
            View all notifications
        </a>
    </div>
</div>
                <div class="text-right hidden sm:block">
                    <p class="text-xs font-semibold text-slate-800 dark:text-slate-200"><?php echo Html::encode(Yii::$app->user->identity->name ?? 'User'); ?></p>
                    <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mt-0.5"><?php echo Html::encode(Yii::$app->user->identity->role ?? 'Landlord'); ?></p>
                </div>
                
                <button onclick="toggleProfilePopup(event)" id="profileBtn" class="w-9 h-9 rounded-xl relative overflow-hidden shadow-sm border border-slate-200/60 dark:border-slate-700 group cursor-pointer block focus:outline-none transition-transform active:scale-95">
                    <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Default Profile" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-slate-950/0 group-hover:bg-slate-950/5 transition-colors duration-200"></div>
                </button>

                <div id="profilePopup" class="absolute right-0 top-14 w-72 bg-white dark:bg-[#0f172a] border border-slate-100 dark:border-slate-800 rounded-2xl shadow-2xl p-5 flex flex-col items-center space-y-4 transition-all duration-200 ease-out transform scale-95 opacity-0 pointer-events-none z-50 hidden">
                    <div class="w-full flex justify-between items-center pb-2 border-b border-slate-50 dark:border-slate-800/60">
                        <span class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Message and conversations</span>
                        <button onclick="toggleProfilePopup(event)" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 p-1 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800 cursor-pointer">
                            <i data-lucide="x" class="w-4 h-4"></i>
                        </button>
                    </div>
                    <div class="w-14 h-14 rounded-xl relative overflow-hidden shadow-sm border border-slate-200 dark:border-slate-700">
                        <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Default Profile" class="w-full h-full object-cover">
                    </div>

                    <div class="text-center">
                        <h4 class="text-xs font-semibold text-slate-900 dark:text-slate-100"><?php echo Html::encode(Yii::$app->user->identity->name ?? 'User'); ?></h4>
                        <p class="text-[10px] font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider mt-0.5"><?php echo Html::encode(Yii::$app->user->identity->role ?? 'Landlord'); ?></p>
                    </div>

                    <form action="<?= Url::to(['/landlord/update-profile-image']) ?>" method="POST" enctype="multipart/form-data" class="w-full pt-1">
                        <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>
                        <label class="w-full flex items-center justify-center gap-2 px-3 py-2.5 bg-slate-50 dark:bg-slate-800 hover:bg-slate-100/80 dark:hover:bg-slate-700/80 text-slate-700 dark:text-slate-300 font-semibold text-xs rounded-xl transition-all cursor-pointer border border-slate-100 dark:border-slate-800 shadow-sm">
                            <i data-lucide="camera" class="w-3.5 h-3.5 text-slate-400"></i>
                            <span>Upload New Photo</span>
                            <input type="file" name="profile_image" accept="image/*" class="hidden" onchange="this.form.submit()">
                        </label>
                    </form>
                </div>
            </div>
        </header>

        <main class="p-6 flex-1 flex flex-col justify-stretch">
            
            <div class="flex flex-col h-[calc(100vh-140px)] bg-white dark:bg-[#0f172a] rounded-3xl border border-slate-100 dark:border-slate-800/60 overflow-hidden shadow-sm">
                
                <div class="flex flex-1 overflow-hidden">
                    
                    <div class="w-full md:w-80 lg:w-96 bg-white dark:bg-[#0f172a] border-r border-slate-100 dark:border-slate-800/60 flex flex-col overflow-hidden">
                        
                        <div class="p-4">
                            <div class="relative flex items-center">
                                <i data-lucide="search" class="w-4 h-4 text-slate-400 dark:text-slate-500 absolute left-3.5 pointer-events-none"></i>
                                <input type="text" id="chatSearchInput" placeholder="Search conversations..." 
                                       class="w-full pl-10 pr-4 py-2.5 text-xs bg-slate-50 dark:bg-slate-800/40 text-slate-700 dark:text-slate-200 rounded-xl border border-slate-100 dark:border-slate-800 focus:outline-none focus:border-indigo-500/50 focus:ring-4 focus:ring-indigo-500/[0.03] transition-all placeholder:text-slate-400 dark:placeholder:text-slate-500">
                            </div>
                        </div>


                        
                        <div class="flex-1 overflow-y-auto px-2 pb-4 space-y-1 sidebar-scroll" id="conversationsContainer">
    
    <?php if (!empty($tenants)): ?>
        <?php foreach ($tenants as $t): 
            // Tengeneza herufi za mwanzo wa jina (Initials) mfano: Sarah Chen -> SC
            $words = explode(' ', trim($t['name']));
            $initials = '';
            foreach ($words as $w) {
                $initials .= strtoupper(substr($w, 0, 1));
            }
            $initials = substr($initials, 0, 2);
        ?>
            <button class="w-full flex items-center p-3 rounded-2xl hover:bg-slate-50 dark:hover:bg-slate-800/40 text-left transition-all duration-200 group border border-transparent chat-user-item cursor-pointer" 
                    data-id="<?= $t['id'] ?>" 
                    data-name="<?= htmlspecialchars($t['name']) ?>" 
                    data-initials="<?= $initials ?>">
                
                <div class="relative flex-shrink-0">
                    <div class="w-10 h-10 rounded-full bg-indigo-100 dark:bg-indigo-950/60 flex items-center justify-center font-bold text-xs text-indigo-600 dark:text-indigo-400">
                        <span><?= $initials ?></span>
                    </div>
                    <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-emerald-500 rounded-full ring-2 ring-white dark:ring-[#0f172a]"></span>
                </div>

                <div class="ml-3 flex-1 min-w-0">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xs font-bold text-slate-800 dark:text-white truncate user-name">
                            <?= htmlspecialchars($t['name']) ?>
                        </h3>
                        <span class="text-[10px] text-slate-400 dark:text-slate-500">Active</span>
                    </div>
                    <p class="text-xs text-slate-400 dark:text-slate-500 truncate mt-0.5 font-medium">
                        Send a message 
                    </p>
                </div>
            </button>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="p-4 text-center text-xs text-slate-400 dark:text-slate-500">
            No tenants found. Start by adding tenants to your property to enable messaging.
        </div>
    <?php endif; ?>

</div>
</div> <div id="chatRightArea" class="hidden md:flex flex-1 bg-slate-50/40 dark:bg-slate-900/10 flex-col overflow-hidden">
    
    <div id="emptyChatState" class="m-auto max-w-sm flex flex-col items-center text-center select-none animate-fade-in-up">
        <div class="w-16 h-16 rounded-2xl bg-white dark:bg-slate-800 shadow-xl shadow-slate-100/70 dark:shadow-none flex items-center justify-center border border-slate-100/70 dark:border-slate-700/50 text-slate-400 dark:text-slate-500 mb-5">
            <i data-lucide="message-square" class="w-6 h-6 stroke-[1.5]"></i>
        </div>
        <h2 class="text-sm font-bold text-slate-800 dark:text-white">Select a conversation</h2>
        <p class="text-xs text-slate-400 dark:text-slate-500 mt-2 leading-relaxed max-w-[280px]">
            Choose a conversation from the list to start messaging with your tenants.
        </p>
    </div>

    <div id="activeChatState" class="hidden flex-1 flex flex-col overflow-hidden">
        
        <div class="h-16 border-b border-slate-100 dark:border-slate-800/60 bg-white dark:bg-[#0f172a] px-6 flex items-center justify-between flex-shrink-0">
            <div class="flex items-center">
                <div id="targetUserAvatar" class="w-10 h-10 rounded-full bg-indigo-100 dark:bg-indigo-950/60 flex items-center justify-center font-bold text-xs text-indigo-600 dark:text-indigo-400 relative">
                    <span id="targetUserInitials">--</span>
                    <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-emerald-500 rounded-full ring-2 ring-white dark:ring-[#0f172a]"></span>
                </div>
                <div class="ml-3">
                    <h3 id="targetUserName" class="text-xs font-bold text-slate-800 dark:text-white">---</h3>
                    <p class="text-[10px] text-slate-400 dark:text-slate-500 mt-0.5">Online</p>
                </div>
            </div>
            
            <div class="flex items-center space-x-2 text-slate-500 dark:text-slate-400">
                <button class="p-2 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-xl transition-all cursor-pointer"><i data-lucide="phone" class="w-4 h-4"></i></button>
                <button class="p-2 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-xl transition-all cursor-pointer"><i data-lucide="video" class="w-4 h-4"></i></button>
                <button class="p-2 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-xl transition-all cursor-pointer"><i data-lucide="info" class="w-4 h-4"></i></button>
            </div>
        </div>

        <div id="messagesContainer" class="flex-1 overflow-y-auto p-6 space-y-4 bg-slate-50/[0.2] dark:bg-slate-900/[0.02] sidebar-scroll">
            </div>

        <div class="p-4 bg-white dark:bg-[#0f172a] border-t border-slate-100 dark:border-slate-800/60 flex-shrink-0">
            <form id="messageSendForm" class="flex items-center gap-3 relative" enctype="multipart/form-data">
    <button type="button" onclick="document.getElementById('fileInput').click()" class="p-2.5 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-xl transition-all cursor-pointer">
        <i data-lucide="paperclip" class="w-4 h-4"></i>
    </button>
    
    <input type="file" id="fileInput" name="attachment" class="hidden" onchange="previewFile()">
    
    <div class="relative flex-1 flex items-center">
        <input type="text" id="messageInput" name="message" placeholder="Type a message..." 
               class="w-full pl-4 pr-10 py-3 text-xs bg-slate-50 dark:bg-slate-800/50 text-slate-700 dark:text-slate-200 rounded-xl border border-slate-100 dark:border-slate-800 focus:outline-none focus:border-indigo-500/50 focus:ring-4 focus:ring-indigo-500/[0.02] transition-all">
    </div>

    <button type="submit" class="p-3 bg-slate-900 dark:bg-indigo-600 hover:bg-slate-800 dark:hover:bg-indigo-700 text-white rounded-xl shadow-md shadow-indigo-500/[0.05] transition-all transform active:scale-95 cursor-pointer flex items-center justify-center">
        <i data-lucide="send" class="w-4 h-4"></i>
    </button>
</form>
<div id="filePreview" class="hidden text-[10px] text-indigo-600 px-4 py-1 font-semibold"></div>
        </div>

    </div>
</div>
    <script>
        // Function ya kuonyesha Toast ya Kitaalamu
function showToast(message) {
    const toast = document.getElementById('toast-container');
    const toastMsg = document.getElementById('toast-message');
    
    toastMsg.innerText = message;
    
    // Onyesha toast kwa kuongeza class za Tailwind
    toast.classList.remove('opacity-0', 'translate-y-5', 'pointer-events-none');
    toast.classList.add('opacity-100', 'translate-y-0');

    // Ifiche kiotomatiki baada ya sekunde 3
    setTimeout(() => {
        toast.classList.remove('opacity-100', 'translate-y-0');
        toast.classList.add('opacity-0', 'translate-y-5', 'pointer-events-none');
    }, 3000);
}

// Unganisha na vitufe vya Voice na Video Call
document.querySelectorAll('[data-lucide="phone"], [data-lucide="video"]').forEach(btn => {
    btn.parentElement.addEventListener('click', (e) => {
        e.preventDefault();
        showToast("Voice and Video calling features are coming soon!");
    });
});

        // 1. Kufungua na kufunga Notification Dropdown
function toggleNotificationPopup(e) {
    e.stopPropagation();
    
    // Funga profile popup kama ipo wazi ili zisigongane
    const profilePopup = document.getElementById('profilePopup');
    if (profilePopup && !profilePopup.classList.contains('hidden')) {
        profilePopup.classList.add('hidden', 'opacity-0', 'scale-95', 'pointer-events-none');
    }

    const popup = document.getElementById('notificationPopup');
    popup.classList.toggle('hidden');
    setTimeout(() => {
        popup.classList.toggle('opacity-0');
        popup.classList.toggle('scale-95');
        popup.classList.toggle('pointer-events-none');
    }, 10);
}

// 2. Kufuta dot nyeusi na badge (Mark All Read)
function markAllNotificationsRead(e) {
    e.stopPropagation();
    
    // Ondoa doti zote nyeusi
    document.querySelectorAll('.notif-dot').forEach(dot => dot.remove());
    
    // Rekebisha opacity ya vitu ambavyo havijasomwa vionekane vimeshasomwa
    document.querySelectorAll('.notif-item.unread').forEach(item => {
        item.classList.remove('unread');
        item.classList.add('opacity-75');
        // Badilisha font weight kutoka bold kuwa ya kawaida
        const title = item.querySelector('h4');
        if(title) {
            title.classList.remove('font-bold');
            title.classList.add('font-semibold');
            title.classList.replace('text-slate-800', 'text-slate-600');
        }
    });

    // Ficha au ondoa red badge juu ya kengele
    const badge = document.getElementById('notificationBadge');
    if (badge) badge.classList.add('hidden');

    // Weka idadi ya taarifa kuwa 0
    const countBadge = document.getElementById('notifCountBadge');
    if (countBadge) countBadge.textContent = '0';
    
    // SweetAlert kuleta mrejesho wa kuvutia
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        title: 'All notifications marked as read',
        showConfirmButton: false,
        timer: 2000,
        background: document.documentElement.classList.contains('dark') ? '#0f172a' : '#fff',
        color: document.documentElement.classList.contains('dark') ? '#fff' : '#000'
    });
}

// Hakikisha popup inafunga ukibonyeza popote nje ya card
window.addEventListener('click', () => {
    const notifPopup = document.getElementById('notificationPopup');
    if (notifPopup && !notifPopup.classList.contains('hidden')) {
        notifPopup.classList.add('hidden', 'opacity-0', 'scale-95', 'pointer-events-none');
    }
});
        // Inicializar Lucide Icons
        lucide.createIcons();

        // 1. Kufungua na Kufunga Sidebar kwenye Simu
        function toggleSidebar(e) {
            e.preventDefault();
            const sidebar = document.getElementById('sidebarNav');
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
            } else {
                sidebar.classList.add('-translate-x-full');
            }
        }

        // 2. Kufungua na Kufunga Profile Popup Card
        function toggleProfilePopup(e) {
            e.stopPropagation();
            const popup = document.getElementById('profilePopup');
            popup.classList.toggle('hidden');
            setTimeout(() => {
                popup.classList.toggle('opacity-0');
                popup.classList.toggle('scale-95');
                popup.classList.toggle('pointer-events-none');
            }, 10);
        }

        window.addEventListener('click', () => {
            const popup = document.getElementById('profilePopup');
            if (popup && !popup.classList.contains('hidden')) {
                popup.classList.add('hidden', 'opacity-0', 'scale-95', 'pointer-events-none');
            }
        });

        // 3. Mfumo wa Live Search ya Conversations
        const searchInput = document.getElementById('chatSearchInput');
        if (searchInput) {
            searchInput.addEventListener('input', function(e) {
                const query = e.target.value.toLowerCase().trim();
                const chatItems = document.querySelectorAll('.chat-user-item');
                
                chatItems.forEach(item => {
                    const nameText = item.querySelector('.user-name').textContent.toLowerCase();
                    if (nameText.includes(query)) {
                        item.style.display = 'flex';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        }

        // 4. Mfumo wa Dark Mode Switcher Linkage
        const themeToggleBtn = document.getElementById('theme-toggle');
        const darkIcon = document.getElementById('theme-toggle-dark-icon');
        const lightIcon = document.getElementById('theme-toggle-light-icon');

        function updateThemeIcons() {
            if (document.documentElement.classList.contains('dark')) {
                lightIcon.classList.remove('hidden');
                darkIcon.classList.add('hidden');
            } else {
                darkIcon.classList.remove('hidden');
                lightIcon.classList.add('hidden');
            }
        }
        updateThemeIcons();

        if (themeToggleBtn) {
            themeToggleBtn.addEventListener('click', () => {
                document.documentElement.classList.toggle('dark');
                if (document.documentElement.classList.contains('dark')) {
                    localStorage.setItem('color-theme', 'dark');
                } else {
                    localStorage.setItem('color-theme', 'light');
                }
                updateThemeIcons();
            });
        }

        // 5. Mfumo wa Kubonyeza na Kufungua Chat Upande wa Kulia (Kulingana na picha image_9cb36d.png)
        document.querySelectorAll('.chat-user-item').forEach(button => {
            button.addEventListener('click', function() {
                // Ondoa active class kwa wengine wote na weka kwa huyu aliyebonyezwa
                document.querySelectorAll('.chat-user-item').forEach(i => i.classList.remove('bg-indigo-50/50', 'dark:bg-indigo-950/20', 'border-indigo-100', 'dark:border-slate-800'));
                this.classList.add('bg-indigo-50/50', 'dark:bg-indigo-950/20', 'border-indigo-100', 'dark:border-slate-800');

                // Pata data za mtumiaji
                const name = this.getAttribute('data-name') || 'User';
                const initials = this.getAttribute('data-initials') || 'U';

                // Badilisha maudhui ya header upande wa kulia
                document.getElementById('targetUserName').textContent = name;
                document.getElementById('targetUserInitials').textContent = initials;

                // Ficha 'Empty State' na uonyeshe 'Active Chat interface'
                document.getElementById('emptyChatState').classList.add('hidden');
                document.getElementById('activeChatState').classList.remove('hidden');

                // Scroll hadi chini ya meseji mpya zionekane kwanza
                const container = document.getElementById('messagesContainer');
                container.scrollTop = container.scrollHeight;
            });
        });

        // 6. Kazi ya Kutuma Ujumbe Mpya kwa Muonekano wa Live
        function handleSendMessage(event) {
            event.preventDefault();
            const input = document.getElementById('messageInput');
            const msgText = input.value.trim();
            if (!msgText) return;

            const container = document.getElementById('messagesContainer');
            
            // Tengeneza muundo wa Bubble mpya ya Outgoing message
            const outBubble = document.createElement('div');
            outBubble.className = "flex items-end justify-end space-y-1 ml-auto max-w-[75%] animate-fade-in-up";
            
            const now = new Date();
            let hours = now.getHours();
            let minutes = now.getMinutes();
            const ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12;
            hours = hours ? hours : 12;
            minutes = minutes < 10 ? '0'+minutes : minutes;
            const timeStr = hours + ':' + minutes + ' ' + ampm;

            outBubble.innerHTML = `
                <div class="bg-slate-900 dark:bg-indigo-600 text-white p-3.5 rounded-2xl rounded-tr-none text-xs shadow-xs leading-relaxed">
                    ${escapeHtml(msgText)}
                    <div class="text-[9px] text-indigo-200/70 dark:text-indigo-100/70 text-right mt-1.5 font-medium flex items-center justify-end gap-1">
                        <span>${timeStr}</span>
                        <i data-lucide="check" class="w-3 h-3"></i>
                    </div>
                </div>
            `;

            container.appendChild(outBubble);
            input.value = ''; 
            lucide.createIcons(); 
            
            container.scrollTop = container.scrollHeight;
        }

        function escapeHtml(text) {
            return text.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
        }

        // Dropdown Menu Toggles kwa ajili ya Sidebar
        document.querySelectorAll('.toggle-menu-btn').forEach(button => {
            button.addEventListener('click', () => {
                const group = button.closest('.menu-group');
                if (!group) return;
                const content = group.querySelector('.menu-content');
                const arrow = button.querySelector('.arrow-icon');
                if (content) {
                    content.classList.toggle('hidden');
                    if (arrow) {
                        arrow.style.transform = content.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(90deg)';
                    }
                }
            });
        });

let activeReceiverId = null; 
let chatInterval = null;

// CSRF Token ya Yii2 kwa ajili ya usalama wa fomu
const csrfToken = '<?= Yii::$app->request->getCsrfToken() ?>';

// 1. Kuchagua Mpangaji na kufungua Chat yake
document.querySelectorAll('.chat-user-item').forEach(button => {
    button.addEventListener('click', function() {
        activeReceiverId = this.getAttribute('data-id');
        const name = this.getAttribute('data-name');
        const initials = this.getAttribute('data-initials');

        // Sasisha jina na herufi kwenye kichwa cha chat (Header)
        document.getElementById('targetUserName').innerText = name;
        document.getElementById('targetUserInitials').innerText = initials;

        // Onyesha sanduku la chat
        document.getElementById('emptyChatState').classList.add('hidden');
        document.getElementById('activeChatState').classList.remove('hidden');

        // Vuta ujumbe mara ya kwanza na weka timer ya kurudia kila baada ya sekunde 3
        fetchNewMessages();
        clearInterval(chatInterval);
        chatInterval = setInterval(fetchNewMessages, 3000);
    });
});

// 2. Kuvuta ujumbe (Fetch Messages) kutoka Database
function fetchNewMessages() {
    if (!activeReceiverId) return;

    fetch(`<?= \yii\helpers\Url::to(['landlord/fetch-messages']) ?>?receiver_id=${activeReceiverId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const container = document.getElementById('messagesContainer');
                container.innerHTML = ''; // Safisha eneo la chat

                data.messages.forEach(msg => {
                    const isMe = msg.sender_id == data.current_user;
                    const time = new Date(msg.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
                    
                    let fileHtml = '';
                    if (msg.file_path) {
                        fileHtml = `<div class="mt-1 p-2 bg-slate-100 dark:bg-slate-700 rounded text-[11px]"><a href="<?= Yii::$app->request->baseUrl ?>/${msg.file_path}" target="_blank" class="text-blue-500 underline flex items-center gap-1">📁 View Attachment</a></div>`;
                    }

                    const msgHtml = isMe ? `
                        <div class="flex items-end justify-end ml-auto max-w-[75%]">
                            <div class="bg-slate-900 dark:bg-indigo-600 text-white p-3.5 rounded-2xl rounded-tr-none text-xs shadow-xs">
                                <div>${msg.message}</div>
                                ${fileHtml}
                                <div class="text-[9px] text-indigo-200/70 text-right mt-1">${time}</div>
                            </div>
                        </div>
                    ` : `
                        <div class="flex items-start max-w-[75%]">
                            <div class="bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200 p-3.5 rounded-2xl rounded-tl-none border border-slate-100 dark:border-slate-700/40 text-xs shadow-xs">
                                <div>${msg.message}</div>
                                ${fileHtml}
                                <div class="text-[9px] text-slate-400 text-left mt-1">${time}</div>
                            </div>
                        </div>
                    `;
                    container.insertAdjacentHTML('beforeend', msgHtml);
                });
                container.scrollTop = container.scrollHeight; // Shusha chini kabisa kwenye ujumbe wa mwisho
            }
        });
}

// alerts
document.querySelectorAll('[data-lucide="phone"], [data-lucide="video"]').forEach(btn => {
    btn.parentElement.addEventListener('click', (e) => {
        e.preventDefault();
        
        Swal.fire({
            title: 'Coming Soon!',
            text: 'We are working hard to bring Voice & Video calls to your dashboard.',
            icon: 'info',
            background: document.documentElement.classList.contains('dark') ? '#1e293b' : '#ffffff',
            color: document.documentElement.classList.contains('dark') ? '#ffffff' : '#0f172a',
            confirmButtonColor: '#4f46e5', // Rangi ya Indigo inayoendana na mfumo wako
            confirmButtonText: 'Understood',
            customClass: {
                popup: 'rounded-2xl shadow-xl'
            }
        });
    });
});


// Tafuta vitufe vyote vitatu vilivyo upande wa kulia wa header ya chat
// (Kupitia selector ya 'button' zilizo ndani ya flex container ya header)
document.querySelectorAll('#activeChatState .h-16 .flex.items-center.space-x-2 button').forEach((parentButton, index) => {
    
    // Hakikisha tunafuta onclick yoyote ya zamani iliyojificha
    parentButton.onclick = null;
    
    // Ongeza msikilizaji mpya wa kitaalamu
    parentButton.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation(); // Inazuia alert ya localhost isijirudie kabisa
        
        // index === 0 ni Phone, index === 1 ni Video, index === 2 ni Info
        if (index === 2) {
            showToast("Tenant details and conversation settings coming soon!");
        } else if (index === 0 || index === 1) {
            showToast("Voice and Video calling features are coming soon!");
        }
    });
});

// 3. Kutuma Ujumbe (Send Message) kwa AJAX
document.getElementById('messageSendForm').addEventListener('submit', function(e) {
    e.preventDefault();
    if (!activeReceiverId) return;

    const input = document.getElementById('messageInput');
    const fileInput = document.getElementById('fileInput');
    
    if (input.value.trim() === '' && fileInput.files.length === 0) return;

    const formData = new FormData();
    formData.append('receiver_id', activeReceiverId);
    formData.append('message', input.value);
    formData.append('_csrf', csrfToken);
    if (fileInput.files[0]) {
        formData.append('attachment', fileInput.files[0]);
    }

    fetch(`<?= \yii\helpers\Url::to(['landlord/send-message']) ?>`, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            input.value = ''; // Safisha sehemu ya maandishi
            fileInput.value = ''; // Safisha file input
            document.getElementById('filePreview').classList.add('hidden');
            fetchNewMessages(); // Vuta meseji mpya haraka
        }
    });
});

// Onyesha jina la faili lililochaguliwa
function previewFile() {
    const fileInput = document.getElementById('fileInput');
    const preview = document.getElementById('filePreview');
    if (fileInput.files[0]) {
        preview.innerText = `Selected: ${fileInput.files[0].name}`;
        preview.classList.remove('hidden');
    }
}

// 4. Usalama: Kuzuia udukuzi wa maandishi (XSS Protection)
function escapeHtml(text) {
    const map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return text.replace(/[&<>"']/g, function(m) { return map[m]; });
}

    </script>
    
</body>
</html>