<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "support_attachments".
 *
 * @property int $attachmentId
 * @property string|null $caption
 * @property int|null $supportId
 * @property string|null $image
 * @property int $createdBy
 * @property int $createdTime
 * @property int|null $updatedTime
 * @property int|null $deletedTime
 * @property int $deleted
 */
class SupportAttachments extends \yii\db\ActiveRecord
{
	/**
	 * @var UploadedFile
	 */
	public $imageFile;

	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'support_attachments';
	}

	public static function find()
	{
		return parent::find()->where(['=', 'support_attachments.deleted', 0]);
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
			[['image'], 'string'],
			[['createdBy', 'createdTime', 'caption'], 'required'],
			[['caption'], 'string', 'max' => 45],
			[['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'attachmentId' => 'Attachment ID',
			'caption' => 'Caption',
			'supportId' => 'Support ID',
			'image' => 'Image',
			'createdBy' => 'Created By',
			'createdTime' => 'Created Time',
			'updatedTime' => 'Updated Time',
			'deletedTime' => 'Deleted Time',
			'deleted' => 'Deleted',
		];
	}

	public function formatImage()
	{
		$tmpfile_contents = file_get_contents($this->imageFile->tempName);
		$type = $this->imageFile->type;
		return 'data:' . $type . ';base64,' . base64_encode($tmpfile_contents);
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
