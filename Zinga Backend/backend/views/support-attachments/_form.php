<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SupportAttachments */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
.btn-primary {
	border-color: #512E90 !important;
	background-color: #6BA342 !important;
	color: #FFFFFF !important;
}
</style>
<h4 class="form-section"><?= $this->title; ?></h4>
<?php $form = ActiveForm::begin(['id' => 'currentForm', 'options' => ['enctype' => 'multipart/form-data']]) ?>
<?= $form->field($model, 'supportId')->hiddenInput()->label(false); ?>

<div class="row">
	<div class="col-md-6">
		<?= $form->field($model, 'caption')->textInput(['maxlength' => true]) ?>
	</div>
	<div class="col-md-6">
		<?= $form->field($model, 'imageFile')->fileInput() ?>
	</div>			
</div>

<div class="form-group">
	<?= Html::a('<i class="ft-x"></i> Close', null, ['class' => 'btn btn-warning mr-1' , 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('support-attachments/index?sId=' . $model->supportId) . '", \'tab3\')']) ?>
	<?= Html::a('<i class="la la-check-square-o"></i> Save', null, ['class' => 'btn btn-primary mr-1', 'onclick' => 'submitForm("' . Yii::$app->urlManager->createUrl($model->isNewRecord ? 'support-attachments/create?sId=' . $model->supportId : 'support-attachments/update?id=' . $model->attachmentId) . '",\'tab3\',\'currentForm\')']) ?>
</div>
<?php ActiveForm::end(); ?>
