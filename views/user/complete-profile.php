<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $user app\models\User */

$this->title = 'Complete Your Profile | Smart Landlord Premium';
?>
<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-50 dark:bg-slate-950">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= Html::encode($this->title) ?></title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
</head>
<body class="h-full flex items-center justify-center p-4 antialiased selection:bg-indigo-500 selection:text-white text-slate-900 dark:text-slate-100">

    <div class="w-full max-w-md bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-xl p-8 backdrop-blur-md">
        
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-14 h-14 bg-indigo-50 dark:bg-indigo-950/50 text-indigo-600 dark:text-indigo-400 rounded-xl mb-4 shadow-sm border border-indigo-100 dark:border-indigo-900/50">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <h2 class="text-2xl font-bold tracking-tight text-slate-800 dark:text-white">Hatua ya Mwisho</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-2">Habari <b><?= Html::encode($user->name) ?></b>, weka namba yako ya simu ili kukamilisha usajili wako kama Mpangaji.</p>
        </div>

        <?php $form = ActiveForm::begin([
            'id' => 'complete-profile-form',
            'options' => ['class' => 'space-y-5'],
        ]); ?>

            <div>
                <label for="phone" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Namba ya Simu</label>
                <div class="relative rounded-xl shadow-xs">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400 dark:text-slate-500 text-sm">
                        <span>+255</span>
                    </div>
                    <input type="tel" name="phone" id="phone" required placeholder="712345678" 
                           class="block w-full pl-14 pr-4 py-2.5 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/80 rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-slate-900 dark:text-white placeholder-slate-400 transition-all duration-150">
                </div>
                <p class="text-xs text-slate-400 dark:text-slate-500 mt-1.5">Ingiza namba bila kuanza na 0 au +255.</p>
            </div>

            <button type="submit" 
                    class="w-full flex items-center justify-center gap-2 py-3 px-4 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-semibold rounded-xl shadow-md shadow-indigo-500/10 hover:shadow-indigo-500/20 transition-all duration-200 cursor-pointer active:scale-[0.98]">
                <span>Kamilisha na Uingie Ndani</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                </svg>
            </button>

        <?php ActiveForm::end(); ?>

    </div>

</body>
</html>