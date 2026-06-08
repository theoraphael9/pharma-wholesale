<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%categories}}`.
 */
class m260525_131656_create_categories_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%categories}}', [
            'id'          => $this->primaryKey(),
            'name'        => $this->string(100)->notNull()->unique(),
            'description' => $this->text(),
            'status'      => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at'  => $this->integer()->notNull(),
            'updated_at'  => $this->integer()->notNull(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%categories}}');
    }
}