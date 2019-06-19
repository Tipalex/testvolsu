<?php

use yii\db\Migration;

class m190619_193906_create_table_user_answers extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user_answers}}', [
            'id' => $this->primaryKey(),
            'user' => $this->integer()->defaultValue('0'),
            'test' => $this->integer()->defaultValue('0'),
            'question' => $this->integer()->defaultValue('0'),
            'answer' => $this->string(),
            'score' => $this->integer(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%user_answers}}');
    }
}
