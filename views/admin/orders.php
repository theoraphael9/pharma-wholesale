<?php
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Manage Orders';
?>

<h2 class="mb-4">📦 Manage Orders</h2>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'id',
        [
            'label' => 'Customer',
            'value' => function($model) {
                return $model->user->username ?? 'N/A';
            }
        ],
        [
            'attribute' => 'total_amount',
            'value' => function($model) {
                return 'TZS ' . number_format($model->total_amount, 0);
            }
        ],
        [
            'attribute' => 'status',
            'format' => 'raw',
            'value' => function($model) {
                $class = match($model->status) {
                    'pending'    => 'warning',
                    'confirmed'  => 'info',
                    'processing' => 'primary',
                    'shipped'    => 'secondary',
                    'delivered'  => 'success',
                    'cancelled'  => 'danger',
                    default      => 'secondary',
                };
                return '<span class="badge bg-' . $class . '">' . ucfirst($model->status) . '</span>';
            }
        ],
        [
            'label' => 'Date',
            'value' => function($model) {
                return date('d M Y', $model->created_at);
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view} {update-status}',
            'buttons' => [
                'view' => function($url, $model) {
                    return Html::a('👁️ View', ['/admin/view-order', 'id' => $model->id],
                        ['class' => 'btn btn-sm btn-outline-primary me-1']);
                },
                'update-status' => function($url, $model) {
                    $statuses = ['pending','confirmed','processing','shipped','delivered','cancelled'];
                    $form = '<form method="post" action="/pharma-wholesale/web/index.php?r=admin/update-order-status&id=' . $model->id . '" style="display:inline">';
                    $form .= \yii\helpers\Html::hiddenInput(\Yii::$app->request->csrfParam, \Yii::$app->request->getCsrfToken());
                    $form .= '<select name="status" class="form-select form-select-sm d-inline w-auto" onchange="this.form.submit()">';
                    foreach ($statuses as $s) {
                        $selected = $model->status === $s ? 'selected' : '';
                        $form .= "<option value='$s' $selected>" . ucfirst($s) . "</option>";
                    }
                    $form .= '</select></form>';
                    return $form;
                },
            ],
        ],
    ],
]); ?>