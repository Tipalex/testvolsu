<?php

use yii\db\Migration;

class m190619_193906_create_table_student extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%student}}', [
            'user' => $this->integer()->notNull()->defaultValue('0'),
            's_group' => $this->integer()->defaultValue('0'),
            'id' => $this->primaryKey(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%student}}');
    }
}
