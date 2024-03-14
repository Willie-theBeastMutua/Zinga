<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_group_rights".
 *
 * @property int $userGroupRightId
 * @property int|null $userGroupId
 * @property int|null $pageId
 * @property int $view
 * @property int $edit
 * @property int $create
 * @property int $delete
 * @property int|null $createdBy
 * @property string $createdDate
 * @property int $deleted
 */
class UserGroupRights extends \yii\db\ActiveRecord
{
	public $pageName;
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'user_group_rights';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['userGroupId', 'pageId', 'view', 'edit', 'create', 'delete', 'createdBy', 'deleted'], 'integer'],
			[['createdTime'], 'safe'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'userGroupRightId' => 'User Group Right ID',
			'userGroupId' => 'User Group ID',
			'pageId' => 'Page ID',
			'view' => 'View',
			'edit' => 'Edit',
			'create' => 'Create',
			'delete' => 'Delete',
			'createdBy' => 'Created By',
			'createdTime' => 'Created Date',
			'deleted' => 'Deleted',
		];
	}

	/**
	 * Added by Joseph Ngugi
	 * To be executed before Save
	 */
	public function save($runValidation = true, $attributeNames = null)
	{
		//this record is always new
		if ($this->isNewRecord) {
			$this->createdBy = Yii::$app->user->identity->userId;
		}
		return parent::save();
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['userId' => 'CreatedBy']);
	}

	public function getUserGroups()
	{
		return $this->hasOne(UserGroups::className(), ['userGroupId' => 'userGroupId']);
	}

	public function getPages()
	{
		return $this->hasOne(Pages::className(), ['pageId' => 'pageId']);
	}

	public function getUserGroupMembers()
	{
		return $this->hasMany(UserGroupMembers::className(), ['userGroupId' => 'userGroupId']);
	}
}
