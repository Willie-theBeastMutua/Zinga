<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SupportSubjects */

$this->title = 'Update Support Subjects: ' . $model->supportSubjectName;
$this->params['breadcrumbs'][] = ['label' => 'Support Subjects', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->supportSubjectName, 'url' => ['view', 'id' => $model->supportSubjectId]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
	]) ?>

</section>
