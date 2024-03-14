<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
* This is the model class for table "customers".
*
* @property int $customerId
* @property string $firstName
* @property string $lastName
* @property string $dob
* @property string $mobile
* @property string|null $email
* @property int $companyId
* @property int $customerStatusId
* @property string $passwordHash
* @property string $authKey
* @property string|null $authToken
* @property string|null $token
* @property int|null $tokenExpiry
* @property string|null $renewToken
* @property string|null $resetCode
* @property int $changePassword
* @property int $createdBy
* @property int $createdTime
* @property int $updatedTime
* @property int|null $deletedTime
* @property int $deleted
*/

class Customer extends ActiveRecord implements IdentityInterface
{
	const STATUS_DELETED = 3;
	const STATUS_INACTIVE = 2;
	const STATUS_ACTIVE = 1;
	const API_STATUS = [1];

	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return '{{%customers}}';
	}

	/**
	 * {@inheritdoc}
	 */
	public function behaviors()
	{
		return [
			TimestampBehavior::className(),
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			['customerStatusId', 'default', 'value' => self::STATUS_INACTIVE],
			['customerStatusId', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public static function findIdentity($id)
	{
		return static::findOne(['customerId' => $id, 'customerStatusId' => self::STATUS_ACTIVE]);
	}

	/**
	 * {@inheritdoc}
	 */
	/* public static function findIdentityByAccessToken($token, $type = null)
	{
		throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
	} */

	/**
	 * {@inheritdoc}
	 */
	public static function findIdentityByAccessToken($token, $type = null)
	{
		return static::find()->andWhere(['token' => $token, 'customerStatusId' => self::STATUS_ACTIVE])
									->andWhere(['in', 'customerStatusId', self::API_STATUS])->one();
	}

	/**
	 * Finds user by username
	 *
	 * @param string $email
	 * @return static|null
	 */
	public static function findByUsername($username)
	{
		return static::findOne(['email' => $username, 'customerStatusId' => self::STATUS_ACTIVE]);
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

		return static::findOne([
			'resetCode' => $token,
			'customerStatusId' => self::STATUS_ACTIVE,
		]);
	}

	/**
	 * Finds user by verification email token
	 *
	 * @param string $token verify email token
	 * @return static|null
	 */
	public static function findByVerificationToken($token) {
		return static::findOne([
			'verificationCode' => $token,
			'customerStatusId' => self::STATUS_INACTIVE
		]);
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
		echo $authKey; exit;
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
