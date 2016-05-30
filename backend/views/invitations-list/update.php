<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\InvitationsList */

$this->title = 'Update User: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Invitation list', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
