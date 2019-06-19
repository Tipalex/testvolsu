<?php

use yii\db\Migration;

class m190619_193905_create_table_role extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%role}}', [
            'user_id' => $this->primaryKey(),
            'role' => $this->integer()->notNull()->defaultValue('0'),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%role}}');
    }
}
