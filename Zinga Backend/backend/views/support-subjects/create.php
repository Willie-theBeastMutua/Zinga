<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SupportSubjects */

$this->title = 'Create Support Subjects';
$this->params['breadcrumbs'][] = ['label' => 'Support Subjects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
	]) ?>

</section>
