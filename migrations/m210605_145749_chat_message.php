<?php

use yii\db\Migration;

/**
 * Class m210605_145749_chat_message
 */
class m210605_145749_chat_message extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%chat_message}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'text' => $this->string(),
            'status' => $this->smallInteger()->defaultValue(1),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%chat_message}}');
    }

}
