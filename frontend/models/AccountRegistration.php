<?php
namespace frontend\models;

use common\models\User;
use yii\base\InvalidParamException;
use yii\base\Model;
use Yii;

/**
 * Class representing account activation.
 */
class AccountRegistration extends Model
{
    /**
     * @var \common\models\User
     */
    private $_user;
    /**
     * Creates the user object given a token.
     *
     * @param  string $token  Account activation token.
     * @param  array  $config Name-value pairs that will be used to initialize the object properties.
     *
     * @throws \yii\base\InvalidParamException  If token is empty or not valid.
     */
    public function __construct($token, $invited, $config = [])
    {
        if (empty($token) || !is_string($token))
        {
            throw new InvalidParamException('Account registration token cannot be blank.');
        }

        $this->_user = User::findByAccountRegistrationToken($token, $invited);

        if (!$this->_user)
        {
            throw new InvalidParamException('Wrong account registration token.');
        }

        parent::__construct($config);
    }

    /**
     * Activates account.
     *
     * @return bool Whether the account was activated.
     */
    public function registerAccount()
    {
        $user = $this->_user;

        $user->status = User::STATUS_REGISTERED;
        $user->registration_date = time();
        $user->removeAccountRegistrationToken();

        return $user->save();
    }
}