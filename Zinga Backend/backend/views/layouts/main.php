<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use yii\helpers\ArrayHelper;

use backend\controllers\RightsController;

$baseUrl = Yii::$app->request->baseUrl;

$rights = (array) RightsController::Permissions(0);

if (!empty($rights)) {
	foreach ($rights as $key => $right) {
		if (!isset($right['view']) || $right['view'] != 1) {
			unset($rights[$key]);
		}
	}
}
$rights = ArrayHelper::getColumn($rights, 'pageId');

AppAsset::register($this);
$currentRoute = trim(Yii::$app->controller->module->requestedRoute);
// echo $currentRoute; exit;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->
<html lang="<?= Yii::$app->language ?>">
<head>
<meta charset="<?= Yii::$app->charset ?>">
	<?php $this->registerCsrfMetaTags() ?>
	<?= Html::csrfMetaTags() ?>
	
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<meta name="description" content="ESI Site Visit Tool">
	<meta name="keywords" content="ESI Site Visit Tool">
	<meta name="author" content="Health Strat">
	<title><?= Html::encode($this->title) ?></title>
	<link rel="apple-touch-icon" href="<?= $baseUrl; ?>/app-assets/images/ico/apple-icon-120.png">
	<link rel="shortcut icon" type="image/x-icon" href="<?= $baseUrl; ?>/app-assets/images/ico/favicon.ico">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i%7CQuicksand:300,400,500,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

	<?php $this->head() ?>
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->
<?php
if (Yii::$app->user->isGuest) { ?>
	<body class="vertical-layout vertical-menu-modern material-vertical-layout material-layout 1-column blank-page" data-open="click" data-menu="vertical-menu-modern" data-col="1-column">
	<?php
} else { ?>
<body class="vertical-layout vertical-menu-modern material-vertical-layout material-layout 2-columns   fixed-navbar" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
<?php } ?>
	<?php $this->beginBody() ?>
	<!-- BEGIN: Header-->
	<?php // (!Yii::$app->user->isGuest) ? $this->render('header', ['rights' => $rights]) : ''; ?>
	<?php 
		// echo (!Yii::$app->user->isGuest) ? $this->render('header', ['rights' => $rights]) : $this->render('top-menu', ['rights' => $rights]);
		echo (!Yii::$app->user->isGuest) ? $this->render('header', ['rights' => $rights]) : '';
	?>
	<!-- END: Header-->

	<!-- BEGIN: Main Menu-->
	<?= (!Yii::$app->user->isGuest) ? $this->render('menu', ['rights' => $rights]) : ''; ?>
	<!-- END: Main Menu-->

	<!-- BEGIN: Content-->
	<div class="app-content content">
		<div class="content-header row">
		</div>
		<div class="content-wrapper">
			<div class="content-body">
				<?= (Yii::$app->user->isGuest) ? '<div style=" padding-top: 20px; "> </div>' : ''; ?>
				<?php if (Yii::$app->session->hasFlash('success')): ?>
					<div class="alert alert-success alert-dismissable">
							<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
							<!-- <h4><i class="icon fa fa-check"></i>Saved!</h4> -->
							<?= Yii::$app->session->getFlash('success') ?>
					</div>
				<?php endif; ?>

				<?php if (Yii::$app->session->hasFlash('error')): ?>
					<div class="alert alert-danger alert-dismissable">
							<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
							<!-- <h4><i class="icon fa fa-check"></i>Saved!</h4> -->
							<?= Yii::$app->session->getFlash('error') ?>
					</div>
				<?php endif; ?>
				
				<?= $content ?>
		
			</div>
		</div>
	</div>
	<!-- END: Content-->

	<div class="sidenav-overlay"></div>
	<div class="drag-target"></div>

	<!-- BEGIN: Footer-->
	<?php // (!Yii::$app->user->isGuest) ? $this->render('footer') : ''; ?>
	<?=  $this->render('footer'); ?>
	<!-- END: Footer-->
	<?php $this->endBody() ?>
</body>
<!-- END: Body-->

</html>
<?php $this->endPage() ?>
