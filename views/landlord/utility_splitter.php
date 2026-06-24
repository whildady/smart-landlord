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
    <title>Utility Splitter Panel | Smart Landlord</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
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
                <h1 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Utility Splitter</h1>
                <div class="w-full sm:w-80 relative group">
                    <input type="text" id="searchInput" onkeyup="filterProperties()" placeholder="Search by property name or ID..." class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:border-indigo-600 focus:bg-white transition-all shadow-2xs">
                    <div class="absolute left-3 top-2.5 text-slate-400 group-focus-within:text-indigo-600 transition-colors">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </div>
                </div>
            </div>
            
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

        <main class="p-8 max-w-7xl w-full mx-auto space-y-8 animate-fade-in-up">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
               <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:border-emerald-200 group">
                    <div class="flex items-center justify-between">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Unsplit Master Bills</p>
                        <h3 class="text-xl font-bold text-slate-800 mt-1">
                            <?php echo $unsplit_count; ?> Pending
                        </h3>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600">
                        <i data-lucide="alert-circle" class="w-5 h-5"></i>
                    </div>
                </div>
                
                <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:border-emerald-200 group">
                    <div class="flex items-center justify-between">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Awaiting Tenant Action</p>
                        <h3 class="text-xl font-bold text-slate-800 mt-1">
                            TZS <?php echo number_format($awaiting_action, 2); ?>
                        </h3>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                        <i data-lucide="clock" class="w-5 h-5"></i>
                    </div>
                </div>

                <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:border-emerald-200 group">
                    <div class="flex items-center justify-between">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Distributed (Month)</p>
                        <h3 class="text-xl font-bold text-emerald-600 mt-1">
                            TZS <?php echo number_format($total_month, 2); ?>
                        </h3>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                        <i data-lucide="check-check" class="w-5 h-5"></i>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm h-fit">
                    <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-5 flex items-center gap-2 border-b border-slate-50 pb-3">
                        <i data-lucide="calculator" class="w-4 h-4 text-indigo-600"></i>
                        <span>Register & Split Bill</span>
                    </h3> 

                    <form id="splitBillForm" action="<?= Url::to(['/landlord/process-utility-split']) ?>" method="POST" enctype="multipart/form-data" class="space-y-4">
                        <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Select Property</label>
                            <select name="property_id" required class="w-full px-3 py-2.5 bg-slate-50 border border-slate-100 rounded-xl text-xs font-medium focus:outline-none focus:border-indigo-600 focus:bg-white transition-all cursor-pointer">
                                <?php if(!empty($properties)) : ?>
                                    <?php foreach($properties as $property) : ?>
                                        <option value="<?php echo $property->id; ?>"><?php echo htmlspecialchars($property->name); ?></option>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <option value="">No properties found</option>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Utility Type</label>
                            <select name="bill_type" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-100 rounded-xl text-xs font-medium focus:outline-none focus:border-indigo-600 focus:bg-white transition-all cursor-pointer">
                                <option value="electricity">⚡ LUKU (Electricity)</option>
                                <option value="water">💧 DAWASA (Water)</option>
                                <option value="waste">🗑️ Waste & Sanitation</option>
                                <option value="security">🛡️ Gate Security </option>
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Total Paid (TZS)</label>
                                <input type="number" name="total_amount" placeholder="e.g., 50000" required class="w-full px-3 py-2.5 bg-slate-50 border border-slate-100 rounded-xl text-xs font-medium focus:outline-none focus:border-indigo-600 focus:bg-white transition-all">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Net Token Units</label>
                                <input type="number" step="0.01" name="net_amount" placeholder="e.g., 140.5" required class="w-full px-3 py-2.5 bg-slate-50 border border-slate-100 rounded-xl text-xs font-medium focus:outline-none focus:border-indigo-600 focus:bg-white transition-all">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">LUKU Token Number (Optional)</label>
                            <input type="text" name="token_number" placeholder="xxxx-xxxx-xxxx-xxxx-xxxx" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-100 rounded-xl text-xs font-medium focus:outline-none focus:border-indigo-600 focus:bg-white tracking-widest transition-all">
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Billing Month</label>
                            <input type="text" name="billing_period" value="<?php echo date('F Y'); ?>" required class="w-full px-3 py-2.5 bg-slate-50 border border-slate-100 rounded-xl text-xs font-medium focus:outline-none focus:border-indigo-600 focus:bg-white transition-all">
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Split Strategy</label>
                            <select name="split_method" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-100 rounded-xl text-xs font-medium focus:outline-none focus:border-indigo-600 focus:bg-white transition-all cursor-pointer">
                                <option value="equal">Equal Share Per Unit </option>
                                <option value="submeter">By Sub-meter Reading </option>
                                <option value="per_head">Per Head </option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Vacant Room Handling</label>
                            <select name="vacant_handling" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-100 rounded-xl text-xs font-medium focus:outline-none focus:border-indigo-600 focus:bg-white transition-all cursor-pointer">
                                <option value="landlord_absorb">Landlord Absorbs Cost (Recommended)</option>
                                <option value="tenant_share">Split Among Occupied Units</option>
                            </select>
                        </div>

                        <div>
    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Upload Bill Receipt / Screenshot</label>
    <label class="w-full flex flex-col items-center justify-center px-4 py-4 bg-slate-50 border-2 border-dashed border-slate-200 rounded-xl hover:bg-slate-100/50 cursor-pointer text-center transition-all group relative min-h-[100px]">
        
        <div class="flex flex-col items-center justify-center upload-content group-hover:opacity-80 transition-all">
            <i data-lucide="paperclip" class="w-4 h-4 text-slate-400 group-hover:text-slate-600 mb-1"></i>
            <span class="text-[11px] font-semibold text-slate-500 group-hover:text-slate-700">Attach Reference Image</span>
        </div>

        <img src="#" alt="Preview" class="hidden max-h-24 w-auto object-contain rounded-lg shadow-xs my-1 border border-slate-100">

        <input type="file" name="bill_receipt" accept="image/*" class="hidden" 
               onchange="previewImage(this)">
    </label>
