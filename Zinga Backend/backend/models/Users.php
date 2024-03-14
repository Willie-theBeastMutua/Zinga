<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $userId
 * @property string|null $firstName
 * @property string|null $middleName
 * @property string|null $lastName
 * @property string|null $email
 * @property string|null $mobile
 * @property string|null $idNumber
 * @property string|null $passwordHash
 * @property string|null $authKey
 * @property int|null $userStatusId
 * @property int|null $companyId
 * @property string|null $authToken
 * @property string|null $renewToken
 * @property string|null $resetCode
 * @property string $createdTime
 * @property string $updatedTime
 * @property string $deletedTime
 * @property int $createdBy
 * @property int $deleted
 */
class Users extends \yii\db\ActiveRecord
{
	public $password;
	public $confirmPassword;

	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'users';
        // return parent::find()->andWhere(['=', 'users.deleted', 0]);
	}

	public function save($runValidation = true, $attributeNames = null)
	{
		//this record is always new
		if ($this->isNewRecord) {
			$this->createdBy = Yii::$app->user->identity->userId;
		}
		return parent::save();
	}

    /**
	 * Added by Joseph Ngugi
	 * To be executed before delete
	 */
	public function delete()
	{
		$m = parent::findOne($this->getPrimaryKey());
		$m->deleted = 1;
        $m->deletedTime = date('Y-m-d h:i:s');
		return $m->save();
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['userStatusId', 'createdBy', 'deleted'], 'integer'],
			[['createdBy', 'userStatusId', 'firstName', 'lastName', 'mobile'], 'required'],
			[['createdTime', 'updatedTime', 'deletedTime'], 'safe'],
			[['firstName', 'lastName', 'mobile', 'resetCode'], 'string', 'max' => 45],
			[['email'], 'string', 'max' => 200],
			[['passwordHash', 'authKey', 'authToken', 'renewToken'], 'string', 'max' => 128],
			[['password', 'confirmPassword'],'required', 'when' => function ($model) {
				return $model->isNewRecord;
			}],
			['password', 'compare', 'compareAttribute'=>'confirmPassword'],
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
			'userStatusId' => 'User Status',
			'authToken' => 'Auth Token',
			'renewToken' => 'Renew Token',
			'resetCode' => 'Reset Code',
			'createdTime' => 'Created Date',
			'updatedTime' => 'Updated Date',
			'deletedTime' => 'Deleted Date',
			'createdBy' => 'Created By',
			'deleted' => 'Deleted',
		];
	}

	public function getFullName()
	{
		return $this->firstName . ' ' . $this->lastName;
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['userId' => 'createdBy']);
	}

	public function getUserStatus()
	{
		return $this->hasOne(UserStatus::className(), ['userStatusId' => 'userStatusId']);
	}
}
