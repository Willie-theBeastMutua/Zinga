<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$baseUrl = Yii::$app->request->baseUrl;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- BEGIN: Content-->

<div class=" content-header row" style="padding: 15px;">
	<div class="col-12 d-flex align-items-center justify-content-center">
		<div class="col-lg-4 col-md-6 col-12 box-shadow-2 p-0">
			<div class="card border-grey border-lighten-3 m-0">
				<div class="card-header border-0">
					<div class="card-title text-center">
						<div class="row">
							<div class="col-12">
								<div class="p-1" style="height: 200px">
                                    <img src="<?= $baseUrl; ?>/app-assets/images/logo/logo.png" alt="logo" width="40%">
                                </div>
							</div>
						</div>
					</div>
					<h1 style="text-align: center; font-weight: 900">NAWIRI</h1> 
					<h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2"><span><?= Html::encode($this->title) ?></span></h6>
				</div>
				<div class="card-content">					                                
					<div class="card-body pt-0">
						<?php $form = ActiveForm::begin(['id' => 'login-form', 'class' => 'form-horizontal' ]); ?>

						<?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('Email') ?>

						<?= $form->field($model, 'password')->passwordInput() ?>													

						<div class="form-group row">
							<div class="col-sm-6 col-12 text-center text-sm-left">
								<?= $form->field($model, 'rememberMe')->checkbox() ?>
							</div>
							<!-- <div class="col-sm-6 col-12 float-sm-left text-center text-sm-right"><a href="recover-password.html" class="card-link">Forgot Password?</a></div> -->
						</div>
						
						<?= Html::submitButton('Login', ['class' => 'btn btn-outline-info btn-block', 'name' => 'login-button']) ?>
						
						<?php ActiveForm::end(); ?>                                        
					</div>
					<!-- <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2"><span>Don't Have Account?</span></h6>

					<div class="card-body">
						<a href="<?= $baseUrl; ?>/site/register" class="btn btn-outline-danger btn-block waves-effect waves-light"><i class="ft-user"></i> Register</a>
					</div> -->
					
				</div>
			</div>
		</div>
	</div>
</div>
<!-- END: Content-->
