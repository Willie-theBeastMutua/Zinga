<?php

namespace backend\controllers;

use Yii;
use app\models\UserGroups;
use app\models\UserGroupRights;
use app\models\Pages;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\controllers\RightsController;

/**
 * UsergroupsController implements the CRUD actions for UserGroups model.
 */
class UserGroupsController extends Controller
{
	public $rights;
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		$this->rights = RightsController::Permissions(2);

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
	 * Lists all UserGroups models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$dataProvider = new ActiveDataProvider([
			'query' => UserGroups::find(),
			'pagination' => false,
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Displays a single UserGroups model.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionView($id)
	{
		$dataProvider = new ActiveDataProvider([
			'query' => UserGroupRights::find()->where(['userGroupId'=> $id]),
			'pagination' => false,
		]);

		return $this->render('view', [
			'model' => $this->findModel($id),
			'dataProvider' => $dataProvider,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Creates a new UserGroups model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new UserGroups();
		$model->createdBy = Yii::$app->user->identity->userId;

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$params = Yii::$app->request->post();
			// print_r($params); exit;
			$lines = isset($params['UserGroupRights']) ? $params['UserGroupRights'] : [];
			
			foreach ($lines as $key => $line) {
				$_line = new UserGroupRights();
				$_line->userGroupId = $model->userGroupId;
				$_line->pageId = $line['pageId'];
				$_line->view = $line['view'];
				$_line->edit = $line['edit'];
				$_line->create = $line['create'];
				$_line->delete = $line['delete'];
				// $_line->createdTime = time();
				$_line->createdBy = Yii::$app->user->identity->userId;
				$_line->save();
			}
			return $this->redirect(['view', 'id' => $model->userGroupId]);
		}

		$data = UserGroupRights::find()
					->rightJoin('pages', 'user_group_rights.pageId=pages.pageId AND userGroupId = 0')
					->select('pageName, pages.pageId as pId, user_group_rights.*')
					->asArray()
					->all();
		/* print('<pre>');
		print_r($data); exit; */
		$lines = [];
		for ($x = 0; $x < count($data); $x++) {
			$_line = new UserGroupRights();
			$_line->pageId = $data[$x]['pId'];
			$_line->pageName = $data[$x]['pageName'];
			$_line->view = $data[$x]['view'];
			$_line->create = $data[$x]['create'];
			$_line->edit = $data[$x]['edit'];
			$_line->delete = $data[$x]['delete'];
			$_line->userGroupRightId = $data[$x]['userGroupRightId'];
			$lines[$x] = $_line;
		}

		return $this->render('create', [
			'model' => $model,
			'lines' => $lines,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Updates an existing UserGroups model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$params = Yii::$app->request->post();
			$lines = $params['UserGroupRights'];
			
			foreach ($lines as $key => $line) {
				if ($line['userGroupRightId'] == '') {
					$_line = new UserGroupRights();
					$_line->userGroupId = $id;
					$_line->pageId = $line['pageId'];
					$_line->view = $line['view'];
					$_line->edit = $line['edit'];
					$_line->create = $line['create'];
					$_line->delete = $line['delete'];
					$_line->save();
				} else {
					$_line = UserGroupRights::findOne($line['userGroupRightId']);
					$_line->view = $line['view'];
					$_line->edit = $line['edit'];
					$_line->create = $line['create'];
					$_line->delete = $line['delete'];
					if (!$_line->save()) {
						// print_r($_line->getErrors()); exit;
					}
				}
			}
			return $this->redirect(['view', 'id' => $model->userGroupId]);
		}

		$groupRights = UserGroupRights::find()
							->rightJoin('pages', 'user_group_rights.pageId=pages.pageId and userGroupId = ' . $id)
							->select('user_group_rights.*, pageName, pages.pageId as pId')
							// ->having(['userGroupId' => $id])
							->asArray()
							->all();
		$lines = [];
		foreach ($groupRights as $x => $data) {
			$_line = new UserGroupRights();
			$_line->pageId = $data['pId'];
			$_line->pageName = $data['pageName'];
			$_line->view = $data['view'];
			$_line->create = $data['create'];
			$_line->edit = $data['edit'];
			$_line->delete = $data['delete'];
			$_line->userGroupRightId = $data['userGroupRightId'];
			$lines[$x] = $_line;
		}
/* 		print('<pre>');
		print_r($lines); exit; */

		return $this->render('update', [
			'model' => $model,
			'lines' => $lines,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Deletes an existing UserGroups model.
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
	 * Finds the UserGroups model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return UserGroups the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = UserGroups::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
}
