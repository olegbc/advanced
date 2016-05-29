<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Invite friend';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Invite your friend by mail: </p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-invitation']); ?>

                <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Invite', ['class' => 'btn btn-primary', 'name' => 'invitation-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>

            <div style="color:#666;margin:1em 0">
                <i><span style="color:red">*</span> Required fields.</i><br />
                <i>** We will send you an email with account activation link.</i>
            </div>
        </div>
    </div>
</div>