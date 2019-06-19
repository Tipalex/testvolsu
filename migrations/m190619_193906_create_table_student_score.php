<?php

use yii\db\Migration;

class m190619_193906_create_table_student_score extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%student_score}}', [
            'id' => $this->primaryKey(),
            'test_id' => $this->integer()->defaultValue('0'),
            'score' => $this->integer()->defaultValue('0'),
            'user' => $this->integer()->defaultValue('0'),
            'discipline' => $this->integer()->defaultValue('0'),
            'status' => $this->string(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%student_score}}');
    }
}
