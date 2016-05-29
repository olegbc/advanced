<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\SigninForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Signin';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signin">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to signin:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'signin-form']); ?>

                <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'rememberMe')->checkbox() ?>

                <div class="form-group">
                    <?= Html::submitButton('Signin', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
