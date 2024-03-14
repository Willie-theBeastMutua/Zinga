<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SupportAttachments */

$this->title = 'Create Support Attachments';
$this->params['breadcrumbs'][] = ['label' => 'Support Attachments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
	]) ?>

</section>
