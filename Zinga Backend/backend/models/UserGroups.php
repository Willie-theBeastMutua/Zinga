<?php

namespace app\models;

use Yii;

/**
* This is the model class for table "user_groups".
*
* @property int $userGroupId
* @property string $userGroupName
* @property string|null $comments
* @property int $createdBy
* @property int $createdTime
* @property int $updatedTime
* @property int|null $deletedTime
* @property int $deleted
*
* @property UserGroupMembers[] $userGroupMembers
* @property UserGroupRights[] $userGroupRights
* @property Users $user
*/
class UserGroups extends \yii\db\ActiveRecord
{
	/**
	* {@inheritdoc}
	*/
	public static function tableName()
	{
		return 'user_groups';
	}
	
	public function fields()
	{
		return [
			'userGroupId',
			'userGroupName',
			'comments',
			'createdBy',
			'createdTime',
			'updatedTime',
			'deletedTime',
			'deleted',
		];
	}

	public function extraFields()
	{
		return [
			'userGroupMembers',
			'userGroupRights',
			'User',
		];
	}

	/**
	 * Added by Joseph Ngugi
	 * Filter Deleted Items
	 */
	public static function find()
	{
		return parent::find()->andWhere(['=', 'user_groups.deleted', 0]);
	}

	/**
	 * Added by Joseph Ngugi
	 * To be executed before delete
	 */
	public function delete()
	{
		$m = parent::findOne($this->getPrimaryKey());
		$m->deleted = 1;
		return $m->save();
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

	/**
	* {@inheritdoc}
	*/
	public function rules()
	{
		return [
			[['userGroupName', 'createdBy', 'createdTime', 'updatedTime'], 'required'],
			[['comments'], 'string'],
			[['createdBy', 'deleted'], 'integer'],
            [['createdTime', 'updatedTime', 'deletedTime'], 'safe'],
			[['userGroupName'], 'string', 'max' => 45],
			[['userGroupName'], 'unique'],
			[['createdBy'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['createdBy' => 'userId']],
		];
	}
	
	/**
	* {@inheritdoc}
	*/
	public function attributeLabels()
	{
		return [
			'userGroupId' => 'User Group ID',
			'userGroupName' => 'User Group Name',
			'comments' => 'Comments',
			'createdBy' => 'Created By',
			'createdTime' => 'Created Time',
			'updatedTime' => 'Updated Time',
			'deletedTime' => 'Deleted Time',
			'deleted' => 'Deleted',
		];
	}

	/**
	* Gets query for [[UserGroupMembers]].
	*
	* @return \yii\db\ActiveQuery
	*/
	public function getUserGroupMembers()
	{
		return $this->hasMany(UserGroupMembers::className(), ['userGroupId' => 'userGroupId']);
	}

	/**
	* Gets query for [[UserGroupRights]].
	*
	* @return \yii\db\ActiveQuery
	*/
	public function getUserGroupRights()
	{
		return $this->hasMany(UserGroupRights::className(), ['userGroupId' => 'userGroupId']);
	}

	/**
	* Gets query for [[User]].
	*
	* @return \yii\db\ActiveQuery
	*/
	public function getUser()
	{
		return $this->hasOne(Users::className(), ['userId' => 'createdBy']);
	}
}
