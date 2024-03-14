<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Support Notes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="support-notes-index">

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
		],
	]); ?>


</div>
