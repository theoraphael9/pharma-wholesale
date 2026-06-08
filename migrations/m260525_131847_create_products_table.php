<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%products}}`.
 */
class m260525_131847_create_products_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%products}}', [
            'id'           => $this->primaryKey(),
            'category_id'  => $this->integer()->notNull(),
            'name'         => $this->string(255)->notNull(),
            'description'  => $this->text(),
            'price'        => $this->decimal(10, 2)->notNull(),
            'stock_qty'    => $this->integer()->notNull()->defaultValue(0),
            'moq'          => $this->integer()->notNull()->defaultValue(1),
            'manufacturer' => $this->string(100),
            'dosage_form'  => $this->string(100),
            'image'        => $this->string(255),
            'status'       => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at'   => $this->integer()->notNull(),
            'updated_at'   => $this->integer()->notNull(),
        ]);

        // Foreign key linking product to its category
        $this->addForeignKey(
            'fk-products-category_id',
            '{{%products}}',
            'category_id',
            '{{%categories}}',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-products-category_id', '{{%products}}');
        $this->dropTable('{{%products}}');
    }
}