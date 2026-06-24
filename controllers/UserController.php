<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;
use app\models\User;

class UserController extends Controller
{
    // Inalazimisha fomu zote za UserController (Login, Register, Forgot Password) zisitumie layout ya default ya Yii
    public $layout = false;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'complete-profile'],
                'rules' => [
                    [
                        'actions' => ['logout', 'complete-profile'],
                        'allow' => true,
                        'roles' => ['@'], // Lazima awe ameshaingia kwenye mfumo
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * SANIDI AUTH ACTION KWA AJILI YA GOOGLE NA APPLE
     */
    public function actions()
    {
        return [
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->redirect(['login']);
    }

    public function actionRegister()
    {
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $role = trim((string)($post['role'] ?? 'tenant'));
            $initialStatus = ($role === 'landlord') ? 'inactive' : 'active';

            $data = [
                'name' => trim((string) ($post['name'] ?? '')),
                'email' => trim((string) ($post['email'] ?? '')),
                'password' => trim((string) ($post['password'] ?? '')),
                'role' => $role,
                'status' => $initialStatus,
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
            ];

            if ($data['name'] === '') {
                $data['name_err'] = 'Please enter your full name';
            }

            if ($data['email'] === '') {
                $data['email_err'] = 'Please enter your email address';
            } elseif (User::findByEmail($data['email']) !== null) {
                $data['email_err'] = 'This email address is already registered';
            }

            if ($data['password'] === '') {
                $data['password_err'] = 'Please enter a password';
            }

            if ($data['name_err'] === '' && $data['email_err'] === '' && $data['password_err'] === '') {
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                if (User::register($data)) {
                    return $this->redirect(['login']);
                }

                throw new \yii\web\ServerErrorHttpException('Something went wrong on the server side.');
            }

            return $this->render('register', $data);
        }

        return $this->render('register', [
            'name' => '', 'email' => '', 'password' => '', 'role' => '',
            'name_err' => '', 'email_err' => '', 'password_err' => '',
        ]);
    }

    public function actionLogin()
    {
        // --- REKEBISHO LA KITALAMU LIPO HAPA ---
        // Kama mtumiaji alikuwa amesha-login lakini anafungua ukurasa huu (kutoka register au kwingine),
        // Tunamtoa (Logout) kwanza ili fomu mpya ya login ifunguke bila kuelekeza kwenye route zenye 404.
        if (!Yii::$app->user->isGuest) {
            Yii::$app->user->logout();
        }

        $response = Yii::$app->getResponse();
        $response->getHeaders()->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        $response->getHeaders()->set('Pragma', 'no-cache');
        $response->getHeaders()->set('Expires', '0');

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();

            $email = trim((string) ($post['email'] ?? ''));
            $password = trim((string) ($post['password'] ?? ''));
            $email_err = '';
            $password_err = '';

            if ($email === '') {
                $email_err = 'Please enter your email address';
            }
            if ($password === '') {
                $password_err = 'Please enter your password';
            }

            $user = User::findByEmail($email);

            if ($user === null && $email_err === '') {
                $email_err = 'No account found with this email';
            }

            if ($email_err === '' && $password_err === '') {
                if ($user !== null && $user->validatePassword($password)) {
                    
                    if ($user->status === 'inactive') {
                        Yii::$app->session->setFlash('email_err', 'Your account is pending admin approval.');
                        Yii::$app->session->setFlash('old_email', $email);
                        return $this->redirect(['login']);
                    }

                    return $this->createUserSession($user);
                }

                $password_err = 'Incorrect password, please try again';
            }

            if ($email_err) Yii::$app->session->setFlash('email_err', $email_err);
            if ($password_err) Yii::$app->session->setFlash('password_err', $password_err);
            Yii::$app->session->setFlash('old_email', $email);

            return $this->redirect(['login']);
        }

        return $this->render('login', [
            'email' => Yii::$app->session->getFlash('old_email', '', true),
            'password' => '',
            'email_err' => Yii::$app->session->getFlash('email_err', '', true),
            'password_err' => Yii::$app->session->getFlash('password_err', '', true),
        ]);
    }

    /**
     * MBINU YA KUPOKEA DATA KUTOKA GOOGLE (SOCIAL AUTH SUCCESS) - PROFESSIONAL UPDATE
     */
    public function onAuthSuccess($client)
    {
        $attributes = $client->getUserAttributes();
        $email = $attributes['email'] ?? null;
        $name = $attributes['name'] ?? 'Google User';

        if ($email) {
            $user = User::findByEmail($email);

            // 1. KAMA TAYARI ANA AKAUNTI: Mpe session na mpeleke kwenye dashboard yake halisi kitalamu
            if ($user) {
                if ($user->status === 'inactive') {
                    Yii::$app->session->setFlash('email_err', 'Your account is pending admin approval.');
                    return $this->redirect(['login']);
                }
                return $this->createUserSession($user);
            } 

            // 2. KAMA NI MTUMIAJI MPYA (NDIO ANAJISAJILI):
            $chosenRole = Yii::$app->request->get('role') ?? 'tenant';
            if (!in_array($chosenRole, ['admin', 'landlord', 'tenant'])) {
                $chosenRole = 'tenant';
            }

            $initialStatus = ($chosenRole === 'landlord') ? 'inactive' : 'active';

            $data = [
                'name' => $name,
                'email' => $email,
                'password' => password_hash(Yii::$app->security->generateRandomString(12), PASSWORD_DEFAULT),
                'role' => $chosenRole, 
                'status' => $initialStatus,
            ];

            if (User::register($data)) {
                $newUser = User::findByEmail($email);
                if ($newUser) {
                    return $this->createUserSession($newUser);
                }
            }
            
            Yii::$app->session->setFlash('email_err', 'Failed to register via Google.');
        } else {
            Yii::$app->session->setFlash('email_err', 'Failed to retrieve email from Google.');
        }
        return $this->redirect(['login']);
    }

    protected function createUserSession(User $user): Response
    {
        $user->ensureAuthKey();
        Yii::$app->user->login($user, 3600 * 24 * 30); // Login kwa siku 30
        return $this->redirectBasedOnRole($user);
    }

    /**
     * MBINU YA KUELEKEZA MTUMIAJI KULINGANA NA JUKUMU LAKE (Kuzuia 404 kabisa)
     */
    private function redirectBasedOnRole($user): Response
    {
        if ($user->role === 'admin') {
            return $this->redirect(['/admin/dashboard']); 
        }
        if ($user->role === 'landlord') {
            return $this->redirect(['/landlord/dashboard']);
        }
        if ($user->role === 'tenant') {
            if (empty($user->phone)) { 
                return $this->redirect(['complete-profile']); 
            }
            return $this->redirect(['/tenant/index']); 
        }
        return $this->redirect(['login']);
    }

    public function actionForgotPassword()
    {
        $this->layout = false;
        $email = ''; $email_err = ''; $success_msg = '';

        if (Yii::$app->request->isPost) {
            $email = Yii::$app->request->post('email');

            if (empty($email)) {
                $email_err = 'Email address is required.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $email_err = 'Please enter a valid email address.';
            } else {
                $success_msg = 'Reset link has been sent to your email address.';
                $email = ''; 
            }
        }

        return $this->render('forgot-password', [
            'email' => $email, 'email_err' => $email_err, 'success_msg' => $success_msg,
        ]);
    }

    public function actionCompleteProfile()
    {
        if (Yii::$app->user->isGuest || Yii::$app->user->identity->role !== 'tenant') {
            return $this->redirect(['login']);
        }

        $user = Yii::$app->user->identity;

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $user->phone = trim((string)($post['phone'] ?? ''));

            if ($user->validate() && $user->save(false)) {
                Yii::$app->session->setFlash('success', 'Profile completed successfully!');
                return $this->redirect(['/tenant/index']); 
            }
        }

        return $this->render('complete-profile', [
            'user' => $user
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect(['login']);
    }
}