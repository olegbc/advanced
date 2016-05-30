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

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Block', ['block', 'id' => $model->id], [
            'class' => 'btn btn-default',
            'data' => [
                'confirm' => 'Are you sure you want to block this invititation?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this invititation?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'role',
            'auth_key',
            'password_hash',
            'password_reset_token',
            'account_registration_token',
            'email:email',
            'status',
            'name',
            'sex',
            'location',
            'sent_date',
            'registration_date',
            'inviter',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
