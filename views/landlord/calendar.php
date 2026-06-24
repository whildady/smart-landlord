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
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Settings</span>
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

                <div class="text-right hidden sm:block">
                    <p class="text-xs font-semibold text-slate-800 dark:text-slate-200"><?php echo Html::encode(Yii::$app->user->identity->name ?? 'User'); ?></p>
                    <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mt-0.5"><?php echo Html::encode(Yii::$app->user->identity->role ?? 'Landlord'); ?></p>
                </div>
                
                <button onclick="toggleProfilePopup(event)" id="profileBtn" class="w-9 h-9 rounded-xl relative overflow-hidden shadow-sm border border-slate-200/60 dark:border-slate-700 group cursor-pointer block focus:outline-none transition-transform active:scale-95">
                    <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Default Profile" class="w-full h-full object-cover">
                </button>
            </div>
        </header>

        <div class="p-6 max-w-7xl mx-auto grid grid-cols-1 xl:grid-cols-3 gap-6 w-full">
            
            <div class="xl:col-span-2 bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/60 dark:border-slate-800/60 p-6 shadow-xs flex flex-col">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-2">
                        <button id="prev-month" class="w-8 h-8 flex items-center justify-center rounded-lg border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800 text-slate-600 dark:text-slate-300 transition-all active:scale-95 cursor-pointer">
                            <i data-lucide="chevron-left" class="w-4 h-4"></i>
                        </button>
                        <button id="next-month" class="w-8 h-8 flex items-center justify-center rounded-lg border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800 text-slate-600 dark:text-slate-300 transition-all active:scale-95 cursor-pointer">
                            <i data-lucide="chevron-right" class="w-4 h-4"></i>
                        </button>
                        <h2 id="calendar-month-year" class="text-xl font-bold text-slate-800 dark:text-white ml-2">February 2026</h2>
                    </div>
                    
                    <button id="go-today" class="px-4 py-1.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 text-slate-700 dark:text-slate-200 text-xs font-semibold rounded-lg shadow-2xs cursor-pointer">
                        Today
                    </button>
                </div>

                <div class="grid grid-cols-7 gap-px text-center mb-2 border-b border-slate-100 dark:border-slate-800 pb-2">
                    <div class="text-xs font-semibold text-slate-400">Sun</div>
                    <div class="text-xs font-semibold text-slate-400">Mon</div>
                    <div class="text-xs font-semibold text-slate-400">Tue</div>
                    <div class="text-xs font-semibold text-slate-400">Wed</div>
                    <div class="text-xs font-semibold text-slate-400">Thu</div>
                    <div class="text-xs font-semibold text-slate-400">Fri</div>
                    <div class="text-xs font-semibold text-slate-400">Sat</div>
                </div>

                <div id="calendar-days-container" class="grid grid-cols-7 gap-px bg-slate-100 dark:bg-slate-800 rounded-2xl overflow-hidden border border-slate-200/50 dark:border-slate-800/50">
                    </div>
            </div>

            <div class="space-y-6">
                <div id="details-card" class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/60 dark:border-slate-800/60 p-6 min-h-[280px] shadow-xs transition-all flex flex-col items-center justify-center text-center">
                    <div class="w-12 h-12 rounded-full bg-slate-50 dark:bg-slate-800 flex items-center justify-center text-slate-400 mb-4 border border-slate-100 dark:border-slate-700/50">
                        <i data-lucide="clock" class="w-5 h-5"></i>
                    </div>
                    <h3 class="text-sm font-bold text-slate-800 dark:text-white">No date selected</h3>
                    <p class="text-xs text-slate-400 dark:text-slate-500 mt-1 max-w-[200px]">Click a day on the calendar to view its events</p>
                </div>

                <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/60 dark:border-slate-800/60 p-6 shadow-xs">
                    <h3 class="text-sm font-bold text-slate-800 dark:text-white mb-6">Upcoming Events</h3>
                    <div id="upcoming-events-container" class="space-y-3 max-h-[350px] overflow-y-auto sidebar-scroll">
                        <div class="flex flex-col items-center justify-center py-10 text-center">
                            <p class="text-xs font-medium text-slate-400 dark:text-slate-500">No upcoming events</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div id="add-event-modal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs flex items-center justify-center z-50 hidden transition-all duration-300">
    <div class="bg-white dark:bg-slate-900 rounded-2xl w-full max-w-lg p-6 shadow-xl border border-slate-100 dark:border-slate-800 m-4 transform scale-95 transition-transform duration-300">
        <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3 mb-5">
            <div>
                <h3 class="text-base font-bold text-slate-900 dark:text-white">Add Event</h3>
                <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">Create a new event on your calendar.</p>
            </div>
            <button id="close-modal-btn" type="button" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 p-1 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800 cursor-pointer">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>

        <form id="event-form" class="space-y-4">
            <div>
                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Title <span class="text-rose-500">*</span></label>
                <input type="text" id="event-title-input" placeholder="Event title" class="w-full px-3 py-2 text-sm border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 bg-transparent dark:text-white" required>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Date <span class="text-rose-500">*</span></label>
                <input type="date" id="modal-date-input" class="w-full px-3 py-2 text-sm border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 bg-transparent dark:text-white" required>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Start Time</label>
                    <input type="time" id="event-start-input" value="09:00" class="w-full px-3 py-2 text-sm border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 bg-transparent dark:text-white">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">End Time</label>
                    <input type="time" id="event-end-input" value="10:00" class="w-full px-3 py-2 text-sm border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 bg-transparent dark:text-white">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Color / Tag</label>
                <select id="event-color-input" class="w-full px-3 py-2 text-sm border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 bg-white dark:bg-slate-800 dark:text-white">
                    <option value="success">Success (Emerald)</option>
                    <option value="Primary">Primary (Blue)</option>
                    <option value="Warning">Warning (Amber)</option>
                    <option value="Danger">Danger (Rose)</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Description</label>
                <textarea id="event-desc-input" rows="3" placeholder="Optional description" class="w-full px-3 py-2 text-sm border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 bg-transparent dark:text-white"></textarea>
            </div>

            <div class="flex justify-end pt-2 border-t border-slate-100 dark:border-slate-800 mt-4">
                <button type="submit" class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white text-xs font-semibold rounded-xl shadow-xs transition-colors cursor-pointer">
                    Create Event
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    lucide.createIcons();

    let currentActiveDate = new Date(2026, 1, 1); 
    let highlightedDateValue = ""; 

    const monthYearLabel = document.getElementById("calendar-month-year");
    const daysContainer = document.getElementById("calendar-days-container");
    const detailsCard = document.getElementById("details-card");
    const modal = document.getElementById("add-event-modal");
    const closeModalBtn = document.getElementById("close-modal-btn");
    const modalDateInput = document.getElementById("modal-date-input");
    const eventForm = document.getElementById("event-form");

    // Sasa database inaanza ikiwa tupu, itajazwa kutoka MySQL dynamically
    let calendarEventsDatabase = {};

    const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    const weekDaysNames = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];

    // Kazi ya kuvuta data live kutoka Yii2 Controller via AJAX
    function fetchLiveEventsFromDatabase() {
        fetch('<?= Url::to(['landlord/get-events']) ?>')
            .then(response => response.json())
            .then(data => {
                calendarEventsDatabase = data;
                // Baada ya kupokea data, chora upya kalenda na list ya upcoming
                generateCalendarGrid();
                updateUpcomingEventsList();

                // Kama kuna siku ilikuwa imechaguliwa upande wa kulia, isasishe pia
                if (highlightedDateValue) {
                    const activeDayEl = document.querySelector(`.calendar-day[data-date="${highlightedDateValue}"]`);
                    if (activeDayEl) {
                        const dateStringFull = activeDayEl.getAttribute("data-date-string");
                        updateSideDetailsCard(highlightedDateValue, dateStringFull);
                    }
                }
            })
            .catch(error => console.error('Error fetching events:', error));
    }

    // 1. Kazi Kuu ya Kuchora Gridi
    function generateCalendarGrid() {
        const currentYear = currentActiveDate.getFullYear();
        const currentMonth = currentActiveDate.getMonth();

        monthYearLabel.textContent = `${monthNames[currentMonth]} ${currentYear}`;

        const firstDayDayIndex = new Date(currentYear, currentMonth, 1).getDay();
        const totalMonthDays = new Date(currentYear, currentMonth + 1, 0).getDate();

        daysContainer.innerHTML = "";

        // Padding Days
        for (let i = 0; i < firstDayDayIndex; i++) {
            const emptyCell = document.createElement("div");
            emptyCell.className = "bg-slate-50/40 dark:bg-slate-900/40 min-h-[105px] p-3 border-r border-b border-slate-100 dark:border-slate-800 opacity-30";
            daysContainer.appendChild(emptyCell);
        }

        // Active Days Loop
        for (let day = 1; day <= totalMonthDays; day++) {
            const dayCell = document.createElement("div");
            const compiledDateStr = `${currentYear}-${String(currentMonth + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
            
            const currentWeekDayName = weekDaysNames[new Date(currentYear, currentMonth, day).getDay()];
            const fullDateFriendlyString = `${currentWeekDayName}, ${monthNames[currentMonth]} ${day}, ${currentYear}`;

            dayCell.className = "calendar-day bg-white dark:bg-slate-900 min-h-[105px] p-3 flex flex-col justify-between cursor-pointer hover:bg-slate-50/80 transition-all border-r border-b border-slate-100 dark:border-slate-800 select-none";
            dayCell.setAttribute("data-date", compiledDateStr);
            dayCell.setAttribute("data-date-string", fullDateFriendlyString);
            
            if (highlightedDateValue === compiledDateStr) {
                dayCell.classList.add("bg-slate-50/80", "ring-1", "ring-inset", "ring-slate-200");
            }

            const dateAssociatedEvents = calendarEventsDatabase[compiledDateStr] || [];
            dayCell.setAttribute("data-events", JSON.stringify(dateAssociatedEvents));

            let labelsHtml = "";
            dateAssociatedEvents.forEach(ev => {
                let colorClass = "bg-slate-100 text-slate-700";
                if(ev.badge.toLowerCase() === "success") colorClass = "bg-emerald-50 text-emerald-700 dark:bg-emerald-950/30 dark:text-emerald-400";
                if(ev.badge.toLowerCase() === "warning") colorClass = "bg-amber-50 text-amber-700 dark:bg-amber-950/30 dark:text-amber-400";
                if(ev.badge.toLowerCase() === "primary") colorClass = "bg-blue-50 text-blue-700 dark:bg-blue-950/30 dark:text-blue-400";
                if(ev.badge.toLowerCase() === "danger") colorClass = "bg-rose-50 text-rose-700 dark:bg-rose-950/30 dark:text-rose-400";

                labelsHtml += `<div class="text-[11px] ${colorClass} px-2 py-0.5 rounded-md font-medium truncate w-full">${ev.title}</div>`;
            });

            dayCell.innerHTML = `
                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">${day}</span>
                <div class="space-y-1 w-full overflow-hidden">${labelsHtml}</div>
            `;

            dayCell.addEventListener("click", triggerDateSelectionChange);
            daysContainer.appendChild(dayCell);
        }

        if (typeof lucide !== "undefined") {
            lucide.createIcons();
        }
    }

    function triggerDateSelectionChange() {
        document.querySelectorAll(".calendar-day").forEach(d => d.classList.remove("bg-slate-50/80", "ring-1", "ring-inset", "ring-slate-200"));
        this.classList.add("bg-slate-50/80", "ring-1", "ring-inset", "ring-slate-200");

        const dateValue = this.getAttribute("data-date");
        const dateStringFull = this.getAttribute("data-date-string");
        highlightedDateValue = dateValue;

        updateSideDetailsCard(dateValue, dateStringFull);
    }

    function updateSideDetailsCard(dateValue, dateStringFull) {
        const selectedEvents = calendarEventsDatabase[dateValue] || [];

        if (selectedEvents.length === 0) {
            detailsCard.className = "bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/60 dark:border-slate-800/60 p-6 shadow-xs min-h-[280px] text-left transition-all flex flex-col justify-between animate-fade-in-up";
            detailsCard.innerHTML = `
                <div class="w-full flex flex-col flex-1">
                    <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3 mb-4 w-full">
                        <div>
                            <h3 class="text-sm font-bold text-slate-800 dark:text-white">${dateStringFull}</h3>
                            <p class="text-[11px] text-slate-400 mt-0.5">No events scheduled</p>
                        </div>
                        <button onclick="openAddEventModal('${dateValue}')" class="flex items-center gap-1.5 px-3 py-1.5 border border-slate-200 rounded-lg text-xs font-bold text-slate-700 hover:bg-slate-50 transition-all cursor-pointer">
                            <i data-lucide="plus" class="w-3.5 h-3.5"></i> Add
                        </button>
                    </div>
                    <div class="flex flex-col items-center justify-center flex-1 py-6 w-full text-center">
                        <div class="w-10 h-10 rounded-full bg-slate-50 dark:bg-slate-800 flex items-center justify-center text-slate-400 mb-3 border border-slate-100 dark:border-slate-700/50">
                            <i data-lucide="clock" class="w-4 h-4"></i>
                        </div>
                        <p class="text-xs text-slate-400 font-medium">No events for this day</p>
                        <button onclick="openAddEventModal('${dateValue}')" class="text-xs font-bold text-slate-800 hover:underline mt-1 cursor-pointer">Create one</button>
                    </div>
                </div>`;
        } else {
            let htmlList = selectedEvents.map(event => `
                <div class="p-4 rounded-xl border border-slate-100 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-2xs space-y-2 text-left w-full">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            <h4 class="text-xs font-bold text-slate-800 dark:text-white">${event.title}</h4>
                        </div>
                        <span class="text-[10px] px-2 py-0.5 rounded-md font-bold uppercase tracking-wider ${event.badgeClass}">${event.badge}</span>
                    </div>
                    <p class="text-[11px] text-slate-400 flex items-center gap-1">
                        <i data-lucide="clock" class="w-3 h-3"></i> ${event.time}
                    </p>
                    <p class="text-[11px] text-slate-500 pl-4">${event.desc}</p>
                </div>`).join('');

            detailsCard.className = "bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/60 dark:border-slate-800/60 p-6 shadow-xs min-h-[280px] text-left transition-all flex flex-col animate-fade-in-up";
            detailsCard.innerHTML = `
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3 mb-4 w-full">
                    <div>
                        <h3 class="text-sm font-bold text-slate-800 dark:text-white">${dateStringFull}</h3>
                        <p class="text-[11px] text-slate-400 mt-0.5">${selectedEvents.length} event</p>
                    </div>
                    <button onclick="openAddEventModal('${dateValue}')" class="flex items-center gap-1.5 px-3 py-1.5 border border-slate-200 rounded-lg text-xs font-bold text-slate-700 hover:bg-slate-50 transition-all cursor-pointer">
                        <i data-lucide="plus" class="w-3.5 h-3.5"></i> Add
                    </button>
                </div>
                <div class="space-y-3 flex-1 overflow-y-auto w-full">${htmlList}</div>`;
        }

        if (typeof lucide !== "undefined") {
            lucide.createIcons();
        }
    }

    function updateUpcomingEventsList() {
        const upcomingContainer = document.getElementById("upcoming-events-container");
        if (!upcomingContainer) return;

        const today = new Date();
        const todayStr = `${today.getFullYear()}-${String(today.getMonth() + 1).padStart(2, '0')}-${String(today.getDate()).padStart(2, '0')}`;

        let allUpcomingEvents = [];

        Object.keys(calendarEventsDatabase).forEach(dateKey => {
            if (dateKey >= todayStr) {
                calendarEventsDatabase[dateKey].forEach(event => {
                    allUpcomingEvents.push({
                        ...event,
                        rawDate: dateKey,
                        friendlyDate: new Date(dateKey).toLocaleDateString('en-US', { month: 'short', day: '2-digit' })
                    });
                });
            }
        });

        allUpcomingEvents.sort((a, b) => a.rawDate.localeCompare(b.rawDate));

        if (allUpcomingEvents.length === 0) {
            upcomingContainer.innerHTML = `
                <div class="flex flex-col items-center justify-center py-10 text-center">
                    <p class="text-xs font-medium text-slate-400 dark:text-slate-500">No upcoming events</p>
                </div>`;
            return;
        }

        upcomingContainer.innerHTML = allUpcomingEvents.map(event => {
            let dotColor = "bg-blue-500";
            if(event.badge.toLowerCase() === "success") dotColor = "bg-emerald-500";
            if(event.badge.toLowerCase() === "warning") dotColor = "bg-amber-500";
            if(event.badge.toLowerCase() === "danger") dotColor = "bg-rose-500";

            return `
                <div class="flex items-center gap-4 p-3 rounded-xl border border-slate-50 dark:border-slate-800/60 hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-all animate-fade-in-up">
                    <div class="flex flex-col items-center justify-center w-12 h-12 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-100 dark:border-slate-700/50 text-center flex-shrink-0">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">${event.friendlyDate.split(' ')[0]}</span>
                        <span class="text-sm font-bold text-slate-700 dark:text-slate-200">${event.friendlyDate.split(' ')[1]}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="text-xs font-bold text-slate-800 dark:text-white truncate">${event.title}</h4>
                        <p class="text-[11px] text-slate-400 truncate mt-0.5">${event.time}</p>
                    </div>
                    <span class="w-2 h-2 rounded-full ${dotColor} flex-shrink-0 mr-1"></span>
                </div>`;
        }).join('');
    }

    // Kuchakata Fomu na Kutuma data kwenye database live kwa kutumia FormData na Fetch API
    eventForm.addEventListener("submit", function (e) {
        e.preventDefault();

        // Kukusanya data kutoka kwenye input za form
        const formData = new FormData();
        formData.append('title', document.getElementById("event-title-input").value);
        formData.append('date', modalDateInput.value);
        formData.append('start_time', document.getElementById("event-start-input").value);
        formData.append('end_time', document.getElementById("event-end-input").value);
        formData.append('badge', document.getElementById("event-color-input").value);
        formData.append('description', document.getElementById("event-desc-input").value);
        
        // Kuweka CSRF token ya Yii2 ili kuzuia makosa ya ulinzi (Bad Request #400)
        formData.append('<?= Yii::$app->request->csrfParam ?>', '<?= Yii::$app->request->csrfToken ?>');

        // Kutuma kuelekea kwenye Action ya Controller wetu namba 2
        fetch('<?= Url::to(['landlord/create-event']) ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                // Funga modal kwa urembo
                modal.querySelector('.transform').classList.add('scale-95');
                setTimeout(() => {
                    modal.classList.add("hidden");
                }, 150);
                
                eventForm.reset();

                // Vuta upya data zote zilizopo database sasa hivi (Ikiwemo hili jipya)
                fetchLiveEventsFromDatabase();

                Swal.fire({
                    title: "Success!",
                    text: "Event created and saved to database live.",
                    icon: "success",
                    confirmButtonColor: "#1e293b"
                });
            } else {
                Swal.fire({
                    title: "Error!",
                    text: result.message || "Failed to save event.",
                    icon: "error",
                    confirmButtonColor: "#rose-600"
                });
            }
        })
        .catch(error => {
            console.error('Error saving event:', error);
            Swal.fire({ title: "Error!", text: "Something went wrong on the server.", icon: "error" });
        });
    });

    closeModalBtn.addEventListener("click", function() {
        modal.querySelector('.transform').classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add("hidden");
        }, 150);
    });

    modal.addEventListener("click", function(e) {
        if (e.target === modal) {
            closeModalBtn.click();
        }
    });

    document.getElementById("prev-month").addEventListener("click", function () {
        currentActiveDate.setMonth(currentActiveDate.getMonth() - 1); 
        generateCalendarGrid(); 
    });

    document.getElementById("next-month").addEventListener("click", function () {
        currentActiveDate.setMonth(currentActiveDate.getMonth() + 1); 
        generateCalendarGrid(); 
    });

    document.getElementById("go-today").addEventListener("click", function() {
        currentActiveDate = new Date();
        generateCalendarGrid();
    });

    window.openAddEventModal = function(dateValue) {
        if (dateValue) {
            modalDateInput.value = dateValue;
        }
        modal.classList.remove("hidden");
        setTimeout(() => {
            modal.querySelector('.transform').classList.remove('scale-95');
        }, 10);
    };

    // badala ya kuwasha kienyeji, sasa hivi inapakia data live kutoka database ukurasa ukifunguka!
    fetchLiveEventsFromDatabase();
});

function toggleSidebar(e) {
    e.preventDefault();
    document.getElementById('sidebarNav').classList.toggle('-translate-x-full');
}
function toggleProfilePopup(e) {
    e.stopPropagation();
    document.getElementById('profilePopup').classList.toggle('hidden');
}
function toggleNotificationPopup(e) {
    e.stopPropagation();
    document.getElementById('notificationPopup').classList.toggle('hidden');
}
document.querySelectorAll('.toggle-menu-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        const group = btn.closest('.menu-group');
        const content = group.querySelector('.menu-content');
        content.classList.toggle('hidden');
    });
});
</script>
</script>
</body>
</html>