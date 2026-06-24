<?php
/** @var yii\web\View $this */
/** @var array $groupedTenants */
use yii\helpers\Url;
use yii\helpers\Html;
// Kupata route ya sasa inayotumika kwenye mfumo
$currentRoute = Yii::$app->controller->route;

// Fetch vacant or available units to populate the selection dropdown lists dynamically
$availableUnits = (new \yii\db\Query())
    ->select(['u.id', 'u.unit_number', 'p.name AS property_name'])
    ->from(['u' => 'units'])
    ->innerJoin(['p' => 'properties'], 'u.property_id = p.id')
    ->where(['p.landlord_id' => Yii::$app->user->id])
    ->all();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tenants Management | Smart Landlord</title>
    <!-- Tailwind v3 script for layouts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Lucide Icons Vector graphics framework -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- SweetAlert2 Core Script for Professional Pop-ups -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up { animation: fadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    </style>
</head>
<body class="bg-[#f8fafc] font-sans antialiased text-slate-900 flex min-h-screen relative overflow-x-hidden">

    <!-- FIXED PREMIUM SIDEBAR -->
    <aside id="sidebarNav" class="w-64 bg-white border-r border-slate-100 flex flex-col justify-between fixed top-0 left-0 h-screen z-50 transform -translate-x-full lg:translate-x-0 transition-all duration-300 ease-in-out print:hidden">
        <div class="flex flex-col h-full">
            <div class="h-16 flex items-center justify-between px-6 border-b border-slate-50">
                <span class="text-xs font-bold tracking-widest text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-violet-600 uppercase flex items-center gap-2.5">
                    <div class="w-2.5 h-2.5 bg-indigo-600 rounded-md"></div>
                    <span>Smart Landlord</span>
                </span>
                <button onclick="toggleSidebar(event)" class="lg:hidden text-slate-400 hover:text-slate-600 cursor-pointer p-1.5 rounded-xl hover:bg-slate-50 transition-all">
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

    <!-- MAIN CONTENT CONTAINER -->
    <div class="flex-1 flex flex-col min-w-0 w-full lg:pl-64">
        <!-- HEADER -->
        <header class="h-16 bg-white/80 backdrop-blur-md border-b border-slate-100 flex items-center justify-between px-8 sticky top-0 z-30">
            <div class="flex items-center gap-4">
                <button onclick="toggleSidebar(event)" id="menuBtn" class="lg:hidden text-slate-500 p-2 rounded-xl hover:bg-slate-50 transition-all border border-slate-100">
                    <i data-lucide="menu" class="w-5 h-5"></i>
                </button>
                <h1 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Tenants Cluster Portfolio</h1>
                <div class="w-full sm:w-80 relative group">
                    <input type="text" id="searchInput" onkeyup="filterTenants()" placeholder="Search by tenant name or ID..." class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:border-indigo-600 focus:bg-white transition-all shadow-2xs">
                    <div class="absolute left-3 top-2.5 text-slate-400 group-focus-within:text-indigo-600 transition-colors">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </div>
                </div>
            </div>
            
             <!-- PROFILE AREA -->
            <div class="flex items-center space-x-3.5 relative">
                <div class="text-right hidden sm:block">
                    <p class="text-xs font-bold text-slate-800 leading-none"><?php echo Html::encode(Yii::$app->user->identity->name ?? 'Jimmy John'); ?></p>
                    <p class="text-[10px] font-extrabold uppercase tracking-widest text-slate-400 mt-0.5"><?php echo Html::encode(Yii::$app->user->identity->role ?? 'LANDLORD'); ?></p>
                </div>
                
                <button onclick="toggleProfilePopup(event)" id="profileBtn" class="w-9 h-9 rounded-xl relative overflow-hidden shadow-sm border border-slate-200 group cursor-pointer block focus:outline-none transition-transform active:scale-95 ring-2 ring-slate-50">
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

        <!-- MAIN WORKSPACE -->
        <main class="p-8 max-w-7xl w-full mx-auto space-y-8 animate-fade-in-up">
            
            <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                <div>
                    <nav class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">
                        <a href="<?= Url::to(['/landlord/dashboard']) ?>" class="hover:text-indigo-600 transition">Dashboard</a> / 
                        <span class="text-slate-800">Leaseholders Overview</span>
                    </nav>
                    <h2 class="text-xl font-bold text-slate-800 tracking-tight">Leaseholders Portfolio Matrix</h2>
                </div>
                <button onclick="toggleModal('addTenantModal', true)" class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs rounded-xl transition-all shadow-md shadow-indigo-100/50">
                    <i data-lucide="user-plus" class="w-3.5 h-3.5"></i> Register New Tenant
                </button>
            </div>

            <!-- PROPERTY-GROUPED LIST MATRIX -->
            <?php if (!empty($groupedTenants)): ?>
                <?php foreach ($groupedTenants as $propertyName => $tenantsList): ?>
                    
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden mb-6">
                        <div class="px-6 py-4 border-b border-slate-50 bg-gradient-to-r from-slate-50/40 to-white flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="p-2 bg-indigo-50 text-indigo-600 rounded-xl border border-indigo-100/30">
                                    <i data-lucide="building" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider"><?= Html::encode($propertyName) ?></h3>
                                    <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wide mt-0.5">Asset Complex Compound</p>
                                </div>
                            </div>
                            <span class="text-[10px] font-bold px-2.5 py-1 bg-slate-50 text-slate-600 border border-slate-100 rounded-lg">
                                <?= count($tenantsList) ?> Occupants
                            </span>
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-slate-50/30 border-b border-slate-100 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                        <th class="px-6 py-4">Tenant Names</th>
                                        <th class="px-6 py-4">Contact Details</th>
                                        <th class="px-6 py-4">Unit Assigned</th>
                                        <th class="px-6 py-4 text-center">Settlement Status</th>
                                        <th class="px-6 py-4 text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50 text-xs text-slate-600 font-medium">
                                    <?php foreach ($tenantsList as $tenant): ?>
                                        <tr id="tenant-row-<?= $tenant['tenant_id'] ?>" class="hover:bg-slate-50/20 transition-colors duration-150">
                                            <td class="px-6 py-4">
                                                <div class="flex flex-col">
                                                    <span class="font-bold text-slate-800 text-[13px]"><?= Html::encode($tenant['tenant_name'] ?? 'N/A') ?></span>
                                                    <span class="text-[10px] font-normal text-slate-400 mt-0.5">Account ID: #<?= $tenant['tenant_id'] ?></span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-slate-600">
                                                <div class="flex flex-col space-y-1">
                                                    <div class="flex items-center gap-1.5">
                                                        <i data-lucide="phone" class="w-3.5 h-3.5 text-slate-400"></i>
                                                        <span class="font-semibold text-slate-700"><?= Html::encode($tenant['tenant_phone'] ?? 'No Contact') ?></span>
                                                    </div>
                                                    <div class="flex items-center gap-1.5 text-[11px] text-slate-400 font-normal">
                                                        <i data-lucide="mail" class="w-3 h-3"></i>
                                                        <span><?= Html::encode($tenant['tenant_email'] ?? 'N/A') ?></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="inline-flex items-center px-2.5 py-1 rounded-lg bg-slate-50 text-slate-700 font-bold text-[10px] border border-slate-200/60 uppercase tracking-wider">
                                                    <i data-lucide="home" class="w-3 h-3 text-slate-400 mr-1"></i>
                                                    Unit <?= Html::encode($tenant['unit_number'] ?? 'N/A') ?>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-100/50">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                                    Active Lease
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-center space-x-1">
                                                <button onclick="openViewDossierModal(<?= $tenant['tenant_id'] ?>)" class="p-2 border border-slate-100 rounded-xl bg-white text-indigo-600 hover:bg-indigo-50 inline-flex items-center shadow-sm transition-all" title="View Dossier">
                                                    <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                                </button>
                                                <button onclick="openEditTenantModal(<?= $tenant['tenant_id'] ?>)" class="p-2 border border-slate-100 rounded-xl bg-white text-amber-600 hover:bg-amber-50 inline-flex items-center shadow-sm transition-all" title="Modify Record">
                                                    <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                                                </button>
                                                <button onclick="triggerProfessionalDelete(<?= $tenant['tenant_id'] ?>, '<?= Html::encode($tenant['tenant_name']) ?>')" class="p-2 border border-slate-100 rounded-xl bg-white text-rose-600 hover:bg-rose-50 inline-flex items-center shadow-sm transition-all" title="Evict Account">
                                                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                <?php endforeach; ?>
            <?php else: ?>
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-16 text-center text-slate-400">
                    <div class="flex flex-col items-center justify-center space-y-3">
                        <i data-lucide="users" class="w-10 h-10 text-slate-300"></i>
                        <h4 class="text-sm font-bold text-slate-700">No Registered Leaseholders Found</h4>
                    </div>
                </div>
            <?php endif; ?>
        </main>
    </div>

    <!-- MODAL 1: VIEW TENANT DOSSIER -->
    <div id="viewDossierModal" class="fixed inset-0 bg-slate-950/40 backdrop-blur-sm flex items-center justify-center p-4 z-50 opacity-0 pointer-events-none transition-all duration-300 hidden">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-2xl max-w-md w-full overflow-hidden transform scale-95 transition-all duration-300">
            <div class="px-6 py-4 border-b border-slate-50 bg-slate-50/50 flex items-center justify-between">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Tenant Official Dossier</span>
                <button onclick="toggleModal('viewDossierModal', false)" class="text-slate-400 hover:text-slate-600 p-1 rounded-xl hover:bg-slate-50"><i data-lucide="x" class="w-4 h-4"></i></button>
            </div>
            <div class="p-6 space-y-6 text-xs font-medium">
                <div class="flex items-center space-x-4">
                    <div class="w-14 h-14 bg-indigo-50 border border-indigo-100 rounded-2xl flex items-center justify-center text-indigo-600">
                        <i data-lucide="user" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 id="view_name" class="text-sm font-bold text-slate-800">---</h3>
                        <p id="view_role" class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mt-0.5">Verified Tenant</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 bg-slate-50/60 p-4 rounded-xl border border-slate-100">
                    <div>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Property Complex</p>
                        <p id="view_property" class="text-slate-700 font-semibold mt-1">---</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Room / Unit ID</p>
                        <p id="view_unit" class="text-indigo-600 font-bold mt-1">---</p>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="flex justify-between py-2 border-b border-slate-50">
                        <span class="text-slate-400">Mobile Phone:</span>
                        <span id="view_phone" class="text-slate-800 font-semibold">---</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-slate-50">
                        <span class="text-slate-400">Email Address:</span>
                        <span id="view_email" class="text-slate-800 font-semibold">---</span>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="text-slate-400">Lease Status:</span>
                        <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 rounded-md font-bold text-[10px]">ACTIVE CONTEXT</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL 2: EDIT TENANT DOSSIER FRAME -->
    <div id="editTenantModal" class="fixed inset-0 bg-slate-950/40 backdrop-blur-sm flex items-center justify-center p-4 z-50 opacity-0 pointer-events-none transition-all duration-300 hidden">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-2xl max-w-md w-full overflow-hidden transform scale-95 transition-all duration-300">
            <div class="px-6 py-4 border-b border-slate-50 bg-gradient-to-r from-slate-50/50 to-white flex items-center justify-between">
                <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Modify Leaseholder Profile</h3>
                <button onclick="toggleModal('editTenantModal', false)" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-xl hover:bg-slate-50"><i data-lucide="x" class="w-4 h-4"></i></button>
            </div>
            
            <form id="editTenantForm" method="POST" class="p-6 space-y-4 text-xs font-medium text-slate-700">
                <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>
                
                <div class="space-y-1.5">
                    <label class="block font-semibold text-slate-600">Full Legal Name</label>
                    <input type="text" id="edit_name" name="name" required class="w-full bg-slate-50 border border-slate-200 px-3 py-2.5 rounded-xl text-slate-800 focus:outline-none focus:bg-white focus:border-indigo-500 transition-all">
                </div>
                <div class="space-y-1.5">
                    <label class="block font-semibold text-slate-600">Mobile Phone Number</label>
                    <input type="text" id="edit_phone" name="phone" required class="w-full bg-slate-50 border border-slate-200 px-3 py-2.5 rounded-xl text-slate-800 focus:outline-none focus:bg-white focus:border-indigo-500 transition-all">
                </div>
                <div class="space-y-1.5">
                    <label class="block font-semibold text-slate-600">Email Address</label>
                    <input type="email" id="edit_email" name="email" required class="w-full bg-slate-50 border border-slate-200 px-3 py-2.5 rounded-xl text-slate-800 focus:outline-none focus:bg-white focus:border-indigo-500 transition-all">
                </div>
                <div class="space-y-1.5">
                    <label class="block font-semibold text-slate-600">Reassign Complex Unit</label>
                    <select id="edit_unit_id" name="unit_id" required class="w-full bg-slate-50 border border-slate-200 px-3 py-2.5 rounded-xl text-slate-800 focus:outline-none focus:bg-white focus:border-indigo-500 transition-all cursor-pointer">
                        <?php foreach ($availableUnits as $unit): ?>
                            <option value="<?= $unit['id'] ?>">Unit <?= Html::encode($unit['unit_number']) ?> (<?= Html::encode($unit['property_name']) ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="flex justify-end space-x-3 pt-4 border-t border-slate-50">
                    <button type="button" onclick="toggleModal('editTenantModal', false)" class="px-4 py-2.5 border border-slate-200 bg-white text-slate-600 font-semibold rounded-xl">Cancel</button>
                    <button type="submit" class="px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl shadow-md">Save Adjustments</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MAIN INTERACTION ACTIONS SCRIPTS -->
    <script>
        lucide.createIcons();

        function toggleSidebar(event) {
            if (event) event.stopPropagation();
            document.getElementById('sidebarNav').classList.toggle('-translate-x-full');
        }

        function toggleModal(modalId, show) {
            const modal = document.getElementById(modalId);
            const content = modal.querySelector('div');
            if (show) {
                modal.classList.remove('hidden');
                requestAnimationFrame(() => {
                    modal.classList.remove('opacity-0', 'pointer-events-none');
                    content.classList.remove('scale-95');
                    content.classList.add('scale-100');
                });
            } else {
                modal.classList.add('opacity-0', 'pointer-events-none');
                content.classList.remove('scale-100');
                content.classList.add('scale-95');
                setTimeout(() => modal.classList.add('hidden'), 300);
            }
        }

        // FETCH DATA FOR DOSSIER OVERVIEW (VIEW BUTTON)
        function openViewDossierModal(tenantId) {
            fetch(`<?= Url::to(['/landlord/get-tenant-details']) ?>?id=${tenantId}`)
                .then(response => response.json())
                .then(res => {
                    if(res.success) {
                        document.getElementById('view_name').innerText = res.data.name || 'N/A';
                        document.getElementById('view_property').innerText = res.data.property_name || 'Unassigned Asset';
                        document.getElementById('view_unit').innerText = 'Unit ' + (res.data.unit_number || 'N/A');
                        document.getElementById('view_phone').innerText = res.data.phone || 'No Phone';
                        document.getElementById('view_email').innerText = res.data.email || 'No Email';
                        toggleModal('viewDossierModal', true);
                    } else {
                        Swal.fire({ icon: 'error', title: 'Data Query Failed', text: res.message, confirmButtonColor: '#4f46e5' });
                    }
                });
        }

        // FETCH DATA FOR PROFILE EDIT FORM (EDIT BUTTON)
        function openEditTenantModal(tenantId) {
            fetch(`<?= Url::to(['/landlord/get-tenant-details']) ?>?id=${tenantId}`)
                .then(response => response.json())
                .then(res => {
                    if(res.success) {
                        document.getElementById('edit_name').value = res.data.name || '';
                        document.getElementById('edit_phone').value = res.data.phone || '';
                        document.getElementById('edit_email').value = res.data.email || '';
                        document.getElementById('edit_unit_id').value = res.data.unit_id || '';
                        // Set active form submission routing action
                        document.getElementById('editTenantForm').action = `<?= Url::to(['/landlord/update-tenant']) ?>?id=${tenantId}`;
                        toggleModal('editTenantModal', true);
                    } else {
                        Swal.fire({ icon: 'error', title: 'Data Query Failed', text: res.message, confirmButtonColor: '#4f46e5' });
                    }
                });
        }

        // SWEETALERT2: PROFESSIONAL EVICTION PURGE METHOD (DELETE BUTTON)
        function triggerProfessionalDelete(tenantId, tenantName) {
            Swal.fire({
                title: 'Are you sure?',
                text: `You are about to completely evict ${tenantName} and purge their lease registry record from the platform database core grid.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48', // Premium Rose 600
                cancelButtonColor: '#64748b',  // Slate 500
                confirmButtonText: 'Yes, Evict Tenant',
                cancelButtonText: 'Cancel',
                background: '#ffffff',
                customClass: {
                    popup: 'rounded-2xl border border-slate-100 shadow-2xl font-sans',
                    title: 'text-sm font-bold text-slate-800 uppercase tracking-wide',
                    htmlContainer: 'text-xs text-slate-500 font-medium'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Execute silent Fetch requests deletion routine
                    fetch(`<?= Url::to(['/landlord/delete-tenant']) ?>?id=${tenantId}`)
                        .then(response => response.json())
                        .then(res => {
                            if (res.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Eviction Executed',
                                    text: res.message,
                                    confirmButtonColor: '#4f46e5'
                                });
                                // Premium DOM slideOut animation effect removal row
                                const row = document.getElementById(`tenant-row-${tenantId}`);
                                if(row) {
                                    row.style.transition = 'all 0.5s ease';
                                    row.style.opacity = '0';
                                    row.style.transform = 'translateX(50px)';
                                    setTimeout(() => row.remove(), 500);
                                }
                            } else {
                                Swal.fire({ icon: 'error', title: 'Purge Aborted', text: res.message });
                            }
                        });
                }
            });
        }
    </script>
    
    <div id="addTenantModal" class="fixed inset-0 bg-slate-950/40 backdrop-blur-sm flex items-center justify-center p-4 z-50 opacity-0 pointer-events-none transition-all duration-300 hidden">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-2xl max-w-md w-full overflow-hidden transform scale-95 transition-all duration-300">
            <div class="px-6 py-4 border-b border-slate-50 bg-gradient-to-r from-slate-50/50 to-white flex items-center justify-between">
                <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Register New Tenant</h3>
                <button onclick="toggleModal('addTenantModal', false)" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-xl hover:bg-slate-50"><i data-lucide="x" class="w-4 h-4"></i></button>
            </div>
            
            <form action="<?= Url::to(['/landlord/create-tenant']) ?>" method="POST" class="p-6 space-y-4 text-xs font-medium text-slate-700">
                <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>
                
                <div class="space-y-1.5">
                    <label class="block font-semibold text-slate-600">Full Legal Name</label>
                    <input type="text" name="name" required placeholder="Mfano: Juma Kiboko" class="w-full bg-slate-50 border border-slate-200 px-3 py-2.5 rounded-xl text-slate-800 focus:outline-none focus:bg-white focus:border-indigo-500 transition-all">
                </div>
                <div class="space-y-1.5">
                    <label class="block font-semibold text-slate-600">Mobile Phone Number</label>
                    <input type="text" name="phone" required placeholder="Mfano: 0712345678" class="w-full bg-slate-50 border border-slate-200 px-3 py-2.5 rounded-xl text-slate-800 focus:outline-none focus:bg-white focus:border-indigo-500 transition-all">
                </div>
                <div class="space-y-1.5">
                    <label class="block font-semibold text-slate-600">Email Address</label>
                    <input type="email" name="email" required placeholder="Mfano: juma@gmail.com" class="w-full bg-slate-50 border border-slate-200 px-3 py-2.5 rounded-xl text-slate-800 focus:outline-none focus:bg-white focus:border-indigo-500 transition-all">
                </div>
                <div class="space-y-1.5">
                    <label class="block font-semibold text-slate-600">Assign Complex Unit (Chumba)</label>
                    <select name="unit_id" required class="w-full bg-slate-50 border border-slate-200 px-3 py-2.5 rounded-xl text-slate-800 focus:outline-none focus:bg-white focus:border-indigo-500 transition-all cursor-pointer">
                        <option value="" disabled selected>Chagua chumba kilicho wazi...</option>
                        <?php foreach ($availableUnits as $unit): ?>
                            <option value="<?= $unit['id'] ?>">Unit <?= Html::encode($unit['unit_number']) ?> - (<?= Html::encode($unit['property_name']) ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="bg-indigo-50/50 p-3 rounded-xl border border-indigo-100/40 text-[11px] text-indigo-700 flex gap-2">
                    <i data-lucide="info" class="w-4 h-4 shrink-0 mt-0.5"></i>
                    <span>First-time login password: **tenant123**</span>
                </div>
                <div class="flex justify-end space-x-3 pt-4 border-t border-slate-50">
                    <button type="button" onclick="toggleModal('addTenantModal', false)" class="px-4 py-2.5 border border-slate-200 bg-white text-slate-600 font-semibold rounded-xl">Cancel</button>
                    <button type="submit" class="px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl shadow-md">Register Tenant</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>