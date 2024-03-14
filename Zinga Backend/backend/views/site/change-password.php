<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$baseUrl = Yii::$app->request->baseUrl;

$this->title = 'Change Password';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
	@media (max-width:629px) {
	img#logo {
		display: none;
	}
	}
</style>

<!-- BEGIN: Content-->
<div class="app-content content">
	<div class="content-header row">
	</div>
	<div class="content-wrapper">
		<div class="content-body">
			<section class="flexbox-container">
				<div class="col-12 d-flex align-items-center justify-content-center">
					<div class="col-lg-6 col-md-10 col-8 box-shadow-2 p-0">
							<div class="card border-grey border-lighten-3 m-0">
								<div class="card-header border-0">
									<h4 class="form-section">Change Password</h4>
									<!-- <div class="card-title text-center">
										<div class="p-1"><img src="<?= $baseUrl; ?>/app-assets/images/logo/appicon2.png" alt="branding logo" width="80%"></div>
									</div>
									<h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2"><span><?= Html::encode($this->title) ?></span></h6> -->
								</div>
								<div class="card-content">                                    
									<div class="card-body pt-0">
										<?php $form = ActiveForm::begin(['id' => 'login-form', 'class' => 'form-horizontal' ]); ?>

										<?= $form->field($model, 'Password', ['options' => ['class' => 'form-group required']])->passwordInput(['autofocus' => true]) ?>
										<?= $form->field($model, 'ConfirmPassword', ['options' => ['class' => 'form-group required']])->passwordInput() ?>

										<div class="form-group">
											<?= Html::submitButton('<i class="ft-unlock"></i> Change Password', ['class' => 'btn btn-outline-info btn-block', 'name' => 'login-button']) ?>
										</div>

										<?php ActiveForm::end(); ?>                                         
									</div>
									
								</div>
							</div>
					</div>
				</div>
			</section>
		</div>
	</div>
</div>
<!-- END: Content-->
