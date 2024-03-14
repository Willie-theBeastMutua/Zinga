<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "support".
 *
 * @property int $supportId
 * @property string|null $fullName
 * @property string|null $mobile
 * @property string|null $email
 * @property int|null $supportSubjectId
 * @property string|null $description
 * @property int|null $supportStatusId
 * @property string|null $resolution
 * @property int|null $dateClosed
 * @property int|null $closedBy
 * @property int $createdBy
 * @property int $createdTime
 * @property int|null $updatedTime
 * @property int|null $deletedTime
 * @property int $deleted
 */
class Support extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'support';
	}

	public static function find()
	{
		return parent::find()->where(['=', 'support.deleted', 0]);
	}

	public function delete()
	{
		$m = parent::findOne($this->getPrimaryKey());
		$m->deleted = 1;
		$m->deletedTime = time();
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
            $this->supportStatusId = 1;
		}
		return parent::save();
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['supportSubjectId', 'supportStatusId', 'closedBy', 'dateClosed', 'createdBy', 'deleted'], 'integer'],
			[['description', 'resolution'], 'string'],
            [['createdTime', 'updatedTime', 'deletedTime'], 'safe'],
			[['createdBy', 'fullName', 'supportSubjectId', 'supportStatusId', 'mobile'], 'required'],
			[['mobile'], 'string', 'min' => 10],
			[['email'], 'email'],
			[['fullName'], 'string', 'max' => 100],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'supportId' => 'Support ID',
			'fullName' => 'Full Name',
			'mobile' => 'Mobile',
			'email' => 'Email',
			'supportSubjectId' => 'Subject',
			'description' => 'Description',
			'supportStatusId' => 'Support Status',
			'resolution' => 'Resolution',
			'dateClosed' => 'Date Closed',
			'closedBy' => 'Closed By',
			'createdBy' => 'Created By',
			'createdTime' => 'Created Time',
			'updatedTime' => 'Updated Time',
			'deletedTime' => 'Deleted Time',
			'deleted' => 'Deleted',
		];
	}

	public function getUser()
	{
		return $this->hasOne(Users::className(), ['userId' => 'createdBy'])->from(users::tableName());
	}

	public function getClosingUser()
	{
		return $this->hasOne(Users::className(), ['userId' => 'closedBy'])->from(users::tableName());
	}

	public function getSupportSubject()
	{
		return $this->hasOne(SupportSubjects::className(), ['supportSubjectId' => 'supportSubjectId'])->from(supportsubjects::tableName());
	}

	public function getSupportStatus()
	{
		return $this->hasOne(SupportStatus::className(), ['supportStatusId' => 'supportStatusId'])->from(supportstatus::tableName());
	}
}
