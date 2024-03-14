<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SupportStatus */

$this->title = 'Update Support Status: ' . $model->supportStatusName;
$this->params['breadcrumbs'][] = ['label' => 'Support Statuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->supportStatusName, 'url' => ['view', 'id' => $model->supportStatusId]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
	]) ?>

</section>
