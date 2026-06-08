<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%orders}}`.
 */
class m260525_131941_create_orders_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%orders}}', [
            'id'               => $this->primaryKey(),
            'user_id'          => $this->integer()->notNull(),
            'total_amount'     => $this->decimal(10, 2)->notNull(),
            'status'           => $this->string(20)->notNull()->defaultValue('pending'),
            'delivery_address' => $this->text()->notNull(),
            'notes'            => $this->text(),
            'created_at'       => $this->integer()->notNull(),
            'updated_at'       => $this->integer()->notNull(),
        ]);

        // Foreign key linking order to user
        $this->addForeignKey(
            'fk-orders-user_id',
            '{{%orders}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-orders-user_id', '{{%orders}}');
        $this->dropTable('{{%orders}}');
    }
}