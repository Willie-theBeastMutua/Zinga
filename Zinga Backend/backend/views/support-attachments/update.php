<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SupportAttachments */

$this->title = 'Update Support Attachments: ' . $model->attachmentId;
$this->params['breadcrumbs'][] = ['label' => 'Support Attachments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->attachmentId, 'url' => ['view', 'id' => $model->attachmentId]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
	]) ?>

</section>