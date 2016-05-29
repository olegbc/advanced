<?php
use yii\helpers\Html;

/**
  * @var $this yii\web\View
  * @var $user common\models\User
  */
    $resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/register-account', 'token' => $user->account_registration_token]);
?>

    Hello <?= Html::encode($user->email) ?>,

    Follow this link to register your account:

<?= Html::a('Please, click here to register your account.', $resetLink) ?>