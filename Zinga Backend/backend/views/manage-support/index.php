<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Manage Support Requests';
$this->params['breadcrumbs'][] = $this->title;
?>
<section id="configuration">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h4 class="form-section" style="margin-bottom: 0px"><?= $this->title; ?></h4>
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
					<div class="card-body card-dashboard">
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
								'fullName',
								[
									'attribute' => 'mobile',
									'format' => 'text',
									'headerOptions' => ['width' => '10%'],
								],
								[
									'label' => 'Subject',
									'attribute' => 'supportSubject.supportSubjectName',
									'format' => 'text',
									'headerOptions' => ['width' => '10%'],
								],
								[
									'label' => 'Status',
									'attribute' => 'supportStatus.supportStatusName',
									'format' => 'text',
									'headerOptions' => ['width' => '10%'],
								],
								[
									'attribute' => 'createdTime',
									'format' => ['date', 'php:d/m/Y h:i a'],
									'headerOptions' => ['width' => '15%'],
								],
								[
									'class' => 'yii\grid\ActionColumn',
									'headerOptions' => ['width' => '8%', 'style'=>'color:black; text-align:center'],
									'template' => '{view}',
									'buttons' => [

										'view' => function ($url, $model) use ($rights) {
											// print_r($model); exit;
											return (isset($rights->view) && $rights->view) ? Html::a('<i class="ft-eye"></i> View', ['view', 'id' => $model->supportId], ['class' => 'btn-sm btn-primary']) : '';
										},
									],
								],
							],
						]); ?>

					</div>
				</div>										  
			</div>
		</div>
	</div>
</section>
