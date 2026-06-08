<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m260525_131513_create_users_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id'             => $this->primaryKey(),
            'username'       => $this->string(50)->notNull()->unique(),
            'email'          => $this->string(100)->notNull()->unique(),
            'password_hash'  => $this->string(255)->notNull(),
            'role'           => $this->string(20)->notNull()->defaultValue('customer'),
            'phone'          => $this->string(20),
            'address'        => $this->text(),
            'company_name'   => $this->string(100),
            'status'         => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at'     => $this->integer()->notNull(),
            'updated_at'     => $this->integer()->notNull(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%users}}');
    }
}