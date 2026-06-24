<?php
/** @var yii\web\View $this */
use yii\helpers\Url;
use yii\helpers\Html;
// Get the current route used in the application
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
                        <i data-lucide="chevron-down" class="w-3 h-3 text-slate-400 transition-transform duration-200 arrow-icon" style="<?= $isOperationsOpen ? 'transform: rotate(90deg);' : '' ?>"></i>
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
                        <i data-lucide="log-out" class="w-4 h-4 mr-3 stroke-[2.5] group-hover:translate-x-0.5 group-hover:scale-105 transition-all duration-300 ease-out text-rose-600 dark:text-rose-400"></i>
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

    <!-- PROFESSIONAL DOCUMENT VIEWER MODAL -->
<div id="viewerModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[100] hidden flex items-center justify-center p-4">
    <div class="bg-white dark:bg-slate-900 rounded-3xl w-full max-w-4xl h-[80vh] shadow-2xl flex flex-col overflow-hidden transform transition-all">
        <div class="flex items-center justify-between p-4 border-b border-slate-100 dark:border-slate-800">
            <h3 class="text-sm font-bold text-slate-900 dark:text-white" id="viewerTitle">Document Viewer</h3>
            <div class="flex items-center gap-2">
                <!-- Download Button iliyoongezwa -->
                <a id="viewerDownloadBtn" href="#" download class="text-indigo-600 hover:text-indigo-700 bg-indigo-50 dark:bg-indigo-950 px-3 py-1.5 rounded-lg text-[10px] font-bold flex items-center gap-1">
                    <i data-lucide="download" class="w-3.5 h-3.5"></i> Download
                </a>
                <button onclick="closeViewerModal()" class="text-slate-400 hover:text-slate-600 bg-slate-50 dark:bg-slate-800 p-2 rounded-xl">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
        </div>
        <div class="flex-1 w-full h-full bg-slate-100 dark:bg-slate-950">
            <iframe id="viewerIframe" src="" class="w-full h-full border-0"></iframe>
        </div>
    </div>
