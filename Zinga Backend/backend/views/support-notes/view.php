<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\SupportNotes */

$this->title = $model->supportNoteId;
$this->params['breadcrumbs'][] = ['label' => 'Support Notes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<style>
.btn-primary {
	color: #FFFFFF !important;
}

.btn-danger {
	color: #FFFFFF !important;
}

.btn-warning {
	color: #FFFFFF !important;
}
</style>

<p>
	<?= Html::a('<i class="ft-x"></i> Close', null, ['class' => 'btn-sm btn-warning mr-1' , 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('support-notes/index?sId=' . $model->supportId) . '", \'tab2\')']) ?>
	<?= (isset($rights->edit) && $rights->edit) ? Html::a('<i class="ft-edit"></i> Update', null, ['class' => 'btn-sm btn-primary', 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('support-notes/update?id=' . $model->supportNoteId . '&sId=' . $model->supportId) . '", \'tab2\')']) : '' ?>
	<?= (isset($rights->delete) && $rights->delete) ? Html::a('<i class="ft-trash"></i> Delete', null, [
			'class' => 'btn-sm btn-danger',
			'onclick' => 'deleteItem("' . Yii::$app->urlManager->createUrl('support-notes/delete?id=' . $model->supportNoteId . '&sId=' . $model->supportId) . '", \'tab2\')',
	]) : '' ?>
</p>

<h4 class="form-section">Notes Details</h4>

<?= DetailView::widget([
	'model' => $model,
	'attributes' => [
		'supportNoteId',
		'notes:ntext',
		[
			'attribute' => 'createdTime',
			'format' => ['date', 'php:d/m/Y h:i a'],
		],
		[
			'label' => 'Created By',
			'attribute' => 'users.fullName',
		],
	],
]) ?>

