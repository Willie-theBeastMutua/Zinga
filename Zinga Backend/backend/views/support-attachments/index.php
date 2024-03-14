<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Support Attachments';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
.btn-primary {
	border-color: #512E90 !important;
	background-color: #6BA342 !important;
	color: #FFFFFF !important;
}

.btn-danger {
	color: #FFFFFF !important;
}

.modal-header .close {
  /* display:none; */
  color: black !important;
}

.modal-header {
	display: block !important;
}
</style>
<h4 class="form-section">Attachments</h4>
<p>
	<?= (isset($rights->create)  && $rights->create) ? Html::a('<i class="ft-plus"></i> New', null, ['class' => 'btn-sm btn-primary mr-1', 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('support-attachments/create?sId=' . $sId) . '", \'tab3\')']) : '' ?>	
</p>

<?= GridView::widget([
	'dataProvider' => $dataProvider,
	'layout' => '{items}',
	'tableOptions' => [
		'class' => 'custom-table table-striped table-bordered zero-configuration',
	],
	'columns' => [
		[
			'class' => 'yii\grid\SerialColumn',
			'headerOptions' => ['width' => '5%'],
		],
		[
			'attribute' => 'image',
			'label' => 'Image',
			'format' => 'raw',
			'value' => function ($data) {
				return '<a href="#image-gallery" data-toggle="modal" data-image="' . $data['image'] . '" data-title="' . $data['caption'] . '"><img src="' . $data['image'] . '" height="60" width="auto"></a>';
			},
			'headerOptions' => ['width' => '10%'],
		],
		'caption',
		[
			'attribute' => 'createdTime',
			'format' => ['date', 'php:d/m/Y h:i a'],
			'headerOptions' => ['width' => '15%'],
		],
		[
			'label' => 'Created By',
			'attribute' => 'users.fullName',
			'headerOptions' => ['width' => '15%'],
		],
		[
			'class' => 'yii\grid\ActionColumn',
			'headerOptions' => ['width' => '13%', 'style'=>'color:black; text-align:center'],
			'template' => '{view} {delete}',
			'buttons' => [

				'view' => function ($url, $model) use ($rights) {
					return (isset($rights->edit) && $rights->edit) ? Html::a('<i class="ft-eye"></i> View', null, ['class' => 'btn-sm btn-primary', 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('support-attachments/view?id=' . $model->attachmentId) . '", \'tab3\')']) : '';
				},
				'delete' => function ($url, $model) use ($rights) {
					return (isset($rights->delete) && $rights->delete) ? Html::a('<i class="ft-trash"></i> Delete', null, [
						'class' => 'btn-sm btn-danger btn-xs',
						'onclick' => 'deleteItem("' . Yii::$app->urlManager->createUrl('support-attachments/delete?id=' . $model->attachmentId) . '", \'tab3\')',
					]) : '';
				},
			],
		],
	],
]); ?>
