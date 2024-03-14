<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SupportNotes */

$this->title = 'Create Support Notes';
$this->params['breadcrumbs'][] = ['label' => 'Support Notes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
	]) ?>

</section>