<?php
/** @var yii\web\View $this */
/** @var array $stats */
/** @var app\models\Order[] $recent_orders */
/** @var app\models\User[] $recent_customers */
/** @var app\models\Product[] $low_stock_products */

use yii\helpers\Html;

$this->title = 'Admin Dashboard';
?>

<div class="admin-dashboard">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0">🛡️ Admin Dashboard</h2>
            <small class="text-muted">Welcome back, <?= Html::encode(Yii::$app->user->identity->username) ?></small>
        </div>
        <div class="d-flex gap-2">
            <?= Html::a('+ Add Product', ['/admin/create-product'], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('🔔 Send Notification', ['/admin/send-notification'], ['class' => 'btn btn-warning']) ?>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card bg-primary text-white shadow h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-1">Total Products</h6>
                        <h2 class="mb-0"><?= $stats['total_products'] ?></h2>
                    </div>
                    <span style="font-size:2.5rem;">💊</span>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <?= Html::a('Manage Products →', ['/admin/products'], ['class' => 'text-white small']) ?>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-success text-white shadow h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-1">Total Customers</h6>
                        <h2 class="mb-0"><?= $stats['total_customers'] ?></h2>
                    </div>
                    <span style="font-size:2.5rem;">👥</span>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <?= Html::a('Manage Customers →', ['/admin/customers'], ['class' => 'text-white small']) ?>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-warning text-white shadow h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-1">Pending Orders</h6>
                        <h2 class="mb-0"><?= $stats['pending_orders'] ?></h2>
                    </div>
                    <span style="font-size:2.5rem;">🛒</span>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <?= Html::a('View Orders →', ['/admin/orders'], ['class' => 'text-white small']) ?>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-info text-white shadow h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-1">Total Revenue</h6>
                        <h2 class="mb-0">TZS <?= number_format($stats['total_revenue'], 0) ?></h2>
                    </div>
                    <span style="font-size:2.5rem;">💰</span>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <span class="text-white small">Confirmed + Delivered Orders</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Second Stats Row -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card border-danger shadow h-100">
                <div class="card-body text-center">
                    <h1 class="text-danger"><?= $stats['low_stock'] ?></h1>
                    <p class="mb-0">⚠️ Low Stock Products</p>
                    <small class="text-muted">Products with 10 or fewer units</small>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-success shadow h-100">
                <div class="card-body text-center">
                    <h1 class="text-success"><?= $stats['confirmed_orders'] ?></h1>
                    <p class="mb-0">✅ Confirmed Orders</p>
                    <small class="text-muted">Ready for processing</small>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-primary shadow h-100">
                <div class="card-body text-center">
                    <h1 class="text-primary"><?= $stats['total_orders'] ?></h1>
                    <p class="mb-0">📦 Total Orders</p>
                    <small class="text-muted">All time</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Recent Orders -->
        <div class="col-md-6 mb-4">
            <div class="card shadow border-0 h-100">
                <div class="card-header bg-dark text-white d-flex justify-content-between">
                    <span>🛒 Recent Orders</span>
                    <?= Html::a('View All', ['/admin/orders'], ['class' => 'text-white small']) ?>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Customer</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (empty($recent_orders)): ?>
                            <tr><td colspan="4" class="text-center text-muted py-3">No orders yet</td></tr>
                        <?php else: ?>
                            <?php foreach ($recent_orders as $order): ?>
                            <tr>
                                <td><?= $order->id ?></td>
                                <td><?= Html::encode($order->user->username ?? 'N/A') ?></td>
                                <td>TZS <?= number_format($order->total_amount, 0) ?></td>
                                <td>
                                    <?php
                                    $badgeClass = match($order->status) {
                                        'pending'    => 'warning',
                                        'confirmed'  => 'info',
                                        'processing' => 'primary',
                                        'shipped'    => 'secondary',
                                        'delivered'  => 'success',
                                        'cancelled'  => 'danger',
                                        default      => 'secondary',
                                    };
                                    ?>
                                    <span class="badge bg-<?= $badgeClass ?>">
                                        <?= ucfirst($order->status) ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Low Stock Alerts -->
        <div class="col-md-6 mb-4">
            <div class="card shadow border-0 h-100">
                <div class="card-header bg-danger text-white d-flex justify-content-between">
                    <span>⚠️ Low Stock Alerts</span>
                    <?= Html::a('View All', ['/admin/products'], ['class' => 'text-white small']) ?>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Product</th>
                                <th>Category</th>
                                <th>Stock</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (empty($low_stock_products)): ?>
                            <tr><td colspan="4" class="text-center text-muted py-3">✅ All products sufficiently stocked</td></tr>
                        <?php else: ?>
                            <?php foreach ($low_stock_products as $product): ?>
                            <tr>
                                <td><?= Html::encode($product->name) ?></td>
                                <td><?= Html::encode($product->category->name ?? 'N/A') ?></td>
                                <td><span class="badge bg-danger"><?= $product->stock_qty ?> left</span></td>
                                <td><?= Html::a('Edit', ['/admin/edit-product', 'id' => $product->id], ['class' => 'btn btn-sm btn-outline-primary']) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Customers -->
    <div class="card shadow border-0 mb-4">
        <div class="card-header bg-success text-white d-flex justify-content-between">
            <span>👥 Recent Customers</span>
            <?= Html::a('View All', ['/admin/customers'], ['class' => 'text-white small']) ?>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Company</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (empty($recent_customers)): ?>
                    <tr><td colspan="7" class="text-center text-muted py-3">No customers registered yet</td></tr>
                <?php else: ?>
                    <?php foreach ($recent_customers as $customer): ?>
                    <tr>
                        <td><?= $customer->id ?></td>
                        <td><?= Html::encode($customer->username) ?></td>
                        <td><?= Html::encode($customer->email) ?></td>
                        <td><?= Html::encode($customer->company_name ?: '—') ?></td>
                        <td><?= Html::encode($customer->phone ?: '—') ?></td>
                        <td>
                            <span class="badge bg-<?= $customer->status === 1 ? 'success' : 'danger' ?>">
                                <?= $customer->status === 1 ? 'Active' : 'Inactive' ?>
                            </span>
                        </td>
                        <td>
                            <?= Html::a('View', ['/admin/view-customer', 'id' => $customer->id], ['class' => 'btn btn-sm btn-outline-primary']) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>