<?php
namespace app\models;
use Yii;
use yii\db\ActiveRecord;
use app\models\Category;
use app\models\Cart;
use app\models\OrderItems;
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
 * @property Category $category
 * @property OrderItems[] $orderItems
 */
class Product extends ActiveRecord
{
    public static function tableName()
    {
        return 'products';
    }
    public function rules()
    {
        return [
            [['description', 'manufacturer', 'dosage_form', 'image'], 'default', 'value' => null],
            [['stock_qty'], 'default', 'value' => 0],
            [['moq'], 'default', 'value' => 1],
            [['status'], 'default', 'value' => 1],
            [['category_id', 'name', 'price'], 'required'],
            [['category_id', 'stock_qty', 'moq', 'status'], 'integer'],
            [['description'], 'string'],
            [['price'], 'number'],
            [['name', 'image'], 'string', 'max' => 255],
            [['manufacturer', 'dosage_form'], 'string', 'max' => 100],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
        ];
    }
    public function attributeLabels()
    {
        return [
            'id'           => 'ID',
            'category_id'  => 'Category',
            'name'         => 'Product Name',
            'description'  => 'Description',
            'price'        => 'Price (TZS)',
            'stock_qty'    => 'Stock Quantity',
            'moq'          => 'Minimum Order Quantity',
            'manufacturer' => 'Manufacturer',
            'dosage_form'  => 'Dosage Form',
            'image'        => 'Image',
            'status'       => 'Status',
            'created_at'   => 'Created At',
            'updated_at'   => 'Updated At',
        ];
    }
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->created_at = time();
            }
            $this->updated_at = time();
            return true;
        }
        return false;
    }
    public function getCarts()
    {
        return $this->hasMany(Cart::class, ['product_id' => 'id']);
    }
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }
    public function getOrderItems()
    {
        return $this->hasMany(OrderItems::class, ['product_id' => 'id']);
    }
}