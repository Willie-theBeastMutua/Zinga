<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Modal;

$baseUrl = Yii::$app->request->baseUrl;

/* @var $this yii\web\View */
/* @var $model app\models\Support */

$this->title = $model->fullName;
$this->params['breadcrumbs'][] = ['label' => 'Supports', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

Modal::begin([
	'header' => '<h4 class="modal-title">Image</h4>',
	// 'footer' => Html::submitButton(Yii::t('app', 'Save')),
	'id' => 'image-gallery',
	'size' => 'modal-lg',
	]);

Modal::end();
?>
<style>
.modal-header .close {
  /* display:none; */
  color: black !important;
}

.modal-header {
	display: block !important;
}
</style>
<script src="<?= $baseUrl; ?>/app-assets/js/jquery.min.js"></script>
<script>
$(document).ready(function() {
	console.log(1);
	$("#image-gallery").on("show.bs.modal", function(e) {
			var image = $(e.relatedTarget).data('image');
			var title = $(e.relatedTarget).data('title');
			$(".modal-body").html('<img src="'+ image +'" width=100%" height="auto">');
			$(".modal-header").html('<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h4 class="modal-title">' + title + '</h4>');
		});
});
</script>
<section id="configuration">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h4 class="form-section" style="margin-bottom: 0px"><?= $this->title; ?></h4>
					
					<a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
					<div class="heading-elements">
						<ul class="list-inline mb-0">
							<li><a data-action="collapse"><i class="ft-minus"></i></a></li>
							<li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
							<li><a data-action="expand"><i class="ft-maximize"></i></a></li>
							<!-- <li><a data-action="close"><i class="ft-x"></i></a></li> -->
						</ul>
					</div>
				</div>
				<div class="card-content collapse show">
					<div class="card-body">	

						<p>
							<?= Html::a('<i class="ft-x"></i> Close', ['index'], ['class' => 'btn btn-warning mr-1']) ?>
							<?= (isset($rights->edit) && $rights->edit && $model->supportStatusId != 5) ? Html::a('<i class="ft-stop-circle"></i> Close Request', ['close', 'id' => $model->supportId], [
									'class' => 'btn btn-danger',
									'data' => [
										'confirm' => 'Are you sure you want to Close this request?',
										'method' => 'post',
									],
							]) : '' ?>
						</p>

						<?= DetailView::widget([
							'model' => $model,
                            'options' => [
								'class' => 'custom-table table-striped table-bordered zero-configuration',
							],
							'attributes' => [
								'supportId',
								'fullName',
								'mobile',
								'email:email',
								'supportSubject.supportSubjectName',
								'description:ntext',
								'supportStatus.supportStatusName',
								'resolution:ntext',
								[
									'format' => ['date', 'php:d/m/Y'],
									'attribute' => 'dateClosed',
								],
								[
									'label' => 'Closed By',
									'attribute' => 'closingUser.FullName',
								],
								[
									'label' => 'Created By',
									'attribute' => 'user.fullName',
								],
								[
									'attribute' => 'createdTime',
									'format' => ['date', 'php:d/m/Y h:i a'],
								],
								[
									'label' => 'Created By',
									'attribute' => 'user.fullName',
								],
							],
						]) ?>
						<h4 class="form-section">Notes</h4>
						<?= $this->render('notes', ['dataProvider' => $notesProvider, 'rights' => $rights]); ?>

						<h4 class="form-section">Attachments</h4>
						<?= $this->render('attachments', ['dataProvider' => $attachementsProvider, 'rights' => $rights]); ?>
					</div>
				</div>
			</div>																			
		</div>
	</div>
</section>
