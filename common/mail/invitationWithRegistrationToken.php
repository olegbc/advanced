<?php
use yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var $user common\models\User
 * @var $password frontend\models\InvitationsForm
 */
$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/register-account', 'invited' => $user->status, 'token' => $user->account_registration_token]);
?>

    Hello <?= Html::encode($user->email) ?>,

    would you like to join our site <?= Html::encode(Yii::$app->name) ?>? <br />

    If so - copy your pre made password:

<?= Html::encode($password) ?><br />

 and

<?= Html::a(' ' . 'click here to register your account.', $resetLink) ?>


