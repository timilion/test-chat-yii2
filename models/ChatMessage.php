<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "chat_message".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $text
 * @property int|null $status
 * @property int|null $created_at
 */
class ChatMessage extends \yii\db\ActiveRecord
{

    const STATUS_INCORRECT = 0;
    const STATUS_CORRECTLY = 1;

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
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chat_message';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'status', 'created_at'], 'integer'],
            [['text'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'text' => 'Text',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return $this->user->role->item_name === User::ROLE_ADMIN;
    }

    /**
     * @return bool
     */
    public function isStatus()
    {
        return $this->status === self::STATUS_CORRECTLY;
    }
}
