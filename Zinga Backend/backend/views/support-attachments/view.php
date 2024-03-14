<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\SupportAttachments */

$this->title = $model->attachmentId;
$this->params['breadcrumbs'][] = ['label' => 'Support Attachments', 'url' => ['index']];
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
	<?= Html::a('<i class="ft-x"></i> Close', null, ['class' => 'btn-sm btn-warning mr-1' , 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('support-attachments/index?sId=' . $model->supportId) . '", \'tab3\')']) ?>
	<?= (isset($rights->edit) && $rights->edit) ? Html::a('<i class="ft-edit"></i> Update', null, ['class' => 'btn-sm btn-primary', 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('support-attachments/update?id=' . $model->attachmentId . '&sId=' . $model->supportId) . '", \'tab3\')']) : '' ?>
	<?= (isset($rights->delete) && $rights->delete) ? Html::a('<i class="ft-trash"></i> Delete', null, [
			'class' => 'btn-sm btn-danger',
			'onclick' => 'deleteItem("' . Yii::$app->urlManager->createUrl('support-attachments/delete?id=' . $model->attachmentId . '&sId=' . $model->supportId) . '", \'tab3\')',
	]) : '' ?>
</p>

<h4 class="form-section">Attachment Details</h4>

<?= DetailView::widget([
	'model' => $model,
	'attributes' => [
		'attachmentId',
		'caption',
		[
			'attribute' => 'image',
			'label' => 'Image',
			'format' => 'raw',
			'value' => function ($data) {
				return '<a href="#image-gallery" data-toggle="modal" data-image="' . $data['image'] . '" data-title="' . $data['caption'] . '"><img src="' . $data['image'] . '" height="200" width="auto"></a>';
			},
		],
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
