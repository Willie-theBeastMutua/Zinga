<?php

/**
 * Created by gii.
 * User: Joseph
 * Date: 2020/12/21
 * Time: 16:30
 */

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;

use Yii;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;

class AuthController extends ActiveController
{
	public $modelClass = 'app\models\Users';

	public function behaviors()
	{
		$behaviors = parent::behaviors();

		// remove auth filter
		unset($behaviors['authenticator']);
		$behaviors['corsFilter'] = [
			'class' => \yii\filters\Cors::className(),
			'cors' => [

				'Origin' => Yii::$app->params['cors-origin'],

				'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
				'Access-Control-Request-Headers' => ['*'],
				'Access-Control-Allow-Credentials' => true,
				'Access-Control-Max-Age' => 86400,
			],
		];

		$behaviors['authenticator'] = [
			'class' => HttpBearerAuth::className(),
		]; 

		return $behaviors;
	}

	protected function verbs()
	{
		return [
			'verbs' => [
				'class' => \yii\filters\VerbFilter::className(),
				'actions' => [
					'index'  => ['get'],
					'view'   => ['get'],
					'create' => ['get', 'post'],
					'update' => ['get', 'put', 'post'],
					'delete' => ['post', 'delete'],
				],
			],
		];
	}

	public function actions()
	{
		$actions = parent::actions();
		unset($actions['index']);
		unset($actions['view']);
		unset($actions['create']);
		unset($actions['update']);
		unset($actions['delete']);
		return $actions;
	}

	public function actionLogin()
	{
		$params = Yii::$app->request->post();
		// return $params; exit;
		// Validation of Fields
		$requiredFields = ['mobile', 'password'];

		$missing = [];
		foreach ($requiredFields as $key => $value) {
			if (!array_key_exists($value, $params)) {
				$missing[] = $value;
			}
		}

		if (!empty($missing)) {
			throw new \yii\web\HttpException(400, 'missing attributes:' . implode(',', $missing));
		}

		$model = $this->modelClass;
		$model = $model::find()->andWhere(['=', 'users.deleted', 0])
			->andWhere(['mobile' => $params['mobile']])
			->andWhere(['in', 'userStatusId', [1]])
			->one();

		if (empty($model)) {
			throw new \yii\web\HttpException(400, 'Invalid Mobile or Password');
		}
		$password = (string) $params['password'];
		if (Yii::$app->security->validatePassword($password, $model->passwordHash)) {
			$model->authToken = \Yii::$app->security->generateRandomString();
			$model->tokenExpiry = date('Y-m-d H:i:s', time() + 3600);
			$model->save();
			return ['data' => $model, 'token' => $model->authToken, 'tokenExpiry' => $model->tokenExpiry];
		} else {
			throw new \yii\web\HttpException(400, 'Invalid Credentials');
		}
	}

	public function actionRegister()
	{
		$model = new \app\models\RegisterForm();
		if (Yii::$app->request->isPost) {
			if ($model->load(['RegisterForm' => Yii::$app->request->post()]) && $model->validate()) {
				return $model->register();
			} else {
				return $model->getErrors();
				throw new \yii\web\HttpException(400, 'error saving data');
			}
		} else {
			throw new \yii\web\HttpException(400, 'get is not permitted');
		}
	}

	public function actionDetails()
	{
		$params = Yii::$app->request->post();

		// Validation of Fields
		$missing = self::validateFields($params, ['mobile']);

		if (!empty($missing)) {
			throw new \yii\web\HttpException(400, 'missing attributes:' . implode(',', $missing));
		}

		$model = $this->modelClass;
		$model = $model::findOne(['mobile' => $params['mobile']]);
		if (empty($model)) {
			throw new \yii\web\HttpException(400, 'Mobile Not found');
		}
		return $model;
	}

	public function actionValidate()
	{
		return [];

		$params = Yii::$app->request->post();
		// Validation of Fields
		$requiredFields = ['mobile'];

		$missing = [];
		foreach ($requiredFields as $key => $value) {
			if (!array_key_exists($value, $params)) {
				$missing[] = $value;
			}
		}

		if (!empty($missing)) {
			throw new \yii\web\HttpException(400, 'missing attributes:' . implode(',', $missing));
		}

		$model = $this->modelClass;
		$model = $model::findOne(['mobile' => $params['mobile']]);
		if (empty($model)) {
			throw new \yii\web\HttpException(400, 'Mobile not Found');
		}
		$model->resetCode = (string) rand(1000, 9999);
		if ($model->save()) {
			// Send SMS
			$message = 'Your Tafutaa validation code is: ' . $model->resetCode;
			$model->sendSMS($message);
			return ['code' => '00', 'message' => 'successful'];
		} else {
			throw new \yii\web\HttpException(400, 'Failed to validate');
		}
	}

