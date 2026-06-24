<?php
/** @var yii\web\View $this */
use yii\helpers\Url;
use yii\helpers\Html;

// Kuandaa variable zisilete error zikiwa tupu
$name = $name ?? '';
$name_err = $name_err ?? '';
$email = $email ?? '';
$email_err = $email_err ?? '';
$password_err = $password_err ?? '';
$role = $role ?? 'tenant';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create an Account | Smart Landlord Premium</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        .dotted-bg {
            background-image: radial-gradient(#e2e8f0 1.5px, transparent 1.5px);
            background-size: 24px 24px;
        }
        /* ... code zako zingine za CSS (kama .dotted-bg) ... */
    
    @keyframes shimmer {
        100% { transform: translateX(250%); }
    }
    @keyframes slideUp {
        0% { transform: translateY(6px); opacity: 0; }
        100% { transform: translateY(0); opacity: 1; }
    }
    </style>
</head>
<body class="bg-white font-sans antialiased min-h-screen flex text-slate-800">

    <div class="w-full min-h-screen flex flex-col md:flex-row bg-white">
        
        <div class="w-full md:w-1/2 min-h-[550px] md:min-h-screen dotted-bg relative flex flex-col justify-between p-8 lg:p-16 border-b md:border-b-0 md:border-r border-slate-100">
            
            <div class="z-20">
                <span class="px-3 py-1 bg-indigo-50 text-indigo-700 rounded-full text-xs font-bold tracking-wide border border-indigo-100 flex items-center gap-2 w-fit shadow-xs">
                    <span class="w-2 h-2 rounded-full bg-indigo-600 animate-pulse"></span> Next-Gen Property Management
                </span>
            </div>

            <div class="w-full max-w-lg mx-auto my-auto space-y-8 z-20">
                
                <div class="space-y-3 min-h-[100px]">
                    <h1 id="dynamic-title" class="text-3xl lg:text-4xl font-extrabold tracking-tight text-slate-900 transition-all duration-500 transform opacity-100">
                        Automate Your Rental Income
                    </h1>
                    <p id="dynamic-desc" class="text-sm sm:text-base text-slate-500 font-medium transition-all duration-500 opacity-100">
                        collect rent, give receipt and track tenant arrears with Smart Landlord's digital system.
                    </p>
                </div>

                <div class="relative w-full h-72 sm:h-80 bg-slate-50 rounded-3xl p-3 border border-slate-200/80 shadow-2xl shadow-slate-200/50 overflow-hidden">
                    <div class="absolute inset-0 z-0">
                        <img src="https://images.unsplash.com/photo-1580587771525-78b9dba3b914?auto=format&fit=crop&w=800&q=80" class="slide-img absolute inset-0 w-full h-full object-cover transition-opacity duration-1000 opacity-100">
                        <img src="https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?auto=format&fit=crop&w=800&q=80" class="slide-img absolute inset-0 w-full h-full object-cover transition-opacity duration-1000 opacity-0">
                        <img src="https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=800&q=80" class="slide-img absolute inset-0 w-full h-full object-cover transition-opacity duration-1000 opacity-0">
                        <img src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&w=800&q=80" class="slide-img absolute inset-0 w-full h-full object-cover transition-opacity duration-1000 opacity-0">
                        <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=800&q=80" class="slide-img absolute inset-0 w-full h-full object-cover transition-opacity duration-1000 opacity-0">
                        <img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=800&q=80" class="slide-img absolute inset-0 w-full h-full object-cover transition-opacity duration-1000 opacity-0">
                        <img src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&w=800&q=80" class="slide-img absolute inset-0 w-full h-full object-cover transition-opacity duration-1000 opacity-0">
                        <img src="https://images.unsplash.com/photo-1586023492125-27b2c045efd7?auto=format&fit=crop&w=800&q=80" class="slide-img absolute inset-0 w-full h-full object-cover transition-opacity duration-1000 opacity-0">
                        <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=800&q=80" class="slide-img absolute inset-0 w-full h-full object-cover transition-opacity duration-1000 opacity-0">
                        <img src="https://images.unsplash.com/photo-1563986768609-322da13575f3?auto=format&fit=crop&w=800&q=80" class="slide-img absolute inset-0 w-full h-full object-cover transition-opacity duration-1000 opacity-0">
                    </div>
                    
                    <div class="absolute inset-0 bg-linear-to-t from-slate-950/40 via-transparent to-transparent z-10"></div>

                    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 z-20 flex gap-1.5 bg-slate-900/40 backdrop-blur-md px-3 py-1.5 rounded-full">
                        <span class="dot-indicator w-2 h-2 rounded-full bg-white transition-all duration-300"></span>
                        <span class="dot-indicator w-2 h-2 rounded-full bg-white/40 transition-all duration-300"></span>
                        <span class="dot-indicator w-2 h-2 rounded-full bg-white/40 transition-all duration-300"></span>
                        <span class="dot-indicator w-2 h-2 rounded-full bg-white/40 transition-all duration-300"></span>
                        <span class="dot-indicator w-2 h-2 rounded-full bg-white/40 transition-all duration-300"></span>
                        <span class="dot-indicator w-2 h-2 rounded-full bg-white/40 transition-all duration-300"></span>
                        <span class="dot-indicator w-2 h-2 rounded-full bg-white/40 transition-all duration-300"></span>
                        <span class="dot-indicator w-2 h-2 rounded-full bg-white/40 transition-all duration-300"></span>
                        <span class="dot-indicator w-2 h-2 rounded-full bg-white/40 transition-all duration-300"></span>
                        <span class="dot-indicator w-2 h-2 rounded-full bg-white/40 transition-all duration-300"></span>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4 pt-2 border-t border-slate-100 text-left">
                    <div>
                        <p class="text-xl font-black text-indigo-600">99.4%</p>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">On-time Pay</p>
                    </div>
                    <div>
                        <p class="text-xl font-black text-slate-900">10k+</p>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Active Units</p>
                    </div>
                    <div>
                        <p class="text-xl font-black text-slate-900">Zero</p>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Paperwork</p>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between z-20 text-[11px] text-slate-400 font-semibold tracking-wider uppercase">
                <span>Enterprise Grade Platform</span>
                <span>Secured by SSL</span>
            </div>
        </div>

        <div class="w-full md:w-1/2 flex items-center justify-center p-6 sm:p-12 md:p-16 bg-white z-20">
            <div class="w-full max-w-sm space-y-8">
                
                <div class="space-y-2">
    <div class="flex items-center gap-3.5 mb-8 group cursor-pointer w-fit">
        <div class="relative flex items-center justify-center w-12 h-12 rounded-2xl bg-linear-to-br from-indigo-600 via-indigo-700 to-slate-900 shadow-md shadow-indigo-200/50 overflow-hidden transition-all duration-500 ease-out group-hover:scale-105 group-hover:shadow-indigo-400/40">
            
            <div class="absolute inset-0 bg-linear-to-tr from-emerald-500 to-indigo-600 opacity-0 group-hover:opacity-100 transition-opacity duration-700 ease-in-out"></div>
            
            <svg class="w-6 h-6 text-white relative z-10 transition-transform duration-500 group-hover:rotate-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 21V9a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v12" class="animate-[slideUp_0.6s_ease-out]" />
                <path d="M10 21V5a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v16" class="animate-[slideUp_0.8s_ease-out] stroke-emerald-400 group-hover:stroke-white transition-colors duration-300" />
                <path d="M2 11l7-5 1 0.7" class="opacity-80" />
                <path d="M6 12h.01M6 16h.01M13 8h.01M13 12h.01M13 16h.01" stroke-width="3" />
            </svg>

            <div class="absolute inset-0 w-1/2 h-full bg-linear-to-r from-transparent via-white/20 to-transparent -skew-x-12 -translate-x-full group-hover:animate-[shimmer_0.8s_ease-in-out]"></div>
        </div>
        
        <div class="flex flex-col justify-center">
            <span class="text-xl font-black text-slate-900 tracking-tight leading-none transition-colors duration-300 group-hover:text-indigo-950">
                Smart<span class="text-indigo-600 group-hover:text-emerald-500 transition-colors duration-500">Landlord</span>
            </span>
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1 transition-all duration-300 group-hover:tracking-wider group-hover:text-indigo-600">
                Premium Ecosystem
            </span>
        </div>
    </div>
                    <h2 class="text-2xl font-bold text-slate-900 tracking-tight">
                        Create your account
                    </h2>
                    <p class="text-sm text-slate-500 font-medium">Join us today to manage your properties like a pro.</p>
                </div>

                <form action="<?= Url::to(['/user/register']) ?>" method="POST" class="space-y-4">
                    <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>
                    
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Full Name</label>
                        <input type="text" name="name" value="<?= Html::encode($name) ?>" 
                               placeholder="John Doe"
                               class="w-full px-3.5 py-2.5 bg-white border <?= (!empty($name_err)) ? 'border-red-500 ring-1 ring-red-500' : 'border-slate-200 focus:border-slate-900 focus:ring-1 focus:ring-slate-900'; ?> rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none transition-all text-sm shadow-xs">
                        <?php if (!empty($name_err)): ?>
                            <p class="text-xs text-red-500 font-medium flex items-center gap-1">
                                <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i> <?= Html::encode($name_err) ?>
                            </p>
                        <?php endif; ?>
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Email Address</label>
                        <input type="email" name="email" value="<?= Html::encode($email) ?>" 
                               placeholder="name@example.com"
                               class="w-full px-3.5 py-2.5 bg-white border <?= (!empty($email_err)) ? 'border-red-500 ring-1 ring-red-500' : 'border-slate-200 focus:border-slate-900 focus:ring-1 focus:ring-slate-900'; ?> rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none transition-all text-sm shadow-xs">
                        <?php if (!empty($email_err)): ?>
                            <p class="text-xs text-red-500 font-medium flex items-center gap-1">
                                <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i> <?= Html::encode($email_err) ?>
                            </p>
                        <?php endif; ?>
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Password</label>
                        <div class="relative">
                            <input type="password" id="passwordInput" name="password" 
                                   placeholder="••••••••"
                                   class="w-full px-3.5 py-2.5 bg-white border <?= (!empty($password_err)) ? 'border-red-500 ring-1 ring-red-500' : 'border-slate-200 focus:border-slate-900 focus:ring-1 focus:ring-slate-900'; ?> rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none transition-all text-sm shadow-xs pr-11">
                            
                            <button type="button" id="togglePassword" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 focus:outline-none cursor-pointer p-1">
                                <i data-lucide="eye" id="eyeIcon" class="w-4 h-4"></i>
                            </button>
                        </div>
                        <?php if (!empty($password_err)): ?>
                            <p class="text-xs text-red-500 font-medium flex items-center gap-1">
                                <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i> <?= Html::encode($password_err) ?>
                            </p>
                        <?php endif; ?>
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Account Type</label>
                        <select name="role" class="w-full px-3.5 py-2.5 bg-white border border-slate-200 focus:border-slate-900 focus:ring-1 focus:ring-slate-900 rounded-xl text-slate-900 text-sm focus:outline-none transition-all cursor-pointer shadow-xs">
                            <option value="tenant" <?= ($role === 'tenant') ? 'selected' : ''; ?>>Tenant</option>
                            <option value="landlord" <?= ($role === 'landlord') ? 'selected' : ''; ?>>Property Owner / Landlord</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full py-2.5 px-4 bg-slate-900 hover:bg-slate-800 active:bg-slate-950 text-white font-semibold rounded-xl transition-all focus:outline-none cursor-pointer text-sm tracking-wide mt-2 shadow-xs">
                        Register Account
                    </button>
                </form>

                <div class="relative flex py-2 items-center text-xs text-slate-400 font-bold uppercase tracking-wider">
                    <div class="flex-grow border-t border-slate-100"></div>
                    <span class="flex-shrink mx-4">Or</span>
                    <div class="flex-grow border-t border-slate-100"></div>
                </div>

                <div class="space-y-3">
                    <a href="<?= Url::to(['/user/auth', 'authclient' => 'google']) ?>" 
                       class="w-full flex items-center justify-center gap-3 py-2.5 px-4 bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 text-sm font-semibold rounded-xl shadow-xs transition-all duration-200 active:scale-[0.98] no-underline">
                        
                        <svg class="w-4 h-4 flex-shrink-0" viewBox="0 0 24 24">
                            <path fill="#EA4335" d="M12 5.04c1.66 0 3.2.57 4.38 1.69l3.27-3.27C17.67 1.58 15.01 1 12 1 7.35 1 3.39 3.67 1.41 7.56l3.83 2.97c.92-2.76 3.51-4.49 6.76-4.49z"/>
                            <path fill="#4285F4" d="M23.49 12.27c0-.81-.07-1.59-.2-2.36H12v4.51h6.46c-.29 1.48-1.14 2.73-2.42 3.57l3.77 2.92c2.2-2.03 3.68-5.03 3.68-8.64z"/>
                            <path fill="#FBBC05" d="M5.24 14.53c-.24-.72-.38-1.5-.38-2.31s.14-1.59.38-2.31L1.41 6.94C.51 8.75 0 10.77 0 12.86s.51 4.11 1.41 5.92l3.83-2.97z"/>
                            <path fill="#34A853" d="M12 23c3.24 0 5.97-1.07 7.96-2.92l-3.77-2.92c-1.11.75-2.53 1.19-4.19 1.19-3.25 0-5.84-1.73-6.76-4.49L1.41 16.82C3.39 20.71 7.35 23 12 23z"/>
                        </svg>
                        <span>Sign up with Google</span>
                    </a>
                    
                    <div class="text-center pt-2">
                        <p class="text-sm text-slate-500">
                            Already have an account? 
                            <a href="<?= Url::to(['/user/login']) ?>" class="font-bold text-slate-900 hover:text-indigo-600 transition-colors ml-1">Sign in</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        lucide.createIcons();

        // Password Toggle Logic
        const passwordInput = document.getElementById('passwordInput');
        const togglePasswordButton = document.getElementById('togglePassword');
        const eyeIcon = document.getElementById('eyeIcon');

        togglePasswordButton.addEventListener('click', () => {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.setAttribute('data-lucide', 'eye-off');
            } else {
                passwordInput.type = 'password';
                eyeIcon.setAttribute('data-lucide', 'eye');
            }
            lucide.createIcons();
        });

        // DATA YA UJUMBE WA MATANGAZO (Marketing Copy Data)
        const marketingContent = [
            { title: "Automate Your Rental Income", desc: "collect rent, give receipt and track tenant arrears with Smart Landlord's digital system." },
            { title: "Smart Apartment Tracking", desc: "Monitor and manage the status of tenants in your properties with ease." },
            { title: "Legally Binding Contracts", desc: "Create and sign legally binding contracts digitally without losing your valuable time." },
            { title: "Secure Property Key Control", desc: "Manage property keys securely with all tenant information stored in our safe cloud." },
            { title: "Corporate Office Management", desc: "Streamline the management of corporate offices and properties with our modern digital solutions." },
            { title: "Modern High-Rise Analytics", desc: "Get real-time reports on your property's performance and usage with our advanced analytics." },
            { title: "Paperless Digital Signing", desc: "Eliminate paper waste and reduce costs. All signatures and important documents are securely stored online." },
            { title: "Stunning Premium Interior Care", desc: "Monitor the condition of your property's interior before and after tenants move out." },
            { title: "Suburban Community Scaling", desc: "make easy management of suburban communities" },
            { title: "100% Data Protection & Security", desc: "Your information, your bank account and tenants being protected by high technology" }
        ];

        const images = document.querySelectorAll('.slide-img');
        const indicators = document.querySelectorAll('.dot-indicator');
        const titleEl = document.getElementById('dynamic-title');
        const descEl = document.getElementById('dynamic-desc');
        
        let currentIndex = 0;
        const intervalTime = 4000;

        function updateSlideshow() {
            images[currentIndex].classList.remove('opacity-100');
            images[currentIndex].classList.add('opacity-0');
            indicators[currentIndex].classList.replace('bg-white', 'bg-white/40');
            indicators[currentIndex].classList.remove('w-4');
            indicators[currentIndex].classList.add('w-2');

            titleEl.classList.add('opacity-0', '-translate-y-1');
            descEl.classList.add('opacity-0');

            currentIndex = (currentIndex + 1) % images.length;

            images[currentIndex].classList.remove('opacity-0');
            images[currentIndex].classList.add('opacity-100');
            indicators[currentIndex].classList.replace('bg-white/40', 'bg-white');
            indicators[currentIndex].classList.remove('w-2');
            indicators[currentIndex].classList.add('w-4');

            setTimeout(() => {
                titleEl.textContent = marketingContent[currentIndex].title;
                descEl.textContent = marketingContent[currentIndex].desc;
                
                titleEl.classList.remove('opacity-0', '-translate-y-1');
                descEl.classList.remove('opacity-0');
            }, 300);
        }

        setInterval(updateSlideshow, intervalTime);
    </script>
</body>
</html>