<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Support Notes';
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
</style>
<h4 class="form-section">Notes</h4>
<p>
	<?= (isset($rights->create)  && $rights->create) ? Html::a('<i class="ft-plus"></i> New', null, ['class' => 'btn-sm btn-primary mr-1', 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('support-notes/create?sId=' . $sId) . '", \'tab2\')']) : '' ?>	
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
		'notes:ntext',
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
					return (isset($rights->edit) && $rights->edit) ? Html::a('<i class="ft-eye"></i> View', null, ['class' => 'btn-sm btn-primary', 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('support-notes/view?id=' . $model->supportNoteId) . '", \'tab2\')']) : '';
				},
				'delete' => function ($url, $model) use ($rights) {
					return (isset($rights->delete) && $rights->delete) ? Html::a('<i class="ft-trash"></i> Delete', null, [
						'class' => 'btn-sm btn-danger btn-xs',
						'onclick' => 'deleteItem("' . Yii::$app->urlManager->createUrl('support-notes/delete?id=' . $model->supportNoteId) . '", \'tab2\')',
					]) : '';
				},
			],
		],
	],
]); ?>
