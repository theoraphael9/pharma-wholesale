<?php
use yii\helpers\Html;
$this->title = 'Order #' . $order->id;
?>
<div class="card shadow border-0">
    <div class="card-header bg-dark text-white d-flex justify-content-between">
        <h4 class="mb-0">📦 Order #<?= $order->id ?></h4>
        <?= Html::a('← Back', ['/admin/orders'], ['class' => 'btn btn-light btn-sm']) ?>
    </div>
    <div class="card-body">
        <table class="table">
            <tr><th>Customer</th><td><?= Html::encode($order->user->username ?? 'N/A') ?></td></tr>
            <tr><th>Total Amount</th><td>TZS <?= number_format($order->total_amount, 0) ?></td></tr>
            <tr><th>Status</th><td><span class="badge bg-warning"><?= ucfirst($order->status) ?></span></td></tr>
            <tr><th>Delivery Address</th><td><?= Html::encode($order->delivery_address) ?></td></tr>
            <tr><th>Notes</th><td><?= Html::encode($order->notes ?: '—') ?></td></tr>
            <tr><th>Date Placed</th><td><?= date('d M Y H:i', $order->created_at) ?></td></tr>
        </table>
        <h5 class="mt-4">📋 Order Items</h5>
        <table class="table table-bordered">
            <thead class="table-light">
                <tr><th>Product</th><th>Qty</th><th>Unit Price</th><th>Subtotal</th></tr>
            </thead>
            <tbody>
            <?php foreach ($order->orderItems as $item): ?>
                <tr>
                    <td><?= Html::encode($item->product->name ?? 'N/A') ?></td>
                    <td><?= $item->quantity ?></td>
                    <td>TZS <?= number_format($item->unit_price, 0) ?></td>
                    <td>TZS <?= number_format($item->subtotal, 0) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>