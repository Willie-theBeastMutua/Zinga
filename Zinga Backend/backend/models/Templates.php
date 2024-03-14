<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "message_templates".
 *
 * @property int $templateId
 * @property string $code
 * @property string $description
 * @property string $subject
 * @property string $message
 * @property string $createdTime
 * @property string $updatedTime
 * @property string|null $deletedTime
 * @property int $createdBy
 * @property int $deleted
 *
 * @property Users $user
 */
class Templates extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'templates';
    }

    public function fields()
	{
		return [
            'templateId',
            'code',
            'description',
            'subject',
            'message',
            'createdTime',
            'updatedTime',
            'deletedTime',
            'createdBy',
            'deleted',
        ];
	}

	public function extraFields()
	{        
		return [
            'user',
        ];
	}

    /**
	 * Added by Joseph Ngugi
	 * Filter Deleted Items
	 */
	public static function find()
	{
		return parent::find()->andWhere(['=', 'templates.deleted', 0]);
	}

	/**
	 * Added by Joseph Ngugi
	 * To be executed before delete
	 */
	public function delete()
	{
		$m = parent::findOne($this->getPrimaryKey());
		$m->deleted = 1;
        $m->deletedTime = date('Y-m-d H:i:s');
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
            [['code', 'description', 'subject', 'message', 'createdBy'], 'required'],
            [['message'], 'string'],
            [['createdTime', 'updatedTime', 'deletedTime'], 'safe'],
            [['createdBy', 'deleted'], 'integer'],
            [['code'], 'string', 'max' => 5],
            [['description', 'subject'], 'string', 'max' => 50],
            [['code'], 'unique'],
            [['createdBy'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['createdBy' => 'userId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'templateId' => 'Template ID',
            'code' => 'Code',
            'description' => 'Description',
            'subject' => 'Subject',
            'message' => 'Message',
            'createdTime' => 'Created Time',
            'updatedTime' => 'Updated Time',
            'deletedTime' => 'Deleted Time',
            'createdBy' => 'Created By',
            'deleted' => 'Deleted',
        ];
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
