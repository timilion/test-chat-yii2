<?php


namespace app\models;


use Yii;
use yii\base\Model;

class LoginForm extends Model
{
    const SCENARIO_REGISTER = 'registr';
    const SCENARIO_LOGIN = 'login';

    public $login;
    public $password;
    public $error;
    public $_user;


    public function rules()
    {
        return [
            [['login', 'password'], 'required'],
            ['login', 'string', 'min' => 3, 'max' => 20],
            ['password', 'string', 'min' => 5, 'max' => 32],
            ['password', 'validatePassword', 'on' => self::SCENARIO_LOGIN],
            ['login', 'unique', 'targetClass' =>  User::class, 'message' => 'login уже зарегистрирован', 'on' => self::SCENARIO_REGISTER]
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
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError('error', 'Incorrect login or password.');
            }
        }
    }

    /**
     * @return string[]
     */
    public function attributeLabels()
    {
        return [
            'login' => 'Логин',
            'password' => 'Пароль'
        ];
    }

    /**
     * Logs in a user using the provided login and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), 0);
        }

        return false;
    }


    public function register()
    {
        if ($this->validate()) {
            $model = new User();
            $model->login = $this->login;
            $model->password_hash = Yii::$app->getSecurity()->generatePasswordHash($this->password);
            $model->auth_key = Yii::$app->security->generateRandomString();
            return $model->save();
        }
        return false;
    }

    /**
     * @return User
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $user = User::findByLogin($this->login);
            if ($user) {
                $this->_user = $user;
            }
        }

        return $this->_user;
    }
}