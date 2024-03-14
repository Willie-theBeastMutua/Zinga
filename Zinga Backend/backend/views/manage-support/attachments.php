<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Support Attachments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="support-attachments-index">
	
	<p>
		<?= (isset($rights->create)  && $rights->create) ? Html::a('<i class="ft-plus"></i> New', ['create'], ['class' => 'btn btn-primary mr-1']) : '' ?>	
	</p>

	<?= GridView::widget([
		'dataProvider' => $dataProvider,
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
		],
	]); ?>


</div>
