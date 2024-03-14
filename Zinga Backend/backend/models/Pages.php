<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pages".
 *
 * @property int $pageId
 * @property string|null $pageName
 * @property int $create
 * @property int $edit
 * @property int $delete
 * @property int $view
 * @property string|null $comments
 * @property string $createdTime
 * @property string $updatedTime
 * @property string|null $deletedTime
 * @property int $createdBy
 * @property int $deleted
 *
 * @property Users $createdBy0
 * @property UserGroupRights[] $userGroupRights
 */
class Pages extends \yii\db\ActiveRecord
{
    const STATUS_YES = 1;
    const STATUS_NO = 0;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pages';
    }

    public function fields()
	{
		return [
            'pageId',
            'pageName',
            'create',
            'edit',
            'delete',
            'view',
            'comments',
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
            'createdBy0',
            'userGroupRights',
        ];
	}

    /**
	 * Added by Joseph Ngugi
	 * Filter Deleted Items
	 */
	public static function find()
	{
		return parent::find()->andWhere(['=', 'pages.deleted', 0]);
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
            [['create', 'edit', 'delete', 'view', 'createdBy', 'deleted'], 'integer'],
            [['comments'], 'string'],
            [['createdTime', 'updatedTime', 'deletedTime'], 'safe'],
            [['createdBy'], 'required'],
            [['pageName'], 'string', 'max' => 45],
            [['createdBy'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['createdBy' => 'userId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pageId' => 'Page ID',
            'pageName' => 'Page Name',
            'create' => 'Create',
            'edit' => 'Edit',
            'delete' => 'Delete',
            'view' => 'View',
            'comments' => 'Comments',
            'createdTime' => 'Created Time',
            'updatedTime' => 'Updated Time',
            'deletedTime' => 'Deleted Time',
            'createdBy' => 'Created By',
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
     * Gets query for [[UserGroupRights]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserGroupRights()
    {
        return $this->hasMany(UserGroupRights::className(), ['pageId' => 'pageId']);
    }
    public function getUser()
	{
		return $this->hasOne(Users::className(), ['userId' => 'createdBy'])->from(users::tableName());
	}
}
