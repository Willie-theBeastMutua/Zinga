<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Pages */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="card">
	<div class="card-header">
		<h4 class="form-section"> <?= $this->title; ?></h4>

		<a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
		<div class="heading-elements">
			<ul class="list-inline mb-0">
				<!-- <li><a data-action="collapse"><i class="ft-minus"></i></a></li> -->
				<li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
				<li><a data-action="expand"><i class="ft-maximize"></i></a></li>
				<!-- <li><a data-action="close"><i class="ft-x"></i></a></li> -->
				<li><a class="" href="/gii"><i class="ft-x"></i></a></li>
			</ul>
		</div>
	</div>
	<div class="card-content collapse show">
		<div class="card-body">

			<?php $form = ActiveForm::begin(); ?>
			<div class="row">
				<div class="col-md-6">

				</div>
				<div class="col-md-6">

				</div>
			</div>

			<?= $form->field($model, 'pageName')->textInput(['maxlength' => true]) ?>

			<!-- <?= $form->field($model, 'create')->dropDownList([
				'prompt' => 'Select', 'class' => 'form-control select2',
				$model::STATUS_YES => 'Yes',
				$model::STATUS_NO => 'No',
			]) ?> -->
			<?= $form->field($model, 'create')->dropDownList(
				[
					$model::STATUS_YES => 'Yes',
					$model::STATUS_NO => 'No',
				],
				[
					'prompt' => 'Select',
					'class' => 'form-control select2',
				]
			) ?>

			<?= $form->field($model, 'edit')->dropDownList(
				[
					$model::STATUS_YES => 'Yes',
					$model::STATUS_NO => 'No',
				],
				[
					'prompt' => 'Select',
					'class' => 'form-control select2',
				]
			) ?>

			<?= $form->field($model, 'delete')->dropDownList(
				[
					$model::STATUS_YES => 'Yes',
					$model::STATUS_NO => 'No',
				],
				[
					'prompt' => 'Select',
					'class' => 'form-control select2',
				]
			) ?>

			<?= $form->field($model, 'view')->dropDownList(
				[
					$model::STATUS_YES => 'Yes',
					$model::STATUS_NO => 'No',
				],
				[
					'prompt' => 'Select',
					'class' => 'form-control select2',
				]
			) ?>

			<?= $form->field($model, 'comments')->textarea(['rows' => 6]) ?>

			<!-- <?= $form->field($model, 'createdTime')->textInput() ?> -->

			<!-- <?= $form->field($model, 'updatedTime')->textInput() ?> -->

			<!-- <?= $form->field($model, 'deletedTime')->textInput() ?> -->

			<?= $form->field($model, 'createdBy')->dropDownList($users, ['prompt' => 'Select', 'class' => 'form-control select2']); ?>

			<!-- <?= $form->field($model, 'deleted')->textInput() ?> -->

			<div class="form-group">
				<?= Html::a('<i class="ft-x"></i> Close', ['index'], ['class' => 'btn btn-warning mr-1']) ?>
				<?= ((isset($rights->create) && $rights->create == 1) || (isset($rights->edit) && $rights->edit == 1)) ? Html::submitButton('<i class="la la-check-square-o"></i> Save', ['class' => 'btn btn-primary']) : '' ?>
			</div>

			<?php ActiveForm::end(); ?>
		</div>
	</div>
</div>
<script src="<?= Yii::$app->request->baseUrl; ?>/app-assets/js/jquery.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl; ?>/app-assets/vendors/js/forms/select/select2.full.min.js"></script>
<script>
	$(".select2").select2();
</script>