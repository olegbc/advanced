<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string  $account_registration_token
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $sent_date
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_INVITED = 1;
    const STATUS_NOT_REGISTERED = 5;
    const STATUS_BLOCKED = 6;
    const STATUS_REMOVED = 7;
    const STATUS_REGISTERED = 10;

    const ROLE_USER = 10;
    const ROLE_ADMIN = 20;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_NOT_REGISTERED],
            ['status', 'in', 'range' => [self::STATUS_REGISTERED, self::STATUS_NOT_REGISTERED, self::STATUS_INVITED, self::STATUS_BLOCKED, self::STATUS_REMOVED]],
            ['role', 'default', 'value' => 10],
            ['role', 'in', 'range' => [self::ROLE_USER, self::ROLE_ADMIN]],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_REGISTERED]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_REGISTERED]);
    }

    /**
     * Finds user by email.
     *
     * @param  string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => User::STATUS_REGISTERED]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_REGISTERED,
        ]);
    }

    /**
     * Finds user by account activate token
     *
     * @param string $token account activate token
     * @return static|null
     */
    public static function findByAccountRegistrationToken($token, $invited)
    {
        if (!static::isAccountActivateTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'account_registration_token' => $token,
            'status' => $invited == self::STATUS_INVITED ? self::STATUS_INVITED : self::STATUS_NOT_REGISTERED,
        ]);
    }

    /**
     * Finds out if account activate token is valid
     *
     * @param string $token account activate token
     * @return boolean
     */
    public static function isAccountActivateTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.accountActivateTokenExpire'];
        return $timestamp + $expire >= time();
    }


    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generatePassword()
    {
        return Yii::$app->security->generateRandomString();
    }

    /**
     * Set user status to not active(10)
     */
    public function setStatusNotRegistered()
    {
        $this->status = self::STATUS_NOT_REGISTERED;
    }

    /**
     * Set user status to invited(1)
     */
    public function setStatusInvited()
    {
        $this->status = self::STATUS_INVITED;
    }

    /**
     * Set sent invitation date
     */
    public function setSentDate()
    {
        $this->sent_date = time();
    }

    /**
     * Set inviter email
     */
    public function setInviter($email)
    {
        $this->inviter = $email;
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    // checks whether $email admin
/*    public static function isUserAdmin($email)
    {
        if (static::findOne(['email' => $email, 'role' => self::ROLE_ADMIN])){
            return true;
        } else {
            return false;
        }

    }*/

    /**
     * Generates new account registration token.
     */
    public function generateAccountRegistrationToken()
    {
        return $this->account_registration_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes account registration token.
     */
    public function removeAccountRegistrationToken()
    {
        $this->account_registration_token = null;
    }
}