</div>

    <div class="flex-1 flex flex-col min-w-0 w-full lg:pl-64">
        
        <header class="h-16 bg-white/80 dark:bg-[#0f172a]/80 backdrop-blur-md border-b border-slate-100 dark:border-slate-800/60 flex items-center justify-between px-8 sticky top-0 z-30 transition-colors duration-300">
            <div class="flex items-center gap-4">
                <button onclick="toggleSidebar(event)" id="menuBtn" class="lg:hidden text-slate-500 dark:text-slate-400 p-2 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 cursor-pointer transition-all border border-slate-100 dark:border-slate-800" title="Open Navigation Menu">
                    <i data-lucide="menu" class="w-5 h-5"></i>
                </button>
                <div class="flex flex-col text-left ml-3">
                    <h1 class="text-lg font-bold text-slate-900 dark:text-white leading-tight tracking-tight">Lease Agreements</h1>
                    <p class="text-xs font-medium text-slate-400 dark:text-slate-500 mt-1">Schedule and manage operations.</p>
                </div>
            </div>
            
            <div class="flex items-center space-x-4 relative">
                <button id="theme-toggle" class="p-2 text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition-all cursor-pointer border border-slate-100 dark:border-slate-800 active:scale-95" title="Toggle Dark/Light Mode">
                    <i id="theme-toggle-dark-icon" data-lucide="moon" class="w-4 h-4 hidden"></i>
                    <i id="theme-toggle-light-icon" data-lucide="sun" class="w-4 h-4 hidden"></i>
                </button>

                <div class="relative">
                    <button id="notificationBtn" onclick="toggleNotificationPopup(event)" class="p-2 text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition-all cursor-pointer border border-slate-100 dark:border-slate-800 active:scale-95 relative" title="Notifications">
                        <i data-lucide="bell" class="w-4 h-4"></i>
                        <span id="notificationBadge" class="absolute top-1 right-1.5 w-2 h-2 bg-rose-500 rounded-full ring-2 ring-white dark:ring-[#0f172a]"></span>
                    </button>

                    <div id="notificationPopup" class="absolute right-0 top-14 w-80 sm:w-96 bg-white dark:bg-[#0f172a] border border-slate-100 dark:border-slate-800 rounded-2xl shadow-2xl p-0 flex flex-col transition-all duration-200 ease-out transform scale-95 opacity-0 pointer-events-none z-50 hidden overflow-hidden">
                        <div class="p-4 flex justify-between items-center border-b border-slate-50 dark:border-slate-800/60 bg-white dark:bg-[#0f172a]">
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-bold text-slate-800 dark:text-white">Notifications</span>
                                <span id="notifCountBadge" class="text-[10px] font-bold text-slate-500 bg-slate-100 dark:bg-slate-800 px-2 py-0.5 rounded-full">4</span>
                            </div>
                            <button class="text-[11px] text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 flex items-center gap-1 font-medium cursor-pointer transition-colors">
                                <i data-lucide="check-check" class="w-3.5 h-3.5"></i> Mark all read
                            </button>
                        </div>
                        <div class="max-h-80 overflow-y-auto sidebar-scroll bg-slate-50/[0.15] dark:bg-slate-900/[0.02]">
                            <div class="p-4 flex items-start gap-3 border-b border-slate-50 dark:border-slate-800/40 hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-all group relative">
                                <div class="w-8 h-8 rounded-full bg-amber-50 dark:bg-amber-950/40 flex items-center justify-center flex-shrink-0 text-amber-600 dark:text-amber-400 border border-amber-100/30">
                                    <i data-lucide="wallet" class="w-4 h-4"></i>
                                </div>
                                <div class="flex-1 min-w-0 pr-3">
                                    <h4 class="text-xs font-bold text-slate-800 dark:text-white">New payment received</h4>
                                    <p class="text-[11px] text-slate-400 mt-0.5 truncate">Emma Wilson paid Sh 1,490,000 for Apt 4B...</p>
                                    <span class="text-[10px] text-slate-400 dark:text-slate-500 block mt-1">2 min ago</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-right hidden sm:block">
                    <p class="text-xs font-semibold text-slate-800 dark:text-slate-200"><?php echo Html::encode(Yii::$app->user->identity->name ?? 'User'); ?></p>
                    <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mt-0.5"><?php echo Html::encode(Yii::$app->user->identity->role ?? 'Landlord'); ?></p>
                </div>
                
                <button onclick="toggleProfilePopup(event)" id="profileBtn" class="w-9 h-9 rounded-xl relative overflow-hidden shadow-sm border border-slate-200/60 dark:border-slate-700 group cursor-pointer block focus:outline-none transition-transform active:scale-95">
                    <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Default Profile" class="w-full h-full object-cover">
                </button>
            </div>
        </header>

        <div class="p-6 max-w-7xl mx-auto w-full space-y-6">
            
            <!-- 1. HIGH FIDELITY TOP COMPLIANCE CARDS -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/60 dark:border-slate-800/60 p-5 shadow-xs relative overflow-hidden flex flex-col justify-between min-h-[100px] animate-fade-in-up">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Active Leases</span>
                        <div class="w-8 h-8 bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 rounded-xl flex items-center justify-center"><i data-lucide="check-circle" class="w-4 h-4"></i></div>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-800 dark:text-white mt-2"><?= $activeCount ?></h3>
                </div>

                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/60 dark:border-slate-800/60 p-5 shadow-xs relative overflow-hidden flex flex-col justify-between min-h-[100px] animate-fade-in-up">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Expiring (30 Days)</span>
                        <div class="w-8 h-8 bg-amber-50 dark:bg-amber-950/40 text-amber-600 rounded-xl flex items-center justify-center"><i data-lucide="alert-triangle" class="w-4 h-4"></i></div>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-800 dark:text-white mt-2"><?= $expiringCount ?></h3>
                </div>

                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/60 dark:border-slate-800/60 p-5 shadow-xs relative overflow-hidden flex flex-col justify-between min-h-[100px] animate-fade-in-up">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Archived / Closed</span>
                        <div class="w-8 h-8 bg-slate-50 dark:bg-slate-800 text-slate-600 rounded-xl flex items-center justify-center"><i data-lucide="archive" class="w-4 h-4"></i></div>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-800 dark:text-white mt-2"><?= $terminatedCount ?></h3>
                </div>
            </div>

            <!-- 2. ADVANCED WIZARD STRUCTURE SPLIT -->
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
                
                <!-- LEASE FORM CREATOR -->
                <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/60 dark:border-slate-800/60 p-6 shadow-xs animate-fade-in-up">
                    <div class="flex flex-col text-left mb-6">
                        <h3 class="text-sm font-bold text-slate-800 dark:text-white">Create Lease Agreement</h3>
                        <p class="text-[11px] text-slate-400 mt-0.5">Generate customized legal terms bound to database logic.</p>
                    </div>

                    <?= Html::beginForm(['landlord/leases'], 'post', ['enctype' => 'multipart/form-data', 'class' => 'space-y-4']) ?>
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1">Select Tenant</label>
                            <select id="tenantSelect" name="tenant_id" required onchange="fetchTenantUnit(this.value)" class="w-full bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-xs focus:outline-hidden focus:ring-2 focus:ring-indigo-500">
                                <option value="">-- Choose Tenant --</option>
                                <?php foreach ($tenants as $ten): ?>
                                    <option value="<?= $ten['id'] ?>"><?= Html::encode($ten['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-400">Select Unit</label>
                                <span id="tenantTypeBadge" class="text-[10px] px-2 font-bold rounded-sm hidden"></span>
                            </div>
                            <select id="unitSelect" name="unit_id" required class="w-full bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-xs focus:outline-hidden focus:ring-2 focus:ring-indigo-500">
                                <option value="">-- Choose Unit Room --</option>
                                <?php foreach ($units as $ut): ?>
                                    <option value="<?= $ut['id'] ?>"><?= Html::encode($ut['unit_number']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1">Start Date</label>
                                <input type="date" name="start_date" required class="w-full bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2 text-xs focus:outline-hidden">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1">End Date</label>
                                <input type="date" name="end_date" required class="w-full bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2 text-xs focus:outline-hidden">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1">Rent Value (Tsh)</label>
                                <input type="number" name="rent_amount" placeholder="e.g. 500000" required class="w-full bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-xs font-bold focus:outline-hidden">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1">Security Deposit</label>
                                <input type="number" name="security_deposit" placeholder="e.g. 100000" class="w-full bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-xs focus:outline-hidden">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1">Payment Interval Schedule</label>
                            <select name="payment_cycle" required class="w-full bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-xs focus:outline-hidden">
                                <option value="6 Months Upfront">6 Months Advance (Tanzania Standard)</option>
                                <option value="12 Months Upfront">1 Year Advance (Yearly Upfront)</option>
                                <option value="Monthly Cycle">Monthly Payments</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1">Upload Signed Contract Document (PDF/Image)</label>
                            <input type="file" name="scanned_contract" class="w-full text-xs text-slate-400 bg-slate-50 dark:bg-slate-800/60 rounded-xl border border-slate-200 dark:border-slate-700 px-3 py-2">
                        </div>

                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-xl text-xs transition-all shadow-xs cursor-pointer active:scale-95">
                            Issue Lease Protocol
                        </button>
                    <?= Html::endForm() ?>
                </div>

                <!-- LEASE INFORMATION LOGS LEDGER LISTING -->
                <div class="xl:col-span-2 bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/60 dark:border-slate-800/60 p-6 shadow-xs flex flex-col justify-between animate-fade-in-up">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6 w-full">
                        <div class="flex flex-col text-left">
                            <h3 class="text-sm font-bold text-slate-800 dark:text-white">Active Registry Matrix</h3>
                            <p class="text-[11px] text-slate-400 mt-0.5">Real-time compilation of tenancy boundaries across servers.</p>
                        </div>
                        <!-- LIVE SEARCH COMPONENT -->
                        <div class="relative min-w-[240px]">
                            <span class="absolute left-3 top-2.5 text-slate-400"><i data-lucide="search" class="w-4 h-4"></i></span>
                            <input type="text" id="tableSearch" onkeyup="filterLeaseTable()" placeholder="Search tenant or unit..." class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl pl-9 pr-4 py-2 text-xs focus:outline-hidden focus:ring-2 focus:ring-indigo-500">
                        </div>
                    </div>

                    <div class="overflow-x-auto w-full flex-1">
                        <table id="leaseLedgerTable" class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-slate-100 dark:border-slate-800 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                                    <th class="py-2.5 px-3">Tenant</th>
                                    <th class="py-2.5 px-3">Unit Room</th>
                                    <th class="py-2.5 px-3">Duration Bound</th>
                                    <th class="py-2.5 px-3">Rent rate</th>
                                    <th class="py-2.5 px-3">Document</th>
                                    <th class="py-2.5 px-3">Status</th>
                                </tr>
                            </thead>
                            <tbody class="text-xs divide-y divide-slate-100 dark:divide-slate-800/40 text-slate-600 dark:text-slate-300">
                                <?php if (empty($leasesList)): ?>
                                    <tr class="no-data-row">
                                        <td colspan="6" class="text-center py-12 text-slate-400 font-medium">No lease agreements recorded on the system database.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($leasesList as $ls): ?>
                                        <tr class="lease-row hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-all">
                                            <td class="py-3 px-3 font-bold text-slate-900 dark:text-white tenant-name-cell"><?= Html::encode($ls['tenant_name'] ?? 'Unknown Tenant') ?></td>
                                            <td class="py-3 px-3 font-semibold text-indigo-600 dark:text-indigo-400 unit-name-cell"><?= Html::encode($ls['unit_name'] ?? 'General') ?></td>
                                            <td class="py-3 px-3 text-[11px] text-slate-400"><?= $ls['start_date'] ?> to <?= $ls['end_date'] ?></td>
                                            <td class="py-3 px-3 font-bold text-slate-800 dark:text-white">Sh <?= number_format($ls['rent_amount']) ?></td>
                                            <td class="py-3 px-3">
                                                <?php if (!empty($ls['scanned_contract'])): ?>
                                                    <button type="button" 
        onclick="openViewer('<?= Url::to('@web/uploads/' . $ls['scanned_contract']) ?>', '<?= Html::encode($ls['scanned_contract']) ?>')" 
        class="text-indigo-600 dark:text-indigo-400 hover:underline flex items-center gap-1 font-bold">
    <i data-lucide="eye" class="w-3.5 h-3.5"></i> View Contract
</button>
                                                <?php else: ?>
                                                    <span class="text-slate-400 italic">No File</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="py-3 px-3">
                                                <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-emerald-50 text-emerald-600 dark:bg-emerald-950/30 dark:text-emerald-400"><?= $ls['status'] ?></span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        lucide.createIcons();
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

    // AUTOMATIC UNIT FETCH AND BADGING LOGIC
    function fetchTenantUnit(tenantId) {
        const badge = document.getElementById('tenantTypeBadge');
        const unitSelect = document.getElementById('unitSelect');
        
        if (!tenantId) {
            badge.classList.add('hidden');
            unitSelect.value = "";
            return;
        }

        fetch(`<?= Url::to(['landlord/get-tenant-unit']) ?>?tenant_id=${tenantId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success && data.unit_id) {
                    unitSelect.value = data.unit_id;
                    badge.textContent = "Existing Tenant";
                    badge.className = "text-[10px] px-2 font-bold rounded-sm bg-indigo-100 text-indigo-700 dark:bg-indigo-950 dark:text-indigo-300";
                    badge.classList.remove('hidden');
                } else {
                    unitSelect.value = "";
                    badge.textContent = "New Tenant / No Unit Assigned";
                    badge.className = "text-[10px] px-2 font-bold rounded-sm bg-amber-100 text-amber-700 dark:bg-amber-950 dark:text-amber-300";
                    badge.classList.remove('hidden');
                }
            })
            .catch(err => {
                unitSelect.value = "";
                badge.classList.add('hidden');
            });
    }

    // LIVE SEARCH INPUT FILTER FOR LEDGER MATRIX
    function filterLeaseTable() {
        const input = document.getElementById('tableSearch').value.toLowerCase();
        const rows = document.querySelectorAll('.lease-row');
        
        rows.forEach(row => {
            const tenantText = row.querySelector('.tenant-name-cell').textContent.toLowerCase();
            const unitText = row.querySelector('.unit-name-cell').textContent.toLowerCase();
            
            if (tenantText.includes(input) || unitText.includes(input)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    }
    </script>
    <script>
    function openViewer(url, title) {
        // Weka source ya iframe
        document.getElementById('viewerIframe').src = url;
        // Weka title kwenye header
        document.getElementById('viewerTitle').textContent = title;
        // Update link ya Download ili iwe ya faili husika
        document.getElementById('viewerDownloadBtn').href = url;
        
        const modal = document.getElementById('viewerModal');
        modal.classList.remove('hidden');
        
        // Refresh icons za Lucide
        lucide.createIcons(); 
    }

    function closeViewerModal() {
        const modal = document.getElementById('viewerModal');
        modal.classList.add('hidden');
        document.getElementById('viewerIframe').src = ""; 
    }
</script>
</body>
</html>