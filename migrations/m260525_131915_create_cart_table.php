<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cart}}`.
 */
class m260525_131915_create_cart_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%cart}}', [
            'id'         => $this->primaryKey(),
            'user_id'    => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
            'quantity'   => $this->integer()->notNull()->defaultValue(1),
            'added_at'   => $this->integer()->notNull(),
        ]);

        // Foreign key linking cart to user
        $this->addForeignKey(
            'fk-cart-user_id',
            '{{%cart}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );

        // Foreign key linking cart to product
        $this->addForeignKey(
            'fk-cart-product_id',
            '{{%cart}}',
            'product_id',
            '{{%products}}',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-cart-user_id', '{{%cart}}');
        $this->dropForeignKey('fk-cart-product_id', '{{%cart}}');
        $this->dropTable('{{%cart}}');
    }
}