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
        <!-- HEADER YA REPORTS (Imebadilishwa kichwa tu kulingana na picha image_32f6fa.png) -->
        <header class="h-16 bg-white/80 dark:bg-[#0f172a]/80 backdrop-blur-md border-b border-slate-100 dark:border-slate-800/60 flex items-center justify-between px-8 sticky top-0 z-30 transition-colors duration-300">
            <div class="flex items-center gap-4">
                <button onclick="toggleSidebar(event)" id="menuBtn" class="lg:hidden text-slate-500 dark:text-slate-400 p-2 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 cursor-pointer transition-all border border-slate-100 dark:border-slate-800" title="Open Navigation Menu">
                    <i data-lucide="menu" class="w-5 h-5"></i>
                </button>
                <div class="flex flex-col text-left ml-3">
                    <h1 class="text-lg font-bold text-slate-900 dark:text-white leading-tight tracking-tight">Financial Reports</h1>
                    <p class="text-xs font-medium text-slate-400 dark:text-slate-500 mt-1">Schedule and manage events.</p>
                </div>
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

        <!-- HIGH FIDELITY FINANCIAL LAYOUT AREA (Inafuata muundo ule ule wa grid ya calendar) -->
        <div class="p-6 max-w-7xl mx-auto w-full space-y-6">
            
            <!-- A. HIGH FIDELITY TOP KPI CARDS GRID (Kama picha image_32195b.png) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">
                
                <!-- Card 1: Total Revenue -->
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/60 dark:border-slate-800/60 pt-5 px-5 pb-0 shadow-xs relative overflow-hidden flex flex-col justify-between min-h-[140px] animate-fade-in-up">
                    <div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Revenue</span>
                            <div class="w-8 h-8 bg-orange-50 dark:bg-orange-950/40 text-orange-600 rounded-xl flex items-center justify-center font-bold text-xs">Tsh</div>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800 dark:text-white mt-2">Sh <?= number_format($totalRevenue) ?></h3>
                        <p class="text-[11px] text-emerald-500 font-semibold flex items-center gap-1 mt-1">
                            <i data-lucide="trending-up" class="w-3 h-3"></i> +18.2%
                        </p>
                    </div>
                    <div class="w-full h-8"><canvas id="miniChart1"></canvas></div>
                </div>

                <!-- Card 2: Expected Rent -->
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/60 dark:border-slate-800/60 pt-5 px-5 pb-0 shadow-xs relative overflow-hidden flex flex-col justify-between min-h-[140px] animate-fade-in-up">
                    <div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Expected Rent</span>
                            <div class="w-8 h-8 bg-teal-50 dark:bg-teal-950/40 text-teal-600 rounded-xl flex items-center justify-center"><i data-lucide="shopping-bag" class="w-4 h-4"></i></div>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800 dark:text-white mt-2">Sh <?= number_format($expectedBilling) ?></h3>
                        <p class="text-[11px] text-emerald-500 font-semibold flex items-center gap-1 mt-1">
                            <i data-lucide="trending-up" class="w-3 h-3"></i> +4.8%
                        </p>
                    </div>
                    <div class="w-full h-8"><canvas id="miniChart2"></canvas></div>
                </div>

                <!-- Card 3: Total Expenses -->
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/60 dark:border-slate-800/60 pt-5 px-5 pb-0 shadow-xs relative overflow-hidden flex flex-col justify-between min-h-[140px] animate-fade-in-up">
                    <div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Expenses</span>
                            <div class="w-8 h-8 bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 rounded-xl flex items-center justify-center"><i data-lucide="activity" class="w-4 h-4"></i></div>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800 dark:text-white mt-2">Sh <?= number_format($totalExpenses) ?></h3>
                        <p class="text-[11px] text-emerald-500 font-semibold flex items-center gap-1 mt-1">
                            <i data-lucide="trending-up" class="w-3 h-3"></i> +0.8%
                        </p>
                    </div>
                    <div class="w-full h-8"><canvas id="miniChart3"></canvas></div>
                </div>

                <!-- Card 4: Outstanding Debts -->
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/60 dark:border-slate-800/60 pt-5 px-5 pb-0 shadow-xs relative overflow-hidden flex flex-col justify-between min-h-[140px] animate-fade-in-up">
                    <div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Outstanding Debts</span>
                            <div class="w-8 h-8 bg-amber-50 dark:bg-amber-950/40 text-amber-600 rounded-xl flex items-center justify-center"><i data-lucide="rotate-ccw" class="w-4 h-4"></i></div>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800 dark:text-white mt-2">Sh <?= number_format($outstandingDebt) ?></h3>
                        <p class="text-[11px] text-rose-500 font-semibold flex items-center gap-1 mt-1">
                            <i data-lucide="trending-down" class="w-3 h-3"></i> -0.3%
                        </p>
                    </div>
                    <div class="w-full h-8"><canvas id="miniChart4"></canvas></div>
                </div>
            </div>

            <!-- B. MAIN GRID SYSTEM: Inafuata mtiririko sahihi wa muundo wa kalenda -->
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 w-full">
                
                <!-- UPANDE WA KUSHOTO (Boksi Kubwa la Gridi): Overview Area Flow Chart -->
                <div class="xl:col-span-2 bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/60 dark:border-slate-800/60 p-6 shadow-xs flex flex-col justify-between">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex flex-col text-left">
                            <h3 class="text-sm font-bold text-slate-800 dark:text-white">Sales Overview</h3>
                            <p class="text-[11px] text-slate-400 mt-0.5">Performance statement for the current year</p>
                        </div>
                        <div class="bg-slate-100 dark:bg-slate-800 p-1 rounded-xl flex gap-1 text-[11px] font-bold text-slate-500">
                            <button class="bg-white dark:bg-slate-700 dark:text-white shadow-xs px-3 py-1 rounded-lg text-slate-800">Revenue</button>
                            <button class="px-3 py-1 rounded-lg hover:text-slate-800">Expenses</button>
                        </div>
                    </div>
                    <div class="relative w-full h-[320px]">
                        <canvas id="mainAreaChart"></canvas>
                    </div>
                </div>

                <!-- UPANDE WA KULIA (Details Side Card Container): Distribution Doughnut -->
                <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/60 dark:border-slate-800/60 p-6 shadow-xs flex flex-col justify-between min-h-[380px]">
                    <div class="flex flex-col text-left mb-4">
                        <h3 class="text-sm font-bold text-slate-800 dark:text-white">Bills Distribution</h3>
                        <p class="text-[11px] text-slate-400 mt-0.5">Distribution of utility categories</p>
                    </div>
                    
                    <div class="relative w-full h-[220px] flex justify-center items-center">
                        <canvas id="premiumDoughnutChart"></canvas>
                        <div class="absolute flex flex-col items-center justify-center text-center">
                            <span class="text-xl font-black text-slate-800 dark:text-white">Sh <?= number_format($totalBillsCount) ?></span>
                            <span class="text-[10px] uppercase font-bold tracking-wider text-slate-400 mt-0.5">Total Bills</span>
                        </div>
                    </div>
                    
                    <div class="text-[11px] text-slate-400 text-center mt-2 font-medium">Auto-calculated via MySQL instances</div>
                </div>

            </div>

        </div>
    </div>

    <!-- ENGINE YA CHART ANALYTICS LOGIC (CHART.JS) -->
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        lucide.createIcons();

        // Mini charts drawing algorithms for top KPI wave effect
        const miniOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { x: { display: false }, y: { display: false } },
            elements: { point: { radius: 0 }, line: { borderWidth: 1.5, tension: 0.4 } }
        };

        new Chart(document.getElementById('miniChart1').getContext('2d'), {
            type: 'line',
            data: { labels: [1,2,3,4,5,6], datasets: [{ data: [12,14,13,15,16,18], borderColor: '#f97316', backgroundColor: 'transparent' }] },
            options: miniOptions
        });

        new Chart(document.getElementById('miniChart2').getContext('2d'), {
            type: 'line',
            data: { labels: [1,2,3,4,5,6], datasets: [{ data: [10,12,11,14,13,15], borderColor: '#0d9488', backgroundColor: 'transparent' }] },
            options: miniOptions
        });

        new Chart(document.getElementById('miniChart3').getContext('2d'), {
            type: 'line',
            data: { labels: [1,2,3,4,5,6], datasets: [{ data: [8,9,7,11,10,12], borderColor: '#4f46e5', backgroundColor: 'transparent' }] },
            options: miniOptions
        });

        new Chart(document.getElementById('miniChart4').getContext('2d'), {
            type: 'line',
            data: { labels: [1,2,3,4,5,6], datasets: [{ data: [15,14,13,12,11,10], borderColor: '#d97706', backgroundColor: 'transparent' }] },
            options: miniOptions
        });

        // 2. Main smooth trend area flow lines
        const mainCtx = document.getElementById('mainAreaChart').getContext('2d');
        const revGradient = mainCtx.createLinearGradient(0, 0, 0, 300);
        revGradient.addColorStop(0, 'rgba(249, 115, 22, 0.25)');
        revGradient.addColorStop(1, 'rgba(249, 115, 22, 0.00)');

        const expGradient = mainCtx.createLinearGradient(0, 0, 0, 300);
        expGradient.addColorStop(0, 'rgba(13, 148, 136, 0.20)');
        expGradient.addColorStop(1, 'rgba(13, 148, 136, 0.00)');

        new Chart(mainCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [
                    {
                        label: 'Revenue (Tsh)',
                        data: <?= $monthlyRevenue ?>,
                        borderColor: '#f97316',
                        backgroundColor: revGradient,
                        fill: true,
                        tension: 0.4,
                        borderWidth: 2.5
                    },
                    {
                        label: 'Expenses (Tsh)',
                        data: <?= $monthlyExpenses ?>,
                        borderColor: '#0d9488',
                        backgroundColor: expGradient,
                        fill: true,
                        tension: 0.4,
                        borderWidth: 2
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: true, position: 'bottom' } },
                scales: {
                    x: { grid: { display: false } },
                    y: { border: { dash: [5, 5] }, ticks: { callback: value => 'Sh ' + value.toLocaleString() } }
                }
            }
        });

        // 3. Right distribution chart engine
        const doughnutCtx = document.getElementById('premiumDoughnutChart').getContext('2d');
        new Chart(doughnutCtx, {
            type: 'doughnut',
            data: {
                labels: <?= $pieLabels ?>,
                datasets: [{
                    data: <?= $pieData ?>,
                    backgroundColor: ['#ea580c', '#0d9488', '#1e1b4b', '#f59e0b', '#ec4899'],
                    borderWidth: 4,
                    borderColor: document.documentElement.classList.contains('dark') ? '#0f172a' : '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                cutout: '75%'
            }
        });
    });

    function toggleSidebar(e) {
        e.preventDefault();
        document.getElementById('sidebarNav').classList.toggle('-translate-x-full');
    }
    document.querySelectorAll('.toggle-menu-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const group = btn.closest('.menu-group');
            const content = group.querySelector('.menu-content');
            content.classList.toggle('hidden');
        });
    });
    </script>
</body>
</html>