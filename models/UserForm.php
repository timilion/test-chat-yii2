<?php

namespace app\models;

use Yii;
use yii\base\Model;


class UserForm extends Model
{
    public $id;
    public $login;
    public $role;
    public $created_at;
    public $_user;


    /**
     * @return array[]
     */
    public function rules()
    {
        return [
            [['role'], 'string'],
            [['role'], 'required'],
            [['role'], 'trim'],

        ];
    }

    /**
     * @return string[]
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Логин',
            'created_at' => 'Создано',
            'role' => 'Роль'
        ];
    }


    /**
     * @param User $model
     * @return $this
     */
    public function setModel(User $model)
    {
        $this->_user = $model;
        $this->id = $model->id;
        $this->login = $model->login;
        $this->role = $model->role->item_name;
        return $this;
    }


    /**
     * @return User
     */
    public function getModel()
    {
        if (!$this->_user) {
            $this->_user = new User();
        }
        return $this->_user;
    }


    /**
     * @return bool|null
     * @throws \Exception
     */
    public function save()
    {
        if ($this->validate()) {
            $model = $this->getModel();
            $manager = Yii::$app->authManager;
            $item = $manager->getRole($model->role->item_name);
            $item = $item ?: User::ROLE_USER;
            $manager->revoke($item,$model->getId());
            $authorRole = $manager->getRole($this->role);
            $manager->assign($authorRole, $model->getId());
            return !$model->hasErrors();
        }
        return null;
    }
}
