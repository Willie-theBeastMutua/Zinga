<?php

namespace backend\controllers;

use Yii;
use app\models\Support;
use app\models\SupportStatus;
use app\models\SupportSubjects;
use app\models\Users;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use backend\controllers\RightsController;

/**
 * SupportController implements the CRUD actions for Support model.
 */
class SupportController extends Controller
{
	public $rights;
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		$this->rights = RightsController::Permissions(5);

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
		$rightsArray = array_unique($rightsArray);
		
		if (count($rightsArray) <= 0) {
			$rightsArray = ['none'];
		}
		
		return [
		'access' => [
			'class' => AccessControl::class,
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
				'class' => VerbFilter::class,
				'actions' => [
					'delete' => ['POST'],
				],
			],
		];
	}

	/**
	 * Lists all Support models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$dataProvider = new ActiveDataProvider([
			'query' => Support::find(),
			'pagination' => false,
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Displays a single Support model.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionView($id)
	{
		return $this->render('view', [
			'model' => $this->findModel($id),
			'rights' => $this->rights,
		]);
	}

	/**
	 * Creates a new Support model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new Support();
		$model->companyId = Yii::$app->user->identity->companyId;
		$model->supportStatusId = 1;

		if ($model->load(Yii::$app->request->post())) {
			if (!$model->save()) {
				// print_r($model->getErrors()); exit;
			}
			return $this->redirect(['view', 'id' => $model->supportId]);
		}

		$supportStatus = ArrayHelper::map(SupportStatus::find()->all(), 'supportStatusId', 'supportStatusName');
		$supportSubjects = ArrayHelper::map(SupportSubjects::find()->all(), 'supportSubjectId', 'supportSubjectName');
		$users = ArrayHelper::map(Users::find()->andWhere(['=', 'users.deleted', 0])->all(), 'userId', 'FullName');
		
		return $this->render('create', [
			'model' => $model,
			'rights' => $this->rights,
			'supportStatus' => $supportStatus,
			'supportSubjects' => $supportSubjects,
			'users' => $users,
		]);
	}

	/**
	 * Updates an existing Support model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->supportId]);
		}

		$supportStatus = ArrayHelper::map(SupportStatus::find()->all(), 'supportStatusId', 'supportStatusName');
		$supportSubjects = ArrayHelper::map(SupportSubjects::find()->all(), 'supportSubjectId', 'supportSubjectName');
		$users = ArrayHelper::map(Users::find()->andWhere(['=', 'users.deleted', 0])->all(), 'userId', 'FullName');

		return $this->render('update', [
			'model' => $model,
			'rights' => $this->rights,
			'supportStatus' => $supportStatus,
			'supportSubjects' => $supportSubjects,
			'users' => $users,
		]);
	}

	/**
	 * Deletes an existing Support model.
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
	 * Finds the Support model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Support the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Support::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
}
