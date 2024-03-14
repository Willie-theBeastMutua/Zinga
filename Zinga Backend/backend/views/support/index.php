<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Supports';
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
						<div class="form-actions" style="margin-top:0px">
							<?= (isset($rights->create)  && $rights->create) ? Html::a('<i class="ft-plus"></i> Add', ['create'], ['class' => 'btn btn-primary mr-1']) : '' ?>	
						</div>
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
									'attribute' => 'supportSubject.supportSubjectName',
									'format' => 'text',
									'headerOptions' => ['width' => '10%'],
								],
								[
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
									'headerOptions' => ['width' => '13%', 'style'=>'color:black; text-align:center'],
									'template' => '{view} {delete}',
									'buttons' => [

										'view' => function ($url, $model) use ($rights) {
											// print_r($model); exit;
											return (isset($rights->view) && $rights->view) ? Html::a('<i class="ft-eye"></i> View', ['view', 'id' => $model->supportId], ['class' => 'btn-sm btn-primary']) : '';
										},
										'delete' => function ($url, $model) use ($rights) {
											return (isset($rights->delete) && $rights->delete) ? Html::a('<i class="ft-trash"></i> Delete', ['delete', 'id' => $model->supportId], [
												'class' => 'btn-sm btn-danger btn-xs',
												'data' => [
													'confirm' => 'Are you absolutely sure ? You will lose all the information with this action.',
													'method' => 'post',
												],
											]) : '';
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
