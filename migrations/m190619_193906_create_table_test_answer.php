<?php

use yii\db\Migration;

class m190619_193906_create_table_test_answer extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%test_answer}}', [
            'id' => $this->primaryKey(),
            'question' => $this->integer()->defaultValue('0'),
            'answer' => $this->string(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%test_answer}}');
    }
}
