<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_group_members".
 *
 * @property int $userGroupMemberId
 * @property int|null $userId
 * @property int|null $userGroupId
 * @property int $active
 * @property string $createdDate
 * @property int|null $createdBy
 * @property int $deleted
 */
class UserGroupMembers extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'user_group_members';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['userId', 'userGroupId', 'active', 'createdBy', 'deleted'], 'integer'],
			[['createdDate'], 'safe'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'userGroupMemberId' => 'User Group Member ID',
			'userId' => 'User ID',
			'userGroupId' => 'User Group ID',
			'active' => 'Active',
			'createdDate' => 'Created Date',
			'createdBy' => 'Created By',
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

	public function getMembers()
	{
		return $this->hasOne(Users::className(), ['userId' => 'userId'])->from(['members' => users::tableName()]);
	}
}
