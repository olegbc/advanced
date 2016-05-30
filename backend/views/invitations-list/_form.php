<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\InvitationsList */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'email')->textInput() ?>

    <?= $form->field($model, 'name')->textInput() ?>

    <?= $form->field($model, 'sex')->textInput() ?>

    <?= $form->field($model, 'location')->textInput() ?>

    <?php  $form->field($model, 'id')->textInput() ?>

    <?php  $form->field($model, 'role')->textInput() ?>

    <?php  $form->field($model, 'auth_key')->textInput() ?>

    <?php  $form->field($model, 'password_hash')->textInput() ?>

    <?php  $form->field($model, 'password_reset_token')->textInput() ?>

    <?php  echo $form->field($model, 'account_registration_token')->textInput() ?>

    <?php  echo $form->field($model, 'inviter')->textInput() ?>

    <?php  echo $form->field($model, 'email')->textInput() ?>

    <?php  echo $form->field($model, 'status')->textInput() ?>

    <?php  echo $form->field($model, 'name')->textInput() ?>

    <?php  echo $form->field($model, 'sex')->textInput() ?>

    <?php  echo $form->field($model, 'location')->textInput() ?>

    <?php  echo $form->field($model, 'sent_date')->textInput() ?>

    <?php  echo $form->field($model, 'registration_date')->textInput() ?>

    <?php  echo $form->field($model, 'created_at')->textInput() ?>

    <?php  echo $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
