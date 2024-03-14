<?php

namespace backend\controllers;

use Yii;
use app\models\Users;
use app\models\UserGroups;
use app\models\UserStatus;
use app\models\UserTypes;
use app\models\Communities;
use app\models\Partners;
use app\models\MessageTemplates;
use app\models\UserGroupRights;
use app\models\PermissionForm;
use app\models\UserGroupMembers;
use app\models\ChangePassword;
use app\models\Templates;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use backend\controllers\RightsController;

include_once 'includes/mailsender.php';

/**
 * UsersController implements the CRUD actions for Users model.
 */
class UsersController extends Controller
{
	public $rights;
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		$this->rights = RightsController::Permissions(1);
		// print_r($this->rights); exit;

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
	 * Lists all Users models.
	 * @return mixed
	 */
	public function actionIndex()
	{

		$dataProvider = new ActiveDataProvider([
			'query' => $dataProvider = Users::find()->andWhere(['=', 'deleted', 0]),
            'pagination' => false,
		]);
		
		return $this->render('index', [
			'dataProvider' => $dataProvider,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Displays a single Users model.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionView($id)
	{
		$permissionForm = new PermissionForm();
		$permissionForm->userId = $id;
		$activeTab = 1;

		if (Yii::$app->request->post()) {
			$activeTab = 2;
		}

		if ($permissionForm->load(Yii::$app->request->post()) && $permissionForm->validate()) {
			$params = Yii::$app->request->post();
			$userGroupId = $params['PermissionForm']['userGroupId'];
			$permission = UserGroupMembers::findOne(['userGroupId' => $userGroupId, 'userId' => $id]);

			if (!$permission) {
				$perm = new UserGroupMembers();
				$perm->userGroupId = $userGroupId;
				$perm->userId = $id;
				$perm->createdBy = Yii::$app->user->identity->userId;
				$perm->save();
			}
			$activeTab = 2;
		}

		$dataProvider = new ActiveDataProvider([
			'query' => $dataProvider = UserGroupMembers::find()->where(['userId' => $id]),
		]);
		
		$userGroups = ArrayHelper::map(UserGroups::find()->all(), 'userGroupId', 'userGroupName');

		return $this->render('view', [
			'model' => $this->findModel($id),
			'dataProvider' => $dataProvider,
			'permissionForm' => $permissionForm,
			'userGroups' => $userGroups,
			'activeTab' => $activeTab,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Creates a new Users model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new Users();
		
		if (Yii::$app->request->post()) {
			$password =  Yii::$app->request->post()['Users']['password'];
			$model->authKey = \Yii::$app->security->generateRandomString();
			$model->passwordHash = \Yii::$app->security->generatePasswordHash($password);
		}

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['index']);
		}
        
		$userStatus = ArrayHelper::map(UserStatus::find()->all(), 'userStatusId', 'userStatusName');

		return $this->render('create', [
			'model' => $model,
			'userStatus' => $userStatus,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Updates an existing Users model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['index']);
		}
		$userStatus = ArrayHelper::map(UserStatus::find()->all(), 'userStatusId', 'userStatusName');

		return $this->render('update', [
			'model' => $model,
			'userStatus' => $userStatus,
			'rights' => $this->rights,
		]);
	}
	
	public function actionChangePassword($id)
	{
		$user = Users::findOne($id);
		$model = new ChangePassword();
		$model->userId = $id;
		$model->FullName = $user->firstName . ' ' . $user->lastName;

		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			$profile = Users::findOne($id);
			$profile->passwordHash = Yii::$app->security->generatePasswordHash($model->Password);
			$profile->authKey = Yii::$app->security->generateRandomString();
			// $profile->Password = '0';
			// $profile->Password = $model->Password;
			// $profile->ConfirmPassword = $model->ConfirmPassword;
			if ($profile->save()) {
				Yii::$app->session->setFlash('success', 'Password changed successfully.');
				return $this->redirect(['index']);
			} else {
				// print_r($profile->getErrors()); exit;
				Yii::$app->session->setFlash('error', 'Failed to change password.');
			}
		}

		return $this->render('change-password', [
			'model' => $model,
		]);
	}

	/**
	 * Deletes an existing Users model.
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

    public function actionRemoveGroup($id) 
    {
        $model = UserGroupMembers::findOne($id);
        if ($model) {
            if ($model->delete()) {
                return $this->redirect(['view', 'id' =>$model->userId]);
            }
        } else {
            return $this->redirect(['index']);
        }
    }

	/**
	 * Finds the Users model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Users the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Users::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}

	public static function sendEmailNotification($FormID)
	{
		$Code = '';
		
		switch ($FormID) {
			case 26: // Quotations Approval
				$Code = '001';
				break;
			case 13: // Purchases Approval
				$Code = '002';
				break;
			case 12: // Requisition Approval
				$Code = '003';
				break;
			case 14: // Stock Take Approval
				$Code = '004';
				break;
			case 29: // Quotation Review
				$Code = '005';
				break;
			case 28: // Purchase Review
				$Code = '006';
				break;
			case 27: // Requisition Review
				$Code = '007';
				break;
			case 30: // Stock Take Review
				$Code = '008';
				break;
		}
		
		$template = Templates::findone(['Code' => $Code]);
		
		$sql = "SELECT users.userId, users.FirstName, users.LastName, users.Email FROM usergrouprights 
				JOIN users ON users.userGroupId = usergrouprights.userGroupId
				WHERE PageID = :FormID AND Edit = 1";
		
		$users = UserGroupRights::findBySql($sql, [':FormID' => $FormID])->asArray()->all();
		$EmailArray = [];
		foreach ($users as $user) {
			$EmailArray[] = ['Email' => $user['Email'], 'Name'=> $user['FirstName'] . ' ' . $user['LastName']];
		}
		//print_r($EmailArray);
		if (!empty($template)) {
			$subject = $template->Subject;
			$message = $template->Message;
		}

		if (count($EmailArray)!=0) {
			$sent = SendMail($EmailArray, $subject, $message, null);
			if ($sent==1) {
				return 'Saved Details Successfully';
			} else {
				return 'Failed to send Mail';
			}
		} else {
			return 'No Email address';
		}
	}
	
	public function actionTestemail()
	{
		$sent = SendMail('ngugi.joseph@gmail.com', 'Test Email', 'Test Email', null);
		if ($sent==1) {
			return 'Saved Details Successfully';
		} else {
			return 'Failed to send Mail';
		}
	}
}
