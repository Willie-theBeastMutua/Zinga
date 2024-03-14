<?php
/**
 * Created by gii.
 * User: Joseph Ngugi
 * Date: 2024/02/08
 * Time: 16:21
 */

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
use yii;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;

class FeedbackStatusController extends ActiveController
{
    public $modelClass = 'app\models\FeedbackStatus';

	public function behaviors()
	{
		$behaviors = parent::behaviors();

		// remove auth filter
		unset($behaviors['authenticator']);

		$behaviors['corsFilter'] = [
			'class' => \yii\filters\Cors::class,
			'cors' => [
				'Origin' => Yii::$app->params['cors-origin'],
				'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
				'Access-Control-Request-Headers' => ['*'],
				'Access-Control-Allow-Credentials' => true,
				'Access-Control-Max-Age' => 86400,
			],
		];

		// $behaviors['authenticator'] = [
		// 	'class' => HttpBearerAuth::class,
		// ];

		return $behaviors;
	}

	protected function verbs()
	{
		return [
			'verbs' => [
				'class' => \yii\filters\VerbFilter::class,
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
		// unset($actions['index']);
		// unset($actions['view']);
		// unset($actions['create']);
		unset($actions['update']);
		unset($actions['delete']);
		return $actions;
	}
}
