<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "feedback".
 *
 * @property int $feedbackId
 * @property int $subSectionId
 * @property string|null $feedback
 * @property string|null $comments
 * @property int $createdBy
 * @property string $createdTime
 * @property string $updatedTime
 * @property string|null $deletedTime
 * @property int $deleted
 * @property int|null $feedbackStatusId
 *
 * @property Users $createdBy0
 * @property FeedbackStatus $feedbackStatus
 */
class Feedback extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'feedback';
    }

    public function fields()
	{
		return [
            'feedbackId',
            'subSectionId',
            'feedback',
            // 'comments',
            // 'createdBy',
            // 'createdTime',
            // 'updatedTime',
            // 'deletedTime',
            // 'deleted',
            'feedbackStatusId',
            'feedbackStatus',
            // 'createdBy0',

        ];
	}

	public function extraFields()
	{        
		return [
            'createdBy0',
            'feedbackStatus',
        ];
	}

    /**
	 * Added by Joseph Ngugi
	 * Filter Deleted Items
	 */
	public static function find()
	{
		return parent::find()->andWhere(['=', 'feedback.deleted', 0]);
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
            [['subSectionId', 'createdBy'], 'required'],
            [['subSectionId', 'createdBy', 'deleted', 'feedbackStatusId'], 'integer'],
            [['feedback', 'comments'], 'string'],
            [['createdTime', 'updatedTime', 'deletedTime'], 'safe'],
            [['createdBy'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['createdBy' => 'userId']],
            [['feedbackStatusId'], 'exist', 'skipOnError' => true, 'targetClass' => FeedbackStatus::className(), 'targetAttribute' => ['feedbackStatusId' => 'feedbackStatusId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'feedbackId' => 'Feedback ID',
            'subSectionId' => 'Sub Section ID',
            'feedback' => 'Feedback',
            'comments' => 'Comments',
            'createdBy' => 'Created By',
            'createdTime' => 'Created Time',
            'updatedTime' => 'Updated Time',
            'deletedTime' => 'Deleted Time',
            'deleted' => 'Deleted',
            'feedbackStatusId' => 'Feedback Status ID',
        ];
    }

    /**
     * Gets query for [[CreatedBy0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy0()
    {
        return $this->hasOne(Users::className(), ['userId' => 'createdBy']);
    }

    /**
     * Gets query for [[FeedbackStatus]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFeedbackStatus()
    {
        return $this->hasOne(FeedbackStatus::className(), ['feedbackStatusId' => 'feedbackStatusId']);
    }
}
