<?php
/** @var yii\web\View $this */
use yii\helpers\Url;
use yii\helpers\Html;
$currentRoute = Yii::$app->controller->route;
?>
<!DOCTYPE html>
<html lang="en" class="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Landlord - Maintenance Control Board</title>
    
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
    
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up { animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        html.dark ::-webkit-scrollbar-thumb { background: #334155; }
        .sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
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

    <!-- SIDEBAR NAVIGATION (CALENDAR STRUCTURE) -->
    <aside id="sidebarNav" class="w-64 bg-white dark:bg-[#0f172a] border-r border-slate-100 dark:border-slate-800/60 flex flex-col justify-between fixed top-0 left-0 h-screen z-50 shadow-2xl lg:shadow-none transform -translate-x-full lg:translate-x-0 transition-all duration-300 ease-in-out">
        <div class="flex flex-col h-full">
            <div class="h-16 flex items-center justify-between px-6 border-b border-slate-50 dark:border-slate-800/40">
                <span class="text-xs font-bold tracking-widest text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-violet-600 dark:from-indigo-400 dark:to-violet-400 uppercase flex items-center gap-2.5">
                    <div class="w-2.5 h-2.5 bg-indigo-600 dark:bg-indigo-400 rounded-md animate-bounce"></div>
                    <span>Smart Landlord</span>
                </span>
                <button onclick="toggleSidebar(event)" class="lg:hidden text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 cursor-pointer p-1.5 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 transition-all">
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

    <div class="flex-1 flex flex-col min-w-0 w-full lg:pl-64">
        
        <!-- HEADER -->
        <header class="h-16 bg-white/80 dark:bg-[#0f172a]/80 backdrop-blur-md border-b border-slate-100 dark:border-slate-800/60 flex items-center justify-between px-8 sticky top-0 z-30">
            <div class="flex items-center gap-4">
                <button onclick="toggleSidebar(event)" class="lg:hidden text-slate-500 dark:text-slate-400 p-2 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 border">
                    <i data-lucide="menu" class="w-5 h-5"></i>
                </button>
                <div class="flex flex-col text-left ml-3">
                    <h1 class="text-lg font-bold text-slate-900 dark:text-white leading-tight tracking-tight">Maintenance Control Board</h1>
                    <p class="text-xs font-medium text-slate-400 dark:text-slate-500 mt-1">Manage infrastructure, dispatches, and emergency repairs.</p>
                </div>
            </div>
            
            <div class="flex items-center space-x-4">
                <button id="theme-toggle" class="p-2 text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl border">
                    <i id="theme-toggle-dark-icon" data-lucide="moon" class="w-4 h-4 hidden"></i>
                    <i id="theme-toggle-light-icon" data-lucide="sun" class="w-4 h-4 hidden"></i>
                </button>

                <div class="text-right hidden sm:block">
                    <p class="text-xs font-semibold text-slate-800 dark:text-slate-200"><?= Html::encode(Yii::$app->user->identity->name ?? 'User'); ?></p>
                    <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mt-0.5">Landlord Mode</p>
                </div>
                <button onclick="toggleProfilePopup(event)" id="profileBtn" class="w-9 h-9 rounded-xl relative overflow-hidden shadow-sm border border-slate-200/60 dark:border-slate-700 group cursor-pointer block focus:outline-none transition-transform active:scale-95">
                    <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Default Profile" class="w-full h-full object-cover">
                </button>
            </div>
        </header>

        <div class="p-6 max-w-7xl mx-auto w-full space-y-6">
            
            <!-- REAL CARDS INJECTED WITH DYNAMIC DATABASE COUNT -->
            <div class="grid grid-cols-1 sm:grid-cols-4 gap-5">
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/60 dark:border-slate-800/60 p-5 shadow-xs flex flex-col justify-between min-h-[100px] animate-fade-in-up">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">New Issues</span>
                        <div class="w-8 h-8 bg-rose-50 dark:bg-rose-950/40 text-rose-600 rounded-xl flex items-center justify-center"><i data-lucide="alert-circle" class="w-4 h-4"></i></div>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-800 dark:text-white mt-2"><?= count($newTasks) ?></h3>
                </div>

                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/60 dark:border-slate-800/60 p-5 shadow-xs flex flex-col justify-between min-h-[100px] animate-fade-in-up">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">In Progress</span>
                        <div class="w-8 h-8 bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 rounded-xl flex items-center justify-center"><i data-lucide="hammer" class="w-4 h-4"></i></div>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-800 dark:text-white mt-2"><?= count($progressTasks) ?></h3>
                </div>

                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/60 dark:border-slate-800/60 p-5 shadow-xs flex flex-col justify-between min-h-[100px] animate-fade-in-up">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Resolved</span>
                        <div class="w-8 h-8 bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 rounded-xl flex items-center justify-center"><i data-lucide="check-circle" class="w-4 h-4"></i></div>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-800 dark:text-white mt-2"><?= count($resolvedTasks) ?></h3>
                </div>

                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/60 dark:border-slate-800/60 p-5 shadow-xs flex flex-col justify-between min-h-[100px] animate-fade-in-up">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Expenses</span>
                        <div class="w-8 h-8 bg-amber-50 dark:bg-amber-950/40 text-amber-600 rounded-xl flex items-center justify-center"><i data-lucide="wallet" class="w-4 h-4"></i></div>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 dark:text-white mt-2">Sh <?= number_format($totalExpenses) ?></h3>
                </div>
            </div>

            <!-- SEARCH CONTROL BAR -->
            <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/60 dark:border-slate-800/60 p-4 flex flex-col sm:flex-row gap-4 items-center justify-between animate-fade-in-up">
                <div class="relative w-full sm:max-w-xs">
                    <span class="absolute left-3 top-2.5 text-slate-400"><i data-lucide="search" class="w-4 h-4"></i></span>
                    <input type="text" id="taskSearch" onkeyup="searchTasks()" placeholder="Search room or maintenance issue..." class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl pl-9 pr-4 py-2 text-xs focus:outline-hidden focus:ring-2 focus:ring-indigo-500">
                </div>
                <button onclick="openCreateModal()" class="bg-indigo-600 text-white text-xs font-bold px-4 py-2 rounded-xl flex items-center gap-1.5 hover:bg-indigo-700 transition-all cursor-pointer w-full sm:w-auto justify-center">
                    <i data-lucide="plus-circle" class="w-4 h-4"></i> Log New Task
                </button>
            </div>

            <!-- REAL KANBAN BOARD EXECUTION IN LOOPS -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- COLUMN 1: TO-DO / NEW REQUESTS -->
                <div class="bg-slate-100/70 dark:bg-slate-900/40 rounded-2xl p-4 border border-slate-200/40 dark:border-slate-800/40 space-y-4">
                    <div class="flex items-center justify-between px-2">
                        <span class="text-xs font-bold uppercase tracking-wider text-rose-600 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-rose-600"></span> To-Do / New
                        </span>
                        <span class="text-xs bg-rose-100 text-rose-700 dark:bg-rose-950/40 dark:text-rose-400 px-2 py-0.5 rounded-md font-bold"><?= count($newTasks) ?></span>
                    </div>
                    
                    <div class="space-y-3 column-tasks-container" id="todoColumn">
                        <?php if (empty($newTasks)): ?>
                            <p class="text-center py-6 text-xs text-slate-400">No new tickets logged.</p>
                        <?php else: ?>
                            <?php foreach ($newTasks as $task): ?>
                                <div class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200/60 dark:border-slate-800/60 shadow-xs hover:border-rose-500/40 transition-all task-card relative" data-search-key="room <?= strtolower($task['unit_number']) ?> <?= strtolower($task['category']) ?> <?= strtolower($task['description']) ?>">
                                    <span class="absolute top-3 right-3 text-[9px] font-bold uppercase px-1.5 py-0.5 rounded-sm bg-rose-50 text-rose-600 dark:bg-rose-950/40 dark:text-rose-400"><?= $task['priority'] ?></span>
                                    <h4 class="text-xs font-bold text-slate-800 dark:text-white">Room <?= Html::encode($task['unit_number']) ?> - <?= Html::encode($task['category']) ?></h4>
                                    <p class="text-[11px] text-slate-400 mt-1"><?= Html::encode($task['description']) ?></p>
                                    
                                    <div class="mt-4 pt-3 border-t border-slate-50 dark:border-slate-800/60 flex items-center justify-between">
                                        <div class="flex flex-col">
                                            <span class="text-[10px] text-slate-400">Estimate Quote:</span>
                                            <span class="text-[11px] font-bold text-slate-700 dark:text-slate-300">Sh <?= number_format($task['estimated_cost']) ?></span>
                                        </div>
                                        <span class="text-[10px] font-bold text-rose-500 italic">Pending Dispatch</span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- COLUMN 2: UNDER REPAIR -->
                <div class="bg-slate-100/70 dark:bg-slate-900/40 rounded-2xl p-4 border border-slate-200/40 dark:border-slate-800/40 space-y-4">
                    <div class="flex items-center justify-between px-2">
                        <span class="text-xs font-bold uppercase tracking-wider text-indigo-600 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-indigo-600"></span> Under Repair
                        </span>
                        <span class="text-xs bg-indigo-100 text-indigo-700 dark:bg-indigo-950/40 dark:text-indigo-400 px-2 py-0.5 rounded-md font-bold"><?= count($progressTasks) ?></span>
                    </div>

                    <div class="space-y-3 column-tasks-container" id="progressColumn">
                        <?php if (empty($progressTasks)): ?>
                            <p class="text-center py-6 text-xs text-slate-400">No active maintenance tasks.</p>
                        <?php else: ?>
                            <?php foreach ($progressTasks as $task): ?>
                                <div class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200/60 dark:border-slate-800/60 shadow-xs hover:border-indigo-500/40 transition-all task-card relative" data-search-key="room <?= strtolower($task['unit_number']) ?> <?= strtolower($task['category']) ?> <?= strtolower($task['description']) ?>">
                                    <span class="absolute top-3 right-3 text-[9px] font-bold uppercase px-1.5 py-0.5 rounded-sm bg-indigo-50 text-indigo-600 dark:bg-indigo-950/40 dark:text-indigo-400"><?= $task['priority'] ?></span>
                                    <h4 class="text-xs font-bold text-slate-800 dark:text-white">Room <?= Html::encode($task['unit_number']) ?> - <?= Html::encode($task['category']) ?></h4>
                                    <p class="text-[11px] text-slate-400 mt-1"><?= Html::encode($task['description']) ?></p>
                                    
                                    <div class="mt-4 pt-3 border-t border-slate-50 dark:border-slate-800/60 flex items-center justify-between">
                                        <div class="flex flex-col">
                                            <span class="text-[10px] text-slate-400">Dispatched Expert:</span>
                                            <span class="text-[11px] font-bold text-slate-700 dark:text-slate-300"><?= Html::encode($task['technician_name'] ?? 'General Vendor') ?></span>
                                        </div>
                                        <span class="text-[11px] font-bold text-indigo-600">Sh <?= number_format($task['estimated_cost']) ?></span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- COLUMN 3: VERIFIED / RESOLVED -->
                <div class="bg-slate-100/70 dark:bg-slate-900/40 rounded-2xl p-4 border border-slate-200/40 dark:border-slate-800/40 space-y-4">
                    <div class="flex items-center justify-between px-2">
                        <span class="text-xs font-bold uppercase tracking-wider text-emerald-600 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-600"></span> Verified / Resolved
                        </span>
                        <span class="text-xs bg-emerald-100 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-400 px-2 py-0.5 rounded-md font-bold"><?= count($resolvedTasks) ?></span>
                    </div>

                    <div class="space-y-3 column-tasks-container" id="resolvedColumn">
                        <?php if (empty($resolvedTasks)): ?>
                            <p class="text-center py-6 text-xs text-slate-400">No completed tasks archive.</p>
                        <?php else: ?>
                            <?php foreach ($resolvedTasks as $task): ?>
                                <div class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200/60 dark:border-slate-800/60 shadow-xs opacity-85 task-card" data-search-key="room <?= strtolower($task['unit_number']) ?> <?= strtolower($task['category']) ?> <?= strtolower($task['description']) ?>">
                                    <div class="flex items-center justify-between">
                                        <h4 class="text-xs font-bold text-slate-800 dark:text-white">Room <?= Html::encode($task['unit_number']) ?> - <?= Html::encode($task['category']) ?></h4>
                                        <span class="text-[9px] font-bold uppercase px-1.5 py-0.5 rounded-sm bg-emerald-50 text-emerald-600 dark:bg-emerald-950/40 dark:text-emerald-400">Fixed</span>
                                    </div>
                                    <p class="text-[11px] text-slate-400 mt-1"><?= Html::encode($task['description']) ?></p>
                                    
                                    <div class="mt-4 pt-3 border-t border-slate-50 dark:border-slate-800/60 flex items-center justify-between">
                                        <div class="flex flex-col">
                                            <span class="text-[10px] text-slate-400">Handled By:</span>
                                            <span class="text-[11px] font-bold text-slate-500"><?= Html::encode($task['technician_name'] ?? 'External Fundi') ?></span>
                                        </div>
                                        <span class="text-[11px] font-bold text-emerald-600">Paid Sh <?= number_format($task['estimated_cost']) ?></span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- POPUP MODAL (FORM WINDOW WITH REAL Pointers) -->
    <div id="createTaskModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 hidden opacity-0 transition-opacity duration-300">
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-6 w-full max-w-md shadow-2xl transform scale-95 transition-transform duration-300">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-slate-900 dark:text-white">Log New Infrastructure Issue</h3>
                <button onclick="closeCreateModal()" class="text-slate-400 hover:text-slate-600 cursor-pointer"><i data-lucide="x" class="w-4 h-4"></i></button>
            </div>
            
            <?= Html::beginForm(['landlord/create-maintenance-task'], 'post', ['class' => 'space-y-4']) ?>
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1">Select Target Room</label>
                    <select name="unit_id" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-3 py-2 text-xs focus:outline-hidden">
                        <option value="">-- Choose Unit Room --</option>
                        <?php foreach ($units as $ut): ?>
                            <option value="<?= $ut['id'] ?>">Room <?= Html::encode($ut['unit_number']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1">Category</label>
                        <select name="category" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-3 py-2 text-xs focus:outline-hidden">
                            <option value="Plumbing">Plumbing (Mabomba)</option>
                            <option value="Electrical">Electrical (Umeme)</option>
                            <option value="Painting">Painting (Rangi)</option>
                            <option value="Structural">Structural (Majengo)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1">Priority</label>
                        <select name="priority" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-3 py-2 text-xs focus:outline-hidden">
                            <option value="Low">Low</option>
                            <option value="Medium">Medium</option>
                            <option value="High">High</option>
                            <option value="Emergency">Emergency</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1">Problem Description</label>
                    <textarea name="description" rows="3" required placeholder="Explain the problem in detail..." class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-3 py-2 text-xs focus:outline-hidden"></textarea>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1">Quote Estimate (Tsh)</label>
                        <input type="number" name="estimated_cost" placeholder="e.g. 35000" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-3 py-2 text-xs focus:outline-hidden">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1">Assign Expert Fundi</label>
                        <input type="text" name="technician_name" placeholder="Technician Name" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-3 py-2 text-xs focus:outline-hidden">
                    </div>
                </div>

                <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-2.5 rounded-xl text-xs hover:bg-indigo-700 transition-all cursor-pointer">
                    Dispatch Protocol Card
                </button>
            <?= Html::endForm() ?>
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

    // LIVE RUNNING KEY FILTER
    function searchTasks() {
        const query = document.getElementById('taskSearch').value.toLowerCase();
        const cards = document.querySelectorAll('.task-card');
        
        cards.forEach(card => {
            const searchKey = card.getAttribute('data-search-key');
            if (searchKey && searchKey.includes(query)) {
                card.style.display = "block";
            } else {
                card.style.display = "none";
            }
        });
    }

    // POPUP WINDOW CONTROL ENGINE
    function openCreateModal() {
        const modal = document.getElementById('createTaskModal');
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modal.querySelector('div').classList.remove('scale-95');
        }, 10);
    }

    // POPUP CLOSING ENGINE
    function closeCreateModal() {
        const modal = document.getElementById('createTaskModal');
        modal.classList.add('opacity-0');
        modal.querySelector('div').classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }
    </script>
    
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
</body>
</html>