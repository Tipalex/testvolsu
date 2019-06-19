<?php

use yii\db\Migration;

class m190619_193906_create_table_student_group extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%student_group}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%student_group}}');
    }
}