</div>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        const container = input.parentElement;
        const uploadContent = container.querySelector('.upload-content');
        const previewImg = container.querySelector('img');

        reader.onload = function(e) {
            // Weka picha kwenye src ya tag ya img
            previewImg.src = e.target.result;
            // Onyesha picha
            previewImg.classList.remove('hidden');
            // Ficha maandishi na icon ya kawaida ili picha ichukue nafasi
            uploadContent.classList.add('hidden');
        }

        reader.readAsDataURL(input.files[0]);
    }
}
</script>

                        <button type="submit" id="submitBtn" class="w-full bg-indigo-600 text-white p-3 rounded-xl font-bold flex items-center justify-center gap-2 hover:bg-indigo-700 transition">
                            <span id="btnText">Split & Register Bill</span>
                            <svg id="btnSpinner" class="animate-spin h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </button>
                    </form>
                </div>

                <div class="lg:col-span-2 space-y-4">
                    <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest flex items-center gap-2">
                        <i data-lucide="history" class="w-3.5 h-3.5"></i>
                        <span>Master Bill Split History</span>
                    </h2>
                    
                    <?php if(empty($bills)) : ?>
                        <div class="border border-dashed border-slate-200 rounded-2xl p-12 text-center bg-white shadow-sm">
                            <i data-lucide="layers-3" class="w-8 h-8 text-slate-300 mx-auto mb-2"></i>
                            <p class="font-medium text-xs text-slate-500">No utility bill records registered yet.</p>
                        </div>
                    <?php else : ?>
                        <div class="bg-white border border-slate-100 rounded-2xl overflow-hidden shadow-sm">
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr class="bg-slate-50 border-b border-slate-100 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                                            <th class="py-3.5 px-6">Period / Service</th>
                                            <th class="py-3.5 px-6">Property</th>
                                            <th class="py-3.5 px-6">Total Paid</th>
                                            <th class="py-3.5 px-6">Net Units</th>
                                            <th class="py-3.5 px-6 text-right">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-50 text-xs font-medium text-slate-700">
                                        <?php foreach($bills as $bill) : ?>
                                            <tr class="hover:bg-slate-50/50 transition-all">
                                                <td class="py-4 px-6">
                                                    <div class="font-bold text-slate-800"><?php echo htmlspecialchars($bill->billing_period); ?></div>
                                                    <div class="text-[10px] text-indigo-600 font-semibold capitalize tracking-wide flex items-center gap-1 mt-0.5">
                                                        <span>
                                                            <?php 
                                                                if ($bill->bill_type === 'electricity') echo '⚡ Electricity';
                                                                elseif ($bill->bill_type === 'water') echo '💧 Water';
                                                                elseif ($bill->bill_type === 'waste') echo '🗑️ Waste';
                                                                elseif ($bill->bill_type === 'security') echo '🛡️ Security';
                                                                else echo '🔌 ' . ucfirst($bill->bill_type);
                                                            ?>
                                                        </span>
                                                        <span class="text-slate-300">•</span>
                                                        <span class="text-slate-400 lowercase"><?php echo htmlspecialchars($bill->split_method); ?></span>
                                                    </div>
                                                </td>
                                                <td class="py-4 px-6 text-slate-500 font-medium"><?php echo htmlspecialchars($bill->property_name ?? 'N/A'); ?></td>
                                                <td class="py-4 px-6 font-bold text-slate-800">TZS <?php echo number_format($bill->total_amount, 0); ?></td>
                                                <td class="py-4 px-6 text-emerald-600 font-semibold"><?php echo htmlspecialchars($bill->net_amount); ?> Units</td>
                                                <td class="py-4 px-6 text-right flex items-center justify-end gap-2.5">
                                                <a href="<?= Url::to(['/landlord/utility-breakdown', 'billId' => $bill->id]) ?>" 
                                                    class="inline-block bg-indigo-50 text-indigo-600 px-3 py-1.5 rounded-lg text-[11px] font-bold hover:bg-indigo-100 transition shadow-3xs cursor-pointer text-center">
                                                       Breakdown
                                                </a>
                                                    <button onclick="deleteBill(<?php echo $bill->id; ?>)" class="bg-rose-50 text-rose-600 p-1.5 rounded-lg hover:bg-rose-100 transition cursor-pointer" title="Delete Master Bill">
                                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>
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

        document.addEventListener('click', function(event) {
            const popup = document.getElementById('profilePopup');
            const profileBtn = document.getElementById('profileBtn');
            const sidebar = document.getElementById('sidebarNav');
            const menuBtn = document.getElementById('menuBtn');
            
            if (!popup.classList.contains('hidden') && !popup.contains(event.target) && !profileBtn.contains(event.target)) {
                popup.classList.remove('opacity-100', 'scale-100');
                popup.classList.add('opacity-0', 'scale-95', 'pointer-events-none');
                setTimeout(() => popup.classList.add('hidden'), 200);
            }

            if (window.innerWidth < 1024 && !sidebar.classList.contains('-translate-x-full') && !sidebar.contains(event.target) && !menuBtn.contains(event.target)) {
                sidebar.classList.add('-translate-x-full');
            }
        });

        // =========================================================================
        // ADDED: AJAX FOR REGISTER & SPLIT BILL FORM (NO PAGE REFRESH ANIMATION)
        // =========================================================================
