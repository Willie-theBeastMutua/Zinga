<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "support_status".
 *
 * @property int $supportStatusId
 * @property string|null $supportStatusName
 * @property string|null $comments
 * @property int $createdBy
 * @property int $createdTime
 * @property int|null $updatedTime
 * @property int|null $deletedTime
 * @property int $deleted
 */
class SupportStatus extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'support_status';
	}

	public static function find()
	{
		return parent::find()->where(['=', 'support_status.deleted', 0]);
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
		}
		return parent::save();
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['comments'], 'string'],
			[['createdBy', 'supportStatusName'], 'required'],
            [['createdTime', 'updatedTime', 'deletedTime'], 'safe'],
			[['createdBy', 'deleted'], 'integer'],
			[['supportStatusName'], 'string', 'max' => 45],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'supportStatusId' => 'Support Status ID',
			'supportStatusName' => 'Support Status',
			'comments' => 'Comments',
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
}
