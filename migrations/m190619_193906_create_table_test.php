<?php

use yii\db\Migration;

class m190619_193906_create_table_test extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%test}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'discipline' => $this->integer()->defaultValue('0'),
            'time' => $this->smallInteger()->defaultValue('0'),
            'dateOfStart' => $this->date(),
            'dateOfEnd' => $this->date(),
            'description' => $this->text(),
            'type' => $this->string()->defaultValue('test'),
            'filePath' => $this->text(),
            'isPublished' => $this->tinyInteger()->defaultValue('0'),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%test}}');
    }
}
