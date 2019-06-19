<?php

use yii\db\Migration;

class m190619_193905_create_table_discipline extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%discipline}}', [
            'id' => $this->primaryKey(),
            'teacher' => $this->integer()->notNull()->defaultValue('0'),
            'name' => $this->string(),
            'control' => $this->string(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%discipline}}');
    }
}
