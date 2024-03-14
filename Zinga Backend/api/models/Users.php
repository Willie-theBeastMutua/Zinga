<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $userId
 * @property string $firstName
 * @property string $lastName
 * @property string|null $email
 * @property string $mobile
 * @property string|null $passwordHash
 * @property string|null $authKey
 * @property int $userStatusId
 * @property string|null $authToken
 * @property string|null $renewToken
 * @property string|null $resetCode
 * @property int|null $expiryDate
 * @property string|null $tokenExpiry
 * @property int $changePassword
 * @property string $createdTime
 * @property string $updatedTime
 * @property string|null $deletedTime
 * @property int $createdBy
 * @property int $deleted
 *
 * @property Feedback[] $feedbacks
 * @property FeedbackStatus[] $feedbackStatuses
 * @property ForumResponses[] $forumResponses
 * @property Forums[] $forums
 * @property Pages[] $pages
 * @property Support[] $supports
 * @property SupportAttachments[] $supportAttachments
 * @property SupportNotes[] $supportNotes
 * @property SupportStatus[] $supportStatuses
 * @property SupportSubjects[] $supportSubjects
 * @property Templates[] $templates
 * @property UserGroupMembers[] $userGroupMembers
 * @property UserGroupMembers[] $userGroupMembers0
 * @property UserGroupRights[] $userGroupRights
 * @property UserGroups[] $userGroups
 * @property UserStatus[] $userStatuses
 * @property UserStatus $userStatus
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    public function fields()
	{
		return [
            'userId',
            'firstName',
            'lastName',
            'email',
            'mobile',
            // 'passwordHash',
            // 'authKey',
            // 'userStatusId',
            // 'authToken',
            // 'renewToken',
            // 'resetCode',
            // 'expiryDate',
            // 'tokenExpiry',
            // 'changePassword',
            // 'createdTime',
            // 'updatedTime',
            // 'deletedTime',
            // 'createdBy',
            // 'deleted',
        ];
	}

	public function extraFields()
	{        
		return [
            'feedbacks',
            'feedbackStatuses',
            'forumResponses',
            'forums',
            'pages',
            'supports',
            'supportAttachments',
            'supportNotes',
            'supportStatuses',
            'supportSubjects',
            'templates',
            'userGroupMembers',
            'userGroupMembers0',
            'userGroupRights',
            'userGroups',
            'userStatuses',
            'userStatus',
        ];
	}

    /**
	 * Added by Joseph Ngugi
	 * Filter Deleted Items
	 */
	public static function find()
	{
		return parent::find()->andWhere(['=', 'users.deleted', 0]);
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
            [['firstName', 'lastName', 'mobile', 'createdBy'], 'required'],
            [['userStatusId', 'expiryDate', 'changePassword', 'createdBy', 'deleted'], 'integer'],
            [['tokenExpiry', 'createdTime', 'updatedTime', 'deletedTime'], 'safe'],
            [['firstName', 'lastName', 'mobile', 'resetCode'], 'string', 'max' => 45],
            [['email'], 'string', 'max' => 200],
            [['passwordHash', 'authKey', 'authToken', 'renewToken'], 'string', 'max' => 128],
            [['mobile'], 'unique'],
            [['userStatusId'], 'exist', 'skipOnError' => true, 'targetClass' => UserStatus::className(), 'targetAttribute' => ['userStatusId' => 'userStatusId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'userId' => 'User ID',
            'firstName' => 'First Name',
            'lastName' => 'Last Name',
            'email' => 'Email',
            'mobile' => 'Mobile',
            'passwordHash' => 'Password Hash',
            'authKey' => 'Auth Key',
            'userStatusId' => 'User Status ID',
            'authToken' => 'Auth Token',
            'renewToken' => 'Renew Token',
            'resetCode' => 'Reset Code',
            'expiryDate' => 'Expiry Date',
            'tokenExpiry' => 'Token Expiry',
            'changePassword' => 'Change Password',
            'createdTime' => 'Created Time',
            'updatedTime' => 'Updated Time',
            'deletedTime' => 'Deleted Time',
            'createdBy' => 'Created By',
            'deleted' => 'Deleted',
        ];
    }

    /**
     * Gets query for [[Feedbacks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFeedbacks()
    {
        return $this->hasMany(Feedback::className(), ['createdBy' => 'userId']);
    }

    /**
     * Gets query for [[FeedbackStatuses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFeedbackStatuses()
    {
        return $this->hasMany(FeedbackStatus::className(), ['createdBy' => 'userId']);
    }

    /**
     * Gets query for [[ForumResponses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getForumResponses()
    {
        return $this->hasMany(ForumResponses::className(), ['createdBy' => 'userId']);
    }

    /**
     * Gets query for [[Forums]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getForums()
    {
        return $this->hasMany(Forums::className(), ['createdBy' => 'userId']);
    }

    /**
     * Gets query for [[Pages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPages()
    {
        return $this->hasMany(Pages::className(), ['createdBy' => 'userId']);
    }

    /**
     * Gets query for [[Supports]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSupports()
    {
        return $this->hasMany(Support::className(), ['createdBy' => 'userId']);
    }

    /**
     * Gets query for [[SupportAttachments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSupportAttachments()
    {
        return $this->hasMany(SupportAttachments::className(), ['createdBy' => 'userId']);
    }

    /**
     * Gets query for [[SupportNotes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSupportNotes()
    {
        return $this->hasMany(SupportNotes::className(), ['createdBy' => 'userId']);
    }

    /**
     * Gets query for [[SupportStatuses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSupportStatuses()
    {
        return $this->hasMany(SupportStatus::className(), ['createdBy' => 'userId']);
    }

    /**
     * Gets query for [[SupportSubjects]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSupportSubjects()
    {
        return $this->hasMany(SupportSubjects::className(), ['createdBy' => 'userId']);
    }

    /**
     * Gets query for [[Templates]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTemplates()
    {
        return $this->hasMany(Templates::className(), ['createdBy' => 'userId']);
    }

    /**
     * Gets query for [[UserGroupMembers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserGroupMembers()
    {
        return $this->hasMany(UserGroupMembers::className(), ['createdBy' => 'userId']);
    }

    /**
     * Gets query for [[UserGroupMembers0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserGroupMembers0()
    {
        return $this->hasMany(UserGroupMembers::className(), ['userId' => 'userId']);
    }

    /**
     * Gets query for [[UserGroupRights]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserGroupRights()
    {
        return $this->hasMany(UserGroupRights::className(), ['createdBy' => 'userId']);
    }

    /**
     * Gets query for [[UserGroups]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserGroups()
    {
        return $this->hasMany(UserGroups::className(), ['createdBy' => 'userId']);
    }

    /**
     * Gets query for [[UserStatuses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserStatuses()
    {
        return $this->hasMany(UserStatus::className(), ['createdBy' => 'userId']);
    }

    /**
     * Gets query for [[UserStatus]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserStatus()
    {
        return $this->hasOne(UserStatus::className(), ['userStatusId' => 'userStatusId']);
    }
}
