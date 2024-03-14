<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Pages */

$this->title = 'Create Pages';
$this->params['breadcrumbs'][] = ['label' => 'Pages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<section class="flexbox-container">

    <?= $this->render('_form', [
        'model' => $model,
        'rights' => $rights,
        'users' => $users,

    ]) ?>

</section>
