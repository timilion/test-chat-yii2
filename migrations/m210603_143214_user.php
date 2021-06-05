<?php

use yii\db\Migration;

/**
 * Class m210603_143214_user
 */
class m210603_143214_user extends Migration
{
    public function up()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'login' => $this->string(),
            'password_hash' => $this->string()->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'verification_token' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
