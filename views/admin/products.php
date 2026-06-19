<?php
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Manage Products';
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>💊 Manage Products</h2>
    <?= Html::a('+ Add New Product', ['/admin/create-product'], ['class' => 'btn btn-primary']) ?>
</div>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'name',
        [
            'attribute' => 'category_id',
            'label' => 'Category',
            'value' => function($model) {
                return $model->category->name ?? 'N/A';
            }
        ],
        [
            'attribute' => 'price',
            'value' => function($model) {
                return 'TZS ' . number_format($model->price, 0);
            }
        ],
        [
            'attribute' => 'stock_qty',
            'label' => 'Stock',
            'value' => function($model) {
                return $model->stock_qty;
            },
            'contentOptions' => function($model) {
                return $model->stock_qty <= 10 
                    ? ['class' => 'text-danger fw-bold'] 
                    : [];
            }
        ],
        'moq',
        'manufacturer',
        [
            'attribute' => 'status',
            'value' => function($model) {
                return $model->status === 1 ? 'Active' : 'Inactive';
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{edit} {delete}',
            'buttons' => [
                'edit' => function($url, $model) {
                    return Html::a('✏️ Edit', ['/admin/edit-product', 'id' => $model->id], 
                        ['class' => 'btn btn-sm btn-outline-primary me-1']);
                },
                'delete' => function($url, $model) {
                    return Html::a('🗑️ Delete', ['/admin/delete-product', 'id' => $model->id], [
                        'class' => 'btn btn-sm btn-outline-danger',
                        'data-confirm' => 'Are you sure you want to delete this product?',
                        'data-method' => 'post',
                    ]);
                },
            ],
        ],
    ],
]); ?>