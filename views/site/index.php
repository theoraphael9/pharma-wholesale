<?php
/** @var yii\web\View $this */
use yii\helpers\Html;
$this->title = 'PharmaWholesale - Home';
$isGuest = Yii::$app->user->isGuest;
?>
<div class="pharma-home">

    <!-- Hero -->
    <div class="p-5 mb-4 rounded text-white" style="background: linear-gradient(135deg, #0d6efd, #0a9396);">
        <h1 class="display-5 fw-bold">⚕️ PharmaWholesale</h1>
        <p class="lead">Your trusted partner for pharmaceutical wholesale supply across Tanzania.</p>
        <?php if ($isGuest): ?>
            <?= Html::a('Create an Account', ['/site/signup'], ['class' => 'btn btn-light btn-lg me-2']) ?>
            <?= Html::a('Login', ['/site/login'], ['class' => 'btn btn-outline-light btn-lg']) ?>
        <?php else: ?>
            <?= Html::a('Browse Products', ['/product/index'], ['class' => 'btn btn-light btn-lg']) ?>
        <?php endif; ?>
    </div>

    <!-- Quick Links -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card text-center h-100 shadow border-0">
                <div class="card-body">
                    <h2>💊</h2>
                    <h5>Browse Products</h5>
                    <p class="text-muted small">Explore our full pharmaceutical catalogue</p>
                    <?= Html::a('View Products', ['/product/index'], ['class' => 'btn btn-primary btn-sm']) ?>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-center h-100 shadow border-0">
                <div class="card-body">
                    <h2>🛒</h2>
                    <h5>My Cart</h5>
                    <p class="text-muted small">Review items before placing an order</p>
                    <?= Html::a('View Cart', ['/cart/index'], ['class' => 'btn btn-success btn-sm']) ?>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-center h-100 shadow border-0">
                <div class="card-body">
                    <h2>📦</h2>
                    <h5>My Orders</h5>
                    <p class="text-muted small">Track your order status</p>
                    <?= Html::a('View Orders', ['/order/index'], ['class' => 'btn btn-warning btn-sm']) ?>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-center h-100 shadow border-0">
                <div class="card-body">
                    <h2>🔔</h2>
                    <h5>Notifications</h5>
                    <p class="text-muted small">Stay updated on your orders</p>
                    <?= Html::a('View Notifications', ['/notification/index'], ['class' => 'btn btn-info btn-sm']) ?>
                </div>
            </div>
        </div>
    </div>

</div>