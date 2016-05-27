<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class InvitationsForm extends Model
{
    public $email;
    // password will be auto generated
    public $password;

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
        ];
    }

    /**
     * Send invitation.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function sendInvitation()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->email = $this->email;
        $this->password = $user->generatePassword();
        $user->setPassword($this->password);
        $user->setStatusInvited();
        $user->generateAuthKey();
        //generate account activation token, store it at db and send account activation email with this token
        if($user->generateAccountRegistrationToken() && $this->sendInvitationWithActivationTokenEmail($user)){
            Yii::$app->session->setFlash('success',"You`ev invited your friend.");
            $user->setSentDate();
        }

        return $user->save() ? $user : null;
    }

    /**
     * Sends email to registered user with account activation link.
     *
     * @param  object $user Registered user.
     * @return bool Whether the message has been sent successfully.
     */
    public function sendInvitationWithActivationTokenEmail($user)
    {
        return Yii::$app->mailer->compose('invitationWithRegistrationToken', ['user' => $user, 'password' => $this->password])
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Invitation to ' . Yii::$app->name)
            ->send();
    }
}