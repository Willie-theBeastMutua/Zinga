<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UserGroups */

$this->title = 'Update User Groups: ' . $model->userGroupName;
$this->params['breadcrumbs'][] = ['label' => 'User Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->userGroupName, 'url' => ['view', 'id' => $model->userGroupId]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'lines' => $lines,
		'rights' => $rights,
	]) ?>

</section>
