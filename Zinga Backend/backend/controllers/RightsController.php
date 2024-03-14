<?php

namespace backend\controllers;

use Yii;
use app\models\UserGroupRights;
use app\models\UserGroupMembers;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;

/**
 * CompanyController implements the CRUD actions for Company model.
 */
class RightsController extends Controller
{
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
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
						'actions' => ['permissions'],
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
	 * Displays a single Company model.
	 * @param integer $id
	 * @return mixed
	 */
	public static function permissions($pageId = 0)
	{
		if (!Yii::$app->user->isGuest) {
			$UserID = Yii::$app->user->identity->userId;
			

			if ($pageId == 0) {
				$rights = UserGroupRights::find()->joinWith('userGroupMembers')
														->select(['pageId', 'create', 'edit', 'view', 'delete', 'user_group_rights.userGroupId'])
														->asArray()
														->andWhere(['userId' => $UserID])
														->distinct()
														->all();
			} else {
				$rights = UserGroupRights::find()->joinWith('userGroupMembers')
														->select(['pageId', 'create', 'edit', 'view', 'delete', 'user_group_rights.userGroupId'])
														->asArray()
														->andWhere(['userId' => $UserID, 'pageId' => $pageId])
														->distinct()
														->all();
			}

			if (!empty($rights)) {
				foreach ($rights as $k => $right) {
					foreach ($right as $key => $value) {
						if (gettype($value) == 'array') {
							unset($rights[$k][$key]);
						}
						if (gettype($value) != 'array' && $value != 1 && $key != 'pageId') {
							unset($rights[$k][$key]);
						}
					}
				}
			}
		} else {
			$rights = [];
		}
        // print_r($rights); exit;
		return count($rights) == 1 ? (object) $rights[0] : (object) $rights;
	}
}