document.getElementById('splitBillForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Zuia fomu isirefreshi ukurasa mzima

    const form = this;
    const submitBtn = document.getElementById('submitBtn');
    const btnText = document.getElementById('btnText');
    const btnSpinner = document.getElementById('btnSpinner');

    // 1. Weka Mfumo kwenye Hali ya Loading
    submitBtn.disabled = true;
    submitBtn.classList.add('opacity-80', 'cursor-not-allowed');
    btnText.innerText = "Processing & Notifying Tenants...";
    btnSpinner.classList.remove('hidden');

    const formData = new FormData(form);

    // 2. Tuma Data kwenda kwenye Controller background
    fetch(form.action, {
        method: 'POST',
        body: formData
    })
    .then(response => {
        // Tunachukua jibu lote kama Text kwanza ili kuzuia "body stream already read"
        return response.text().then(text => {
            return {
                ok: response.ok,
                status: response.status,
                responseText: text
            };
        });
    })
    .then(res => {
        // 3. Toa Hali ya Loading
        submitBtn.disabled = false;
        submitBtn.classList.remove('opacity-80', 'cursor-not-allowed');
        btnText.innerText = "Split & Register Bill";
        btnSpinner.classList.add('hidden');

        // Kama Server imerudisha Error 500 au makosa mengine ya HTTP
        if (!res.ok) {
            throw new Error("Server Error (Status " + res.status + "): " + res.responseText);
        }

        // Jaribu kugeuza maandishi kuwa JSON object
        try {
            const data = JSON.parse(res.responseText);
            
            if(data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Bill Splitted Successfully!',
                    text: data.message,
                    confirmButtonColor: '#4f46e5'
                }).then(() => {
                    window.location.reload(); 
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Split Failed',
                    text: data.message,
                    confirmButtonColor: '#f43f5e'
                });
            }
        } catch (jsonError) {
            // Kama PHP imetema HTML Error badala ya JSON
            throw new Error("Invalid JSON Output hoho! Server Raw Response: " + res.responseText);
        }
    })
    .catch(error => {
        // Hakikisha hali ya loading inatoka hata hitilafu ikitokea
        submitBtn.disabled = false;
        submitBtn.classList.remove('opacity-80', 'cursor-not-allowed');
        btnText.innerText = "Split & Register Bill";
        btnSpinner.classList.add('hidden');
        
        // Popup kubwa itakayonyoosha maelezo yote ya kosa la PHP
        Swal.fire({
            icon: 'error',
            title: 'System Server Error',
            text: error.message.substring(0, 500), 
            confirmButtonColor: '#f43f5e'
        });
        console.error('Full Error:', error);
    });
});

        // =========================================================================
        // ADDED: AJAX FUNCTION FOR DELETING MASTER BILLS (WITH RELATIONAL INTEGRITY)
        // =========================================================================
        function deleteBill(billId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This will permanently delete this master bill and wipe out all distributed bills linked to tenants for this period!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f43f5e',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Tuma ombi la kufuta
                    fetch(`<?= Url::to(['/landlord/delete-bill', 'id' => 'BILL_ID']) ?>`.replace('BILL_ID', billId), {
                        method: 'POST',
                        headers: {
                            'X-CSRF-Token': '<?= Yii::$app->request->csrfToken ?>'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if(data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: data.message,
                                confirmButtonColor: '#4f46e5'
                            }).then(() => {
                                window.location.reload(); // Refresh ku-update kadi na jedwali data itakapofutika
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Failed',
                                text: data.message,
                                confirmButtonColor: '#f43f5e'
                            });
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to communicate with database.',
                            confirmButtonColor: '#f43f5e'
                        });
                        console.error('Error:', error);
                    });
                }
            });
        }
    </script>
</body>
</html>