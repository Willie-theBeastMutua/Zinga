<?php

namespace backend\controllers;

use Yii;
use app\models\Templates;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use backend\controllers\RightsController;

/**
* TemplatesController implements the CRUD actions for Templates model.
*/
class TemplatesController extends Controller
{
	public $rights;
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		$this->rights = RightsController::Permissions(8);

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
					'delete' => ['POST'],
				],
			],
		];
	}

	/**
	* Lists all Templates models.
	* @return mixed
	*/
	public function actionIndex()
	{
		$dataProvider = new ActiveDataProvider([
			'query' => Templates::find(),
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
			'rights' => $this->rights,
		]);
	}

	/**
	* Displays a single Templates model.
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
	* Creates a new Templates model.
	* If creation is successful, the browser will be redirected to the 'view' page.
	* @return mixed
	*/
	public function actionCreate()
	{
		$model = new Templates();

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->templateId]);
		}

		return $this->render('create', [
			'model' => $model,
			'rights' => $this->rights,
		]);
	}

	/**
	* Updates an existing Templates model.
	* If update is successful, the browser will be redirected to the 'view' page.
	* @param integer $id
	* @return mixed
	* @throws NotFoundHttpException if the model cannot be found
	*/
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->templateId]);
		}

		return $this->render('update', [
			'model' => $model,
			'rights' => $this->rights,
		]);
	}

	/**
	* Deletes an existing Templates model.
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
	* Finds the Templates model based on its primary key value.
	* If the model is not found, a 404 HTTP exception will be thrown.
	* @param integer $id
	* @return Templates the loaded model
	* @throws NotFoundHttpException if the model cannot be found
	*/
	protected function findModel($id)
	{
		if (($model = Templates::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
}
