<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
$this->title = 'Send Notification';
?>
<div class="card shadow border-0">
    <div class="card-header bg-warning text-dark">
        <h4 class="mb-0">🔔 Send Notification</h4>
    </div>
    <div class="card-body">
        <form method="post" action="/pharma-wholesale/web/index.php?r=admin/send-notification">
            <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->getCsrfToken()) ?>
            <div class="mb-3">
                <label class="form-label fw-bold">Recipient</label>
                <select name="recipient" class="form-select">
                    <option value="all">📢 All Customers</option>
                    <?php foreach ($customers as $customer): ?>
                        <option value="<?= $customer->id ?>">
                            <?= Html::encode($customer->username) ?> (<?= Html::encode($customer->email) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Notification Type</label>
                <select name="type" class="form-select">
                    <option value="info">ℹ️ Info</option>
                    <option value="success">✅ Success</option>
                    <option value="warning">⚠️ Warning</option>
                    <option value="danger">🚨 Urgent</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Title</label>
                <input type="text" name="title" class="form-control" placeholder="Notification title" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Message</label>
                <textarea name="message" class="form-control" rows="4" placeholder="Type your message here..." required></textarea>
            </div>
            <button type="submit" class="btn btn-warning btn-lg">🔔 Send Notification</button>
            <?= Html::a('Cancel', ['/admin/index'], ['class' => 'btn btn-secondary btn-lg ms-2']) ?>
        </form>
    </div>
</div>