	public function actionConfirm()
	{
		$params = Yii::$app->request->post();

		// Validation of Fields
		$missing = self::validateFields($params, ['mobile', 'confirmationCode']);

		if (!empty($missing)) {
			throw new \yii\web\HttpException(400, 'missing attributes:' . implode(',', $missing));
		}

		$model = $this->modelClass;
		$model = $model::findOne(['mobile' => $params['mobile']]);
		if (empty($model)) {
			throw new \yii\web\HttpException(400, 'Mobile Not found');
		}

		if ($model->resetCode != $params['confirmationCode']) {
			throw new \yii\web\HttpException(400, 'Invalid Code');
		}
		return ['code' => '00', 'message' => 'successful'];
	}

	public function actionResendCode()
	{
		$params = Yii::$app->request->post();
		// Validation of Fields
		$requiredFields = ['mobile'];

		$missing = [];
		foreach ($requiredFields as $key => $value) {
			if (!array_key_exists($value, $params)) {
				$missing[] = $value;
			}
		}

		if (!empty($missing)) {
			throw new \yii\web\HttpException(400, 'missing attributes:' . implode(',', $missing));
		}

		$model = $this->modelClass;
		$model = $model::findOne(['mobile' => $params['mobile']]);
		if (empty($model)) {
			throw new \yii\web\HttpException(400, 'Mobile not Found');
		}
		$model->resetCode = (string) rand(1000, 9999);
		if ($model->save()) {
			// Send SMS
			$message = 'Your Tafutaa validation code is: ' . $model->resetCode;
			$model->sendSMS($message);
			return ['code' => '00', 'message' => 'successful'];
		} else {
			throw new \yii\web\HttpException(400, 'Failed to validate');
		}
	}

	public function actionResetPassword()
	{
		$params = Yii::$app->request->post();

		// Validation of Fields
		$missing = self::validateFields($params, ['mobile', 'newPassword']);

		if (!empty($missing)) {
			throw new \yii\web\HttpException(400, 'missing attributes:' . implode(',', $missing));
		}

		$model = $this->modelClass;
		$model = $model::findOne(['mobile' => $params['mobile']]);
		if (empty($model)) {
			throw new \yii\web\HttpException(400, 'Mobile Not found');
		}

		$password = (string) $params['newPassword'];
		$model->authKey = \Yii::$app->security->generateRandomString();
		$model->passwordHash = \Yii::$app->security->generatePasswordHash($password);
		if ($model->save()) {
			return ['code' => '00', 'message' => 'successful'];
		} else {
			throw new \yii\web\HttpException(400, 'Failed to change Password');
		}
	}

	public function actionChangePassword()
	{
		$params = Yii::$app->request->post();

		// Validation of Fields
		$missing = self::validateFields($params, ['mobile', 'confirmPassword', 'newPassword', 'oldPassword']);

		if (!empty($missing)) {
			throw new \yii\web\HttpException(400, 'missing attributes:' . implode(',', $missing));
		}

		$model = $this->modelClass;
		$model = $model::findOne(['mobile' => $params['mobile']]);
		if (empty($model)) {
			throw new \yii\web\HttpException(400, 'Mobile Not found');
		}

		$password = (string) $params['newPassword'];
		if (Yii::$app->security->validatePassword($password, $model->passwordHash)) {
			$model->authKey = \Yii::$app->security->generateRandomString();
			$model->passwordHash = \Yii::$app->security->generatePasswordHash($password);
			if ($model->save()) {
				return ['code' => '00', 'message' => 'successful'];
			} else {
				throw new \yii\web\HttpException(400, 'Failed to change Password');
			}
		} else {
			throw new \yii\web\HttpException(400, 'Invalid Credentials');
		}
	}

	public static function validateFields($params, $requiredFields)
	{
		$missing = [];
		foreach ($requiredFields as $key => $value) {
			if (!array_key_exists($value, $params)) {
				$missing[] = $value;
			}
		}
		return $missing;
	}
}
