<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order_items}}`.
 */
class m260525_132015_create_order_items_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%order_items}}', [
            'id'         => $this->primaryKey(),
            'order_id'   => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
            'quantity'   => $this->integer()->notNull(),
            'unit_price' => $this->decimal(10, 2)->notNull(),
            'subtotal'   => $this->decimal(10, 2)->notNull(),
        ]);

        // Foreign key linking order items to order
        $this->addForeignKey(
            'fk-order_items-order_id',
            '{{%order_items}}',
            'order_id',
            '{{%orders}}',
            'id',
            'CASCADE'
        );

        // Foreign key linking order items to product
        $this->addForeignKey(
            'fk-order_items-product_id',
            '{{%order_items}}',
            'product_id',
            '{{%products}}',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-order_items-order_id', '{{%order_items}}');
        $this->dropForeignKey('fk-order_items-product_id', '{{%order_items}}');
        $this->dropTable('{{%order_items}}');
    }
}