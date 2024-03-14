<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UserStatus */

$this->title = 'Update User Status: ' . $model->userStatusName;
$this->params['breadcrumbs'][] = ['label' => 'User Statuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->userStatusName, 'url' => ['view', 'id' => $model->userStatusId]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
	]) ?>

</section>
