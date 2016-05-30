<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\InvitationsList */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Invitation list';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
//            'role',
//            'auth_key',
//            'password_hash',
//            'password_reset_token',
            // 'account_registration_token',
            'inviter',
             'email:email',
             'status',
            // 'name',
            // 'sex',
            // 'location',
             'sent_date',
             'registration_date',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
