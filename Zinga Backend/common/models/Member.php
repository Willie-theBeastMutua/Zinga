<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
* @property int $memberId
* @property string|null $memberName
* @property string|null $photo
* @property int|null $countryId
* @property int|null $genderId
* @property int|null $memberTypeId
* @property int|null $preferenceId
* @property string|null $dob
* @property string|null $mobile
* @property string|null $passwordHash
* @property string|null $authKey
* @property string|null $authToken
* @property string|null $renewToken
* @property int|null $tokenExpiry
* @property string|null $otp
* @property int|null $memberStatusId
* @property int|null $memberCategoryId
* @property int|null $expiryDate
* @property int $createdTime
* @property int|null $updatedTime
* @property int|null $deletedTime
* @property int $deleted
 */

class Member extends ActiveRecord implements IdentityInterface
{
	const STATUS_DELETED = 3;
	const STATUS_INACTIVE = 2;
	const STATUS_ACTIVE = [1, 2];
	const GROUPS = [0, 1, 2];
	const API_GROUPS = [0, 1, 2, 3, 4];

	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return '{{%members}}';
	}

	/**
	 * {@inheritdoc}
	 */
	public function behaviors()
	{
		return [
			TimestampBehavior::class,
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			['memberStatusId', 'default', 'value' => self::STATUS_INACTIVE],
			['memberStatusId', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public static function findIdentity($id)
	{
		return static::find()->andWhere(['memberId' => $id, 'memberStatusId' => self::STATUS_ACTIVE])
									->andWhere(['in', 'memberCategoryId', self::GROUPS])->one();
	}

	/**
	 * {@inheritdoc}
	 */
	public static function findIdentityByAccessToken($token, $type = null)
	{
		return static::find()->andWhere(['authToken' => $token, 'memberStatusId' => self::STATUS_ACTIVE])
		->andWhere(['in', 'memberCategoryId', self::API_GROUPS])->one();
	}

	/**
	 * Finds user by username
	 *
	 * @param string $email
	 * @return static|null
	 */
	public static function findByUsername($username)
	{
		return static::find()->andWhere(['mobile' => $username, 'memberStatusId' => self::STATUS_ACTIVE])
									->andWhere(['in', 'memberCategoryId', self::GROUPS])->one();
	}

	/**
	 * Finds user by password reset token
	 *
	 * @param string $token password reset token
	 * @return static|null
	 */
	public static function findByPasswordResetToken($token)
	{
		if (!static::isPasswordResetTokenValid($token)) {
			return null;
		}

		return static::find()->andWhere(['resetCode' => $token, 'memberStatusId' => self::STATUS_ACTIVE])
									->andWhere(['in', 'memberCategoryId', self::GROUPS])->one();
	}

	/**
	 * Finds user by verification email token
	 *
	 * @param string $token verify email token
	 * @return static|null
	 */
	public static function findByVerificationToken($token)
	{
		return static::find()->andWhere(['verificationCode' => $token])
									->andWhere(['in', 'memberStatusId', self::STATUS_INACTIVE])
									->andWhere(['in', 'memberCategoryId', self::GROUPS])
									->one();
	}

	/**
	 * Finds out if password reset token is valid
	 *
	 * @param string $token password reset token
	 * @return bool
	 */
	public static function isPasswordResetTokenValid($token)
	{
		if (empty($token)) {
			return false;
		}

		$timestamp = (int) substr($token, strrpos($token, '_') + 1);
		$expire = Yii::$app->params['user.passwordResetTokenExpire'];
		return $timestamp + $expire >= time();
	}

	/**
	 * {@inheritdoc}
	 */
	public function getId()
	{
		return $this->getPrimaryKey();
	}

	/**
	 * {@inheritdoc}
	 */
	public function getAuthKey()
	{
		return $this->authKey;
	}

	/**
	 * {@inheritdoc}
	 */
	public function validateAuthKey($authKey)
	{
		return $this->getAuthKey() === $authKey;
	}

	/**
	 * Validates password
	 *
	 * @param string $password password to validate
	 * @return bool if password provided is valid for current user
	 */
	public function validatePassword($password)
	{
		return Yii::$app->security->validatePassword($password, $this->passwordHash);
	}

	/**
	 * Generates password hash from password and sets it to the model
	 *
	 * @param string $password
	 */
	public function setPassword($password)
	{
		$this->passwordHash = Yii::$app->security->generatePasswordHash($password);
	}

	/**
	 * Generates "remember me" authentication key
	 */
	public function generateAuthKey()
	{
		$this->authKey = Yii::$app->security->generateRandomString();
	}

	/**
	 * Generates new password reset token
	 */
	public function generatePasswordResetToken()
	{
		$this->resetCode = rand(1000, 9999);
	}

	/**
	 * Generates new token for email verification
	 */
	public function generateEmailVerificationToken()
	{
		$this->verificationCode = rand(1000, 9999);
	}

	/**
	 * Removes password reset token
	 */
	public function removePasswordResetToken()
	{
		$this->resetCode = null;
	}
}
