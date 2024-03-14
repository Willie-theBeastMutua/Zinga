<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Support */

$this->title = 'Update Support: ' . $model->fullName;
$this->params['breadcrumbs'][] = ['label' => 'Supports', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->fullName, 'url' => ['view', 'id' => $model->supportId]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
		'supportStatus' => $supportStatus,
		'supportSubjects' => $supportSubjects,
		'users' => $users,
	]) ?>

</section>
