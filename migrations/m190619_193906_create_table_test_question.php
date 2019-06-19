<?php

use yii\db\Migration;

class m190619_193906_create_table_test_question extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%test_question}}', [
            'id' => $this->primaryKey(),
            'test' => $this->integer()->defaultValue('0'),
            'question' => $this->string(),
            'type' => $this->string()->defaultValue('0'),
            'image' => $this->string(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%test_question}}');
    }
}
