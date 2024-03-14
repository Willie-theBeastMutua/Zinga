<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Support */

$this->title = 'Create Support';
$this->params['breadcrumbs'][] = ['label' => 'Supports', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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
