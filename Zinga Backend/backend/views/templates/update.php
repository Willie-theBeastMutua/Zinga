<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MessageTemplates */

$this->title = 'Update Template: ' . $model->templateId;
$this->params['breadcrumbs'][] = ['label' => 'Message Templates', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->templateId, 'url' => ['view', 'id' => $model->templateId]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
	]) ?>

</section>
