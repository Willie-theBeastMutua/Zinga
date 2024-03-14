<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "support_notes".
 *
 * @property int $supportNoteId
 * @property int|null $supportId
 * @property string|null $notes
 * @property int $createdBy
 * @property int $createdTime
 * @property int|null $updatedTime
 * @property int|null $deletedTime
 * @property int $deleted
 */
class SupportNotes extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'support_notes';
	}

	public static function find()
	{
		return parent::find()->where(['=', 'support_notes.deleted', 0]);
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
			[['supportId', 'createdBy', 'createdTime', 'updatedTime', 'deletedTime', 'deleted'], 'integer'],
			[['notes'], 'string'],
			[['createdBy', 'createdTime'], 'required'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'supportNoteId' => 'Support Note ID',
			'supportId' => 'Support ID',
			'notes' => 'Notes',
			'createdBy' => 'Created By',
			'createdTime' => 'Created Time',
			'updatedTime' => 'updated Time',
			'deletedTime' => 'Deleted Time',
			'deleted' => 'Deleted',
		];
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['userId' => 'createdBy'])->from(users::tableName());
	}

	public function getSupport()
	{
		return $this->hasOne(Support::className(), ['supportId' => 'supportId'])->from(support::tableName());
	}
}
