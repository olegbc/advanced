<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to signup:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'name')->textInput() ?>

                <?= $form->field($model, 'sex')->radioList(['male' => 'male', 'femail' => 'femail']) ?>

                <?= $form->field($model, 'location')->textInput() ?>

                <div class="form-group">
                    <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>

            <div style="color:#666;margin:1em 0">
                <i><span style="color:red">*</span> Required fields.</i><br />
                <i>** We will send you an email with account activation link.</i>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-5">
            <p> --- OR ---</p>
            <?= yii\authclient\widgets\AuthChoice::widget([
                'baseAuthUrl' => ['site/auth'],
                'popupMode' => false,
            ]) ?>
        </div>
    </div>
</div>
