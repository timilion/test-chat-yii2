<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;
use yii\base\NotSupportedException;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string|null $login
 * @property string $password_hash
 * @property string|null $password_reset_token
 * @property string|null $verification_token
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{

    const ROLE_ADMIN = 'admin';
    const ROLE_USER = 'user';
    const GUEST = 'guest';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @return string[]
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Создано',
            'login' => 'Логин',
            'role.item_name' => 'Роль',
        ];
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     * @throws \Exception
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if($insert) {
            $auth = Yii::$app->authManager;
            $role = $auth->getRole(self::ROLE_USER);
            $auth->assign($role, $this->id);
        }

        Yii::$app->authManager->invalidateCache();
    }


    /**
     * @param int|string $id
     * @return User|IdentityInterface|null
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @param $login
     * @return User|null
     */
    public static function findByLogin($login)
    {
        return static::findOne(['login' => $login]);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string current user auth key
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return bool if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }


    /**
     * @param $password
     * @return bool
     */
    public function validatePassword($password)
    {
        return \Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(RbacAuthAssignment::class, ['user_id' => 'id']);
    }

    /**
     * @return array
     */
    public static function getRoleAll()
    {
        return ArrayHelper::map(Yii::$app->authManager->roles, 'name', 'name');
    }



}
