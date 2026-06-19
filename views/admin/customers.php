<?php
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Manage Customers';
?>

<h2 class="mb-4">👥 Manage Customers</h2>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'username',
        'email',
        'company_name',
        'phone',
        'address',
        [
            'attribute' => 'status',
            'format' => 'raw',
            'value' => function($model) {
                return $model->status === 1
                    ? '<span class="badge bg-success">Active</span>'
                    : '<span class="badge bg-danger">Inactive</span>';
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view} {toggle}',
            'buttons' => [
                'view' => function($url, $model) {
                    return Html::a('👁️ View', ['/admin/view-customer', 'id' => $model->id],
                        ['class' => 'btn btn-sm btn-outline-primary me-1']);
                },
                'toggle' => function($url, $model) {
                    $label = $model->status === 1 ? '🚫 Deactivate' : '✅ Activate';
                    $class = $model->status === 1 ? 'btn-outline-danger' : 'btn-outline-success';
                    return Html::a($label, ['/admin/toggle-customer-status', 'id' => $model->id], [
                        'class' => "btn btn-sm $class",
                        'data-method' => 'post',
                        'data-confirm' => 'Are you sure you want to change this customer\'s status?',
                    ]);
                },
            ],
        ],
    ],
]); ?>