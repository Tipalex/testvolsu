<?php

use yii\db\Migration;

class m190619_193905_create_table_group_discipline extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%group_discipline}}', [
            'id' => $this->primaryKey(),
            'groupe' => $this->integer()->defaultValue('0'),
            'discipline' => $this->integer()->defaultValue('0'),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%group_discipline}}');
    }
}
