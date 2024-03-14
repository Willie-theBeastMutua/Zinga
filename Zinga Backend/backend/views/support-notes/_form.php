<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SupportNotes */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
.btn-primary {
	border-color: #512E90 !important;
	background-color: #6BA342 !important;
	color: #FFFFFF !important;
}
</style>
<h4 class="form-section">Notes Details</h4>
<?php $form = ActiveForm::begin(['id' => 'currentForm']); ?>
<?= $form->field($model, 'supportId')->hiddenInput()->label(false); ?>

<div class="row">
	<div class="col-md-6">
		<?= $form->field($model, 'notes')->textarea(['rows' => 6]) ?>
	</div>
	<div class="col-md-6">
			
	</div>			
</div>

<div class="form-group">
	<?= Html::a('<i class="ft-x"></i> Close', null, ['class' => 'btn btn-warning mr-1' , 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('support-notes/index?sId=' . $model->supportId) . '", \'tab2\')']) ?>
	<?= Html::a('<i class="la la-check-square-o"></i> Save', null, ['class' => 'btn btn-primary mr-1', 'onclick' => 'submitForm("' . Yii::$app->urlManager->createUrl($model->isNewRecord ? 'support-notes/create?sId=' . $model->supportId : 'support-notes/update?id=' . $model->supportNoteId) . '",\'tab2\',\'currentForm\')']) ?>
</div>

<?php ActiveForm::end(); ?>
