<?php

use yii\db\Migration;

class m190619_193905_create_table_materials extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%materials}}', [
            'id' => $this->primaryKey(),
            'discipline' => $this->integer(),
            'filePath' => $this->string(),
            'name' => $this->string(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%materials}}');
    }
}
