<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
//    public $username;
    public $email;
    public $password;
    public $status;
    public $name;
    public $sex;
    public $location;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            // status is set to not active for registration with activation
            ['status', 'default', 'value' => User::STATUS_NOT_ACTIVE],
            ['status', 'in', 'range' => [User::STATUS_NOT_ACTIVE, User::STATUS_ACTIVE]],

            ['name', 'filter', 'filter' => 'trim'],
            ['name', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['name', 'string', 'min' => 2, 'max' => 255],

            ['sex', 'integer', 'min' => 1, 'max' => 2],

            ['name', 'filter', 'filter' => 'trim'],
            ['location', 'string', 'min' => 2, 'max' => 255],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->email = $this->email;
        $user->setPassword($this->password);
        if ($this->name) {
            $user->name = $this->name;
        }
        if ($this->sex) {
            $user->sex = $this->sex;
        }
        if ($this->location) {
            $user->location = $this->location;
        }
        $user->setStatusNotActive();
        $user->generateAuthKey();
        //generate account activation token, store it at db and send account activation email with this token
        if($user->generateAccountActivationToken() && $this->sendAccountActivationEmail($user)){
            Yii::$app->session->setFlash('success',"Check Your Email To Activate Your Account");
        }

        return $user->save() ? $user : null;
    }

    /**
     * Sends email to registered user with account activation link.
     *
     * @param  object $user Registered user.
     * @return bool Whether the message has been sent successfully.
     */
    public function sendAccountActivationEmail($user)
    {
        return Yii::$app->mailer->compose('accountActivationToken', ['user' => $user])
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account activation for ' . Yii::$app->name)
            ->send();
    }
}
