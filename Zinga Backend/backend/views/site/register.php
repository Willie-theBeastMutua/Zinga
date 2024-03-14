<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$baseUrl = Yii::$app->request->baseUrl;

$this->title = 'APIs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class=" content-header row" style="padding: 15px">
    <div class="col-12 d-flex align-items-center justify-content-center">
        <div class="col-lg-6 col-md-8 col-12 box-shadow-2 p-0">
            <div class="card border-grey border-lighten-3 m-0">
                <div class="card-header border-0">									
                    <h4 class="form-section">Register</h4>
                </div>
                <div class="card-content">                                    
                    <div class="card-body pt-0">
                        <?php $form = ActiveForm::begin(['id' => 'login-form', 'class' => 'form-horizontal']); ?>

                        <?= $form->field($model, 'firstName')->textInput(['autofocus' => true])->label('First Name') ?>
                        <?= $form->field($model, 'lastName')->textInput([])->label('Last Name') ?>
                        <?= $form->field($model, 'mobile')->textInput([])->label('Mobile') ?>
                        <?= $form->field($model, 'email')->textInput([])->label('Email') ?>

                        <?= $form->field($model, 'password')->passwordInput()->label('Password') ?>													
                        <?= $form->field($model, 'confirmPassword')->passwordInput()->label('Confirm Password') ?>

                        <?= Html::submitButton('Register', ['class' => 'btn btn-outline-info btn-block', 'name' => 'login-button']) ?>

                        <?php ActiveForm::end(); ?>                                        
                    </div>									
                </div>
            </div>
        </div>
    </div>
</div>
