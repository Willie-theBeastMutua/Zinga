<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "support_subjects".
 *
 * @property int $supportSubjectId
 * @property string $supportSubjectName
 * @property string|null $notes
 * @property int $createdBy
 * @property int $createdTime
 * @property int|null $updatedTime
 * @property int|null $deletedTime
 * @property int $deleted
 */
class SupportSubjects extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'support_subjects';
	}

	public static function find()
	{
		return parent::find()->where(['=', 'support_subjects.deleted', 0]);
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

	public function delete()
	{
		$m = parent::findOne($this->getPrimaryKey());
		$m->deleted = 1;
		$m->deletedTime = time();
		return $m->save();
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
        return [
			[['comments'], 'string'],
			[['createdBy', 'supportSubjectName'], 'required'],
            [['createdTime', 'updatedTime', 'deletedTime'], 'safe'],
			[['createdBy', 'deleted'], 'integer'],
			[['supportSubjectName'], 'string', 'max' => 45],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'supportSubjectId' => 'Support Subject ID',
			'supportSubjectName' => 'Support Subject',
			'notes' => 'Notes',
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
