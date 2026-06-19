<?php
use yii\helpers\Html;
$this->title = 'Customer Details';
?>
<div class="card shadow border-0">
    <div class="card-header bg-primary text-white d-flex justify-content-between">
        <h4 class="mb-0">👤 Customer: <?= Html::encode($customer->username) ?></h4>
        <?= Html::a('← Back', ['/admin/customers'], ['class' => 'btn btn-light btn-sm']) ?>
    </div>
    <div class="card-body">
        <table class="table">
            <tr><th>Username</th><td><?= Html::encode($customer->username) ?></td></tr>
            <tr><th>Email</th><td><?= Html::encode($customer->email) ?></td></tr>
            <tr><th>Company</th><td><?= Html::encode($customer->company_name ?: '—') ?></td></tr>
            <tr><th>Phone</th><td><?= Html::encode($customer->phone ?: '—') ?></td></tr>
            <tr><th>Address</th><td><?= Html::encode($customer->address ?: '—') ?></td></tr>
            <tr><th>Status</th><td><?= $customer->status === 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>' ?></td></tr>
            <tr><th>Role</th><td><?= Html::encode($customer->role) ?></td></tr>
        </table>
    </div>
</div>