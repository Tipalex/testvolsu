<?php

use yii\db\Migration;

class m190619_193906_create_table_user extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'login' => $this->string()->notNull()->defaultValue(''),
            'password' => $this->string()->notNull()->defaultValue(''),
            'firstname' => $this->string()->notNull()->defaultValue(''),
            'lastname' => $this->string()->notNull()->defaultValue(''),
            'middlename' => $this->string(),
            'email' => $this->string()->notNull()->defaultValue(''),
            'authKey' => $this->char()->notNull()->defaultValue(''),
            'role' => $this->string()->notNull()->defaultValue('студент'),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
