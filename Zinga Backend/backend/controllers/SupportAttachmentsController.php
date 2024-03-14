<?php

namespace backend\controllers;

use Yii;
use app\models\SupportAttachments;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use backend\controllers\RightsController;

/**
 * SupportAttachmentsController implements the CRUD actions for SupportAttachments model.
 */
class SupportAttachmentsController extends Controller
{
	public $rights;
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		$this->rights = RightsController::Permissions(35);

		$rightsArray = [];
		if (isset($this->rights->view)) {
			array_push($rightsArray, 'index', 'view');
		}
		if (isset($this->rights->create)) {
			array_push($rightsArray, 'view', 'create');
		}
		if (isset($this->rights->edit)) {
			array_push($rightsArray, 'index', 'view', 'update');
		}
		if (isset($this->rights->delete)) {
			array_push($rightsArray, 'delete');
		}
		array_push($rightsArray, 'plots');

		$rightsArray = array_unique($rightsArray);
		
		if (count($rightsArray) <= 0) {
			$rightsArray = ['none'];
		}
		
		return [
		'access' => [
			'class' => AccessControl::className(),
			'only' => ['index', 'view', 'create', 'update', 'delete'],
			'rules' => [
					// Guest Users
					[
						'allow' => true,
						'actions' => ['none'],
						'roles' => ['?'],
					],
					// Authenticated Users
					[
						'allow' => true,
						'actions' => $rightsArray, //['index', 'view', 'create', 'update', 'delete'],
						'roles' => ['@'],
					],
				],
			],
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['POST', 'get'],
				],
			],
		];
	}

	/**
	 * Lists all SupportAttachments models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$sId = isset(Yii::$app->request->get()['sId']) ? Yii::$app->request->get()['sId'] : 0;

		$dataProvider = new ActiveDataProvider([
			'query' => SupportAttachments::find(),
		]);

		return $this->renderPartial('index', [
			'dataProvider' => $dataProvider,
			'rights' => $this->rights,
			'sId' => $sId,
		]);
	}

	/**
	 * Displays a single SupportAttachments model.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionView($id)
	{
		return $this->renderPartial('view', [
			'model' => $this->findModel($id),
			'rights' => $this->rights,
		]);
	}

	/**
	 * Creates a new SupportAttachments model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$sId = isset(Yii::$app->request->get()['sId']) ? Yii::$app->request->get()['sId'] : 0;

		$model = new SupportAttachments();
		$model->createdBy = Yii::$app->user->identity->userId;
		$model->supportId = $sId;

		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			$model->imageFile = UploadedFile::getInstance($model, 'imageFile');
			if ($model->imageFile) {
				$model->image = $model->formatImage();
				if ($model->save()) {
					return $this->redirect(['view', 'id' => $model->attachmentId]);
				}
			} else {
				$model->addError('imageFile', 'Please select File');
			}
		}

		return $this->renderPartial('create', [
			'model' => $model,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Updates an existing SupportAttachments model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			$model->imageFile = UploadedFile::getInstance($model, 'imageFile');
			if ($model->imageFile) {
				$model->image = $model->formatImage();
				if ($model->save()) {
					return $this->redirect(['view', 'id' => $model->attachmentId]);
				}
			} else {
				if ($model->save()) {
					return $this->redirect(['view', 'id' => $model->attachmentId]);
				}
			}
		}

		return $this->renderPartial('update', [
			'model' => $model,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Deletes an existing SupportAttachments model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionDelete($id)
	{
		$this->findModel($id)->delete();

		return $this->redirect(['index']);
	}

	/**
	 * Finds the SupportAttachments model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return SupportAttachments the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = SupportAttachments::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
}
