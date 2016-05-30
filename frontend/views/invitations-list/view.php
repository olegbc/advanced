<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\InvitationsList */

$this->title = $model->email;
$this->params['breadcrumbs'][] = ['label' => 'Invitation list', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'id',
//            'role',
//            'auth_key',
//            'password_hash',
//            'password_reset_token',
//            'account_registration_token',
            'email:email',
//            'status',
            'name',
            'sex',
            'location',
            'sent_date',
            'registration_date',
            'inviter',
//            'created_at',
//            'updated_at',
        ],
    ]) ?>

</div>
