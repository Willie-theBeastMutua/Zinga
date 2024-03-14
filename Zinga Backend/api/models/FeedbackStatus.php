<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "feedback_status".
 *
 * @property int $feedbackStatusId
 * @property string $feedbackStatusName
 * @property string|null $comment
 * @property int $createdBy
 * @property string $createdTime
 * @property string $updatedTime
 * @property string|null $deletedTime
 * @property int $deleted
 *
 * @property Users $createdBy0
 */
class FeedbackStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'feedback_status';
    }

    public function fields()
	{
		return [
            'feedbackStatusId',
            'name' => 'feedbackStatusName'
            // 'comment',
            // 'createdBy',
            // 'createdTime',
            // 'updatedTime',
            // 'deletedTime',
            // 'deleted',
        ];
	}

	public function extraFields()
	{        
		return [
            'createdBy0',
        ];
	}

    /**
	 * Added by Joseph Ngugi
	 * Filter Deleted Items
	 */
	public static function find()
	{
		return parent::find()->andWhere(['=', 'feedback_status.deleted', 0]);
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
            [['feedbackStatusName', 'createdBy'], 'required'],
            [['comment'], 'string'],
            [['createdBy', 'deleted'], 'integer'],
            [['createdTime', 'updatedTime', 'deletedTime'], 'safe'],
            [['feedbackStatusName'], 'string', 'max' => 45],
            [['feedbackStatusName'], 'unique'],
            [['createdBy'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['createdBy' => 'userId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'feedbackStatusId' => 'Feedback Status ID',
            'feedbackStatusName' => 'Feedback Status Name',
            'comment' => 'Comment',
            'createdBy' => 'Created By',
            'createdTime' => 'Created Time',
            'updatedTime' => 'Updated Time',
            'deletedTime' => 'Deleted Time',
            'deleted' => 'Deleted',
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
}
