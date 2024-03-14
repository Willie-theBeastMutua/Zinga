<?php
namespace common\models;

use Yii;
use yii\base\Model;
use app\models\Users;

/**
 * Register form
 */
class RegisterForm extends Model
{
	public $firstName;
	public $lastName;
	public $email;
	public $mobile;
	public $password;
	public $confirmPassword;

	private $_user;


	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			// username and password are both required
			[['firstName', 'lastName', 'email', 'mobile', 'password', 'confirmPassword'], 'required'],
			// password is validated by validatePassword()
			['password', 'validatePassword'],
			['mobile', 'validateMobile'],
			['email', 'validateEmail'],
		];
	}

	/**
	 * Validates the password.
	 * This method serves as the inline validation for password.
	 *
	 * @param string $attribute the attribute currently being validated
	 * @param array $params the additional name-value pairs given in the rule
	 */
	public function validatePassword($attribute, $params)
	{
		if (!$this->hasErrors()) {
			if ($this->password != $this->confirmPassword) {
					$this->addError($attribute, 'Password and Confrim Password do not Match');
			}
		}
	}

	/**
	 * Validates the Mobile.
	 * This method serves as the inline validation for Mobile.
	 *
	 * @param string $attribute the attribute currently being validated
	 * @param array $params the additional name-value pairs given in the rule
	 */
	public function validateMobile($attribute, $params)
	{
		if (!$this->hasErrors()) {
			$user = User::findByMobile($this->mobile);
			if ($user) {
				$this->addError($attribute, 'Mobile Already Exists.');
			}
		}
	}

	/**
	 * Validates the Email.
	 * This method serves as the inline validation for Email.
	 *
	 * @param string $attribute the attribute currently being validated
	 * @param array $params the additional name-value pairs given in the rule
	 */
	public function validateEmail($attribute, $params)
	{
		if (!$this->hasErrors()) {
			$user = User::findByEmail($this->email);
			if ($user) {
				$this->addError($attribute, 'Email Already Exists.');
			}
		}
	}

	/**
	 * Logs in a user using the provided details.
	 *
	 * @return bool whether the user is registered successfully
	 */
	public function register()
	{
		if ($this->validate()) {
			$user = new Users();
			if ($user->load(['Users' => $this])) {
				$user->createdBy = 1;
				$user->userStatusId = 1;
				$user->firstName = $this->firstName;
				$user->lastName = $this->lastName;
				$user->mobile = $this->mobile;
				$user->email = $this->email;
				$user->password = $this->password;
				$user->confirmPassword = $this->confirmPassword;
				$user->passwordHash = Yii::$app->security->generatePasswordHash($this->password);
				$user->authKey = Yii::$app->security->generateRandomString();
				if ($user->save()) {
					return true;
				}
			}	
		}
		
		return false;
	}
}
