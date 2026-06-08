<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "products".
 *
 * @property int $id
 * @property int $category_id
 * @property string $name
 * @property string|null $description
 * @property float $price
 * @property int $stock_qty
 * @property int $moq
 * @property string|null $manufacturer
 * @property string|null $dosage_form
 * @property string|null $image
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Cart[] $carts
 * @property Categories $category
 * @property OrderItems[] $orderItems
 */
class Product extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'manufacturer', 'dosage_form', 'image'], 'default', 'value' => null],
            [['stock_qty'], 'default', 'value' => 0],
            [['status'], 'default', 'value' => 1],
            [['category_id', 'name', 'price', 'created_at', 'updated_at'], 'required'],
            [['category_id', 'stock_qty', 'moq', 'status', 'created_at', 'updated_at'], 'integer'],
            [['description'], 'string'],
            [['price'], 'number'],
            [['name', 'image'], 'string', 'max' => 255],
            [['manufacturer', 'dosage_form'], 'string', 'max' => 100],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::class, 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'name' => 'Name',
            'description' => 'Description',
            'price' => 'Price',
            'stock_qty' => 'Stock Qty',
            'moq' => 'Moq',
            'manufacturer' => 'Manufacturer',
            'dosage_form' => 'Dosage Form',
            'image' => 'Image',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Carts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarts()
    {
        return $this->hasMany(Cart::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Categories::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[OrderItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItems::class, ['product_id' => 'id']);
    }

}
