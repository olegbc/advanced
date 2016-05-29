<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property integer $role
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $account_registration_token
 * @property string $email
 * @property integer $status
 * @property string $name
 * @property string $sex
 * @property string $location
 * @property integer $sent_date
 * @property integer $registration_date
 * @property string $inviter
 * @property integer $created_at
 * @property integer $updated_at
 */
class InvitationsList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

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

            ['name', 'filter', 'filter' => 'trim'],
            ['name', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['name', 'string', 'min' => 2, 'max' => 255],

            ['sex', 'string'],

            ['location', 'filter', 'filter' => 'trim'],
            ['location', 'string', 'min' => 2, 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role' => 'Role',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'account_registration_token' => 'Account Registration Token',
            'email' => 'Email',
            'status' => 'Status',
            'name' => 'Name',
            'sex' => 'Sex',
            'location' => 'Location',
            'sent_date' => 'Sent Date',
            'registration_date' => 'Registration Date',
            'inviter' => 'Inviter',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
