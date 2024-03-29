<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SupportNotes */

$this->title = 'Update Support Notes: ' . $model->supportNoteId;
$this->params['breadcrumbs'][] = ['label' => 'Support Notes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->supportNoteId, 'url' => ['view', 'id' => $model->supportNoteId]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
	]) ?>

</section>
