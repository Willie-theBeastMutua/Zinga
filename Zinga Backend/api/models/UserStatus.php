<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_status".
 *
 * @property int $userStatusId
 * @property string $userStatusName
 * @property string|null $comments
 * @property int $createdBy
 * @property string $createdTime
 * @property string $updatedTime
 * @property string|null $deletedTime
 * @property int $deleted
 *
 * @property Users $createdBy0
 * @property Users[] $users
 */
class UserStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_status';
    }

    public function fields()
	{
		return [
            'userStatusId',
            'userStatusName',
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
            'createdBy0',
            'users',
        ];
	}

    /**
	 * Added by Joseph Ngugi
	 * Filter Deleted Items
	 */
	public static function find()
	{
		return parent::find()->andWhere(['=', 'user_status.deleted', 0]);
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
            [['userStatusName', 'createdBy'], 'required'],
            [['comments'], 'string'],
            [['createdBy', 'deleted'], 'integer'],
            [['createdTime', 'updatedTime', 'deletedTime'], 'safe'],
            [['userStatusName'], 'string', 'max' => 45],
            [['userStatusName'], 'unique'],
            [['createdBy'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['createdBy' => 'userId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'userStatusId' => 'User Status ID',
            'userStatusName' => 'User Status Name',
            'comments' => 'Comments',
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

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(Users::className(), ['userStatusId' => 'userStatusId']);
    }
}
