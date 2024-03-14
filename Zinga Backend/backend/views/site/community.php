<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$baseUrl = Yii::$app->request->baseUrl;

$this->title = 'Community Blog';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class=" content-header row" style="padding-left: 15px; padding-right: 15px">
	<div class="col-xl-12 col-12">
		<div class="card">
				<div class="card-header">
					<h4 class="form-section"><?= $this->title; ?></h4>
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
					<div class="card-body">

					</div>
				</div>
		</div>
	</div>
</div>
