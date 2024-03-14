<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Support';
?>

<section class="flexbox-container">
	<div class="card">
		<div class="card-header">
			<h4 class="form-section"><?= $this->title; ?></h4>
			
			<a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
			<div class="heading-elements">
				<ul class="list-inline mb-0">
					<li><a data-action="collapse"><i class="ft-minus"></i></a></li>
					<li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
					<li><a data-action="expand"><i class="ft-maximize"></i></a></li>
					<!-- <li><a data-action="close"><i class="ft-x"></i></a></li> -->
				</ul>
			</div>
		</div>
		<div class="card-content collapse show">
			<div class="card-body">
				<?php $form = ActiveForm::begin(); ?>
		
				<div class="row">
					<div class="col-md-6">
						<?= $form->field($model, 'fullName')->textInput(['maxlength' => true]) ?>
					</div>
					<div class="col-md-6">
						<?= $form->field($model, 'mobile')->widget(\yii\widgets\MaskedInput::className(), [
							'mask' => '9(999)999-999',
							'clientOptions' => [
								'removeMaskOnSubmit' => true
							],
							'options' => [
								'placeholder' => '0(7xx)xxx-xxx',
							]
						]); ?>
					</div>			
				</div>

				<div class="row">
					<div class="col-md-6">
						<?= $form->field($model, 'supportSubjectId')->dropDownList($supportSubjects, ['prompt'=>'Select', 'class' => 'form-control select2']); ?>
					</div>
					<div class="col-md-6">
						
					</div>			
				</div>

				<div class="row">
					<div class="col-md-6">
						<?= $form->field($model, 'description')->textarea(['rows' => 3])->label('Enter your support message below') ?>
					</div>
					<div class="col-md-6">
					</div>			
				</div>

				<div class="form-actions">
					<?= Html::a('<i class="ft-x"></i> Close', ['index'], ['class' => 'btn btn-warning mr-1']) ?>
					<?= Html::submitButton('<i class="la la-check-square-o"></i> Save', ['class' => 'btn btn-primary']); ?>
				</div>

				<?php ActiveForm::end(); ?>

		</div>
	</div>
</section>

<script src="<?= Yii::$app->request->baseUrl; ?>/app-assets/js/jquery.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl; ?>/app-assets/vendors/js/forms/select/select2.full.min.js"></script>
<script> $(".select2").select2(); </script>
