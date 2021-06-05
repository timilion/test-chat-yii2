<?php

use yii\db\Migration;

/**
 * Class m210603_144945_add_user
 */
class m210603_144945_add_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('{{%user}}', [
            'id' => 1,
            'login' => 'admin',
            'password_hash' => Yii::$app->getSecurity()->generatePasswordHash('admin'),
            'auth_key' => Yii::$app->security->generateRandomString(),
            'updated_at' => time(),
            'created_at' => time(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%user}}', [
            'id' => 1
        ]);
    }
}
