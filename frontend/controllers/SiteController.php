<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\SigninForm;
use common\models\User;
use frontend\models\AccountRegistration;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\InviteFriendForm;
use frontend\models\FeedbackForm;
use common\components\AuthHandler;

/**
 * Site controller
 */
class SiteController extends Controller
{

    /**
     * @var \common\models\User
     */
    private $_user;

    public $successUrl = 'Success';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup', 'aboutUs', 'invitations','activateAccount','inviteFriend', 'auth'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['auth'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['inviteFriend'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['activateAccount'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['invitations'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['aboutUs'],
                        'allow' => true,
                        'roles' => ['@']
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }

    public function onAuthSuccess($client)
    {
        (new AuthHandler($client))->handle();
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionSignin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new SigninForm();
        if ($model->load(Yii::$app->request->post()) && $model->signin()) {
            if ($user = User::findOne(['email' => Yii::$app->user->identity['email'], 'status' => User::STATUS_REGISTERED])) {
                $user->last_signin = time();
                if ($user->save()) {
                    return $this->goHome();
                }
                return $this->render('signin', [
                    'model' => $model,
                ]);
            }
            return $this->render('signin', [
                'model' => $model,
            ]);
        } else {
            return $this->render('signin', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionFeedbackForm()
    {
        $model = new FeedbackForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('feedbackForm', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays account activation successful page.
     *
     * @return mixed
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     * @throws BadRequestHttpException
     */
    public function actionRegisterAccount($token, $invited = null)
    {
        try {
            $user = new AccountRegistration($token, $invited);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($user->registerAccount())
        {
            Yii::$app->session->setFlash('success',
                'Success! You can now log in.');
        }
        else
        {
            Yii::$app->session->setFlash('error',
                'Your account could not be activated.');
        }

        return $this->redirect('login');
    }

    /**
     * Displays about us page.
     *
     * @return mixed
     */
    public function actionAboutUs()
    {
        return $this->render('aboutUs');
    }

    /**
     * Displays invitations page.
     *
     * @return mixed
     */
    public function actionInviteFriend()
    {
        $model = new InviteFriendForm();

        if ($model->load(Yii::$app->request->post())) {
            $model->sendInvitation();
        }

        return $this->render('invitateFriend', [
            'model' => $model,
        ]);
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        //code for default sex checked is male:  $model->sex = 'male';
        if ($model->load(Yii::$app->request->post())) {
            $model->signup();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
