<?php
namespace app\controllers;
use Yii;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use app\models\User;
use app\models\Product;
use app\models\Order;
use app\models\Category;
use app\models\Notification;
class AdminController extends \yii\web\Controller
{
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'denyCallback' => function ($rule, $action) {
                    if (Yii::$app->user->isGuest) {
                        Yii::$app->response->redirect(['/site/login'])->send();
                        exit;
                    }
                    throw new ForbiddenHttpException('You are not authorized.');
                },
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return !Yii::$app->user->isGuest
                                && Yii::$app->user->identity->isAdmin();
                        },
                    ],
                ],
            ],
        ];
    }
    public function actionIndex(): string
    {
        $stats = [
            'total_products'   => Product::find()->count(),
            'total_customers'  => User::find()->where(['role' => User::ROLE_CUSTOMER])->count(),
            'total_orders'     => Order::find()->count(),
            'pending_orders'   => Order::find()->where(['status' => 'pending'])->count(),
            'confirmed_orders' => Order::find()->where(['status' => 'confirmed'])->count(),
            'total_revenue'    => Order::find()->where(['status' => ['confirmed','processing','shipped','delivered']])->sum('total_amount') ?? 0,
            'low_stock'        => Product::find()->where(['<=', 'stock_qty', 10])->count(),
        ];
        $recent_orders      = Order::find()->orderBy(['created_at' => SORT_DESC])->limit(5)->all();
        $recent_customers   = User::find()->where(['role' => User::ROLE_CUSTOMER])->orderBy(['created_at' => SORT_DESC])->limit(5)->all();
        $low_stock_products = Product::find()->where(['<=', 'stock_qty', 10])->limit(5)->all();
        return $this->render('index', [
            'stats'              => $stats,
            'recent_orders'      => $recent_orders,
            'recent_customers'   => $recent_customers,
            'low_stock_products' => $low_stock_products,
        ]);
    }
    public function actionCustomers(): string
    {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find()->where(['role' => User::ROLE_CUSTOMER])->orderBy(['created_at' => SORT_DESC]),
            'pagination' => ['pageSize' => 20],
        ]);
        return $this->render('customers', ['dataProvider' => $dataProvider]);
    }
    public function actionViewCustomer(int $id): string
    {
        $customer = User::findOne($id);
        if ($customer === null) {
            throw new NotFoundHttpException('Customer not found.');
        }
        return $this->render('view-customer', ['customer' => $customer]);
    }
    public function actionToggleCustomerStatus(int $id): Response
    {
        $customer = User::findOne($id);
        if ($customer !== null) {
            $customer->status = ($customer->status === User::STATUS_ACTIVE)
                ? User::STATUS_INACTIVE
                : User::STATUS_ACTIVE;
            $customer->save(false);
            Yii::$app->session->setFlash('success', 'Customer status updated.');
        }
        return $this->redirect(['admin/customers']);
    }
    public function actionProducts(): string
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Product::find()->orderBy(['created_at' => SORT_DESC]),
            'pagination' => ['pageSize' => 20],
        ]);
        return $this->render('products', ['dataProvider' => $dataProvider]);
    }
   public function actionCreateProduct(): string|Response
{
    $model = new Product();
    if ($model->load(Yii::$app->request->post())) {
        if ($model->save()) {
            Yii::$app->session->setFlash('success', 'Product created successfully.');
            return $this->redirect(['admin/products']);
        } else {
            Yii::$app->session->setFlash('error', 'Could not save: ' . implode(' | ', $model->getErrorSummary(true)));
        }
    }
    $categories = ArrayHelper::map(Category::find()->all(), 'id', 'name');
    return $this->render('create-product', ['model' => $model, 'categories' => $categories]);
}
    public function actionEditProduct(int $id): string|Response
{
    $model = Product::findOne($id);
    if ($model === null) {
        throw new NotFoundHttpException('Product not found.');
    }
    if ($model->load(Yii::$app->request->post())) {
        if ($model->save()) {
            Yii::$app->session->setFlash('success', 'Product updated successfully.');
            return $this->redirect(['admin/products']);
        } else {
            Yii::$app->session->setFlash('error', 'Could not save: ' . implode(' | ', $model->getErrorSummary(true)));
        }
    }
    $categories = ArrayHelper::map(Category::find()->all(), 'id', 'name');
    return $this->render('edit-product', ['model' => $model, 'categories' => $categories]);
}
    public function actionDeleteProduct(int $id): Response
    {
        $model = Product::findOne($id);
        if ($model !== null) {
            $model->delete();
            Yii::$app->session->setFlash('success', 'Product deleted.');
        }
        return $this->redirect(['admin/products']);
    }
    public function actionOrders(): string
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Order::find()->orderBy(['created_at' => SORT_DESC]),
            'pagination' => ['pageSize' => 20],
        ]);
        return $this->render('orders', ['dataProvider' => $dataProvider]);
    }
    public function actionViewOrder(int $id): string
    {
        $order = Order::findOne($id);
        if ($order === null) {
            throw new NotFoundHttpException('Order not found.');
        }
        return $this->render('view-order', ['order' => $order]);
    }
    public function actionUpdateOrderStatus(int $id): Response
    {
        $order  = Order::findOne($id);
        $status = Yii::$app->request->post('status');
        $valid  = ['pending','confirmed','processing','shipped','delivered','cancelled'];
        if ($order !== null && in_array($status, $valid, true)) {
            $order->status = $status;
            $order->save(false);
            $notif             = new Notification();
            $notif->user_id    = $order->user_id;
            $notif->title      = 'Order Update';
            $notif->message    = "Your order #{$order->id} status is now: " . strtoupper($status);
            $notif->type       = 'info';
            $notif->is_read    = 0;
            $notif->created_at = time();
            $notif->save();
            Yii::$app->session->setFlash('success', "Order #{$id} updated to {$status}.");
        }
        return $this->redirect(['admin/orders']);
    }
    public function actionSendNotification(): string|Response
    {
        if (Yii::$app->request->isPost) {
            $post      = Yii::$app->request->post();
            $recipient = $post['recipient'] ?? 'all';
            $title     = $post['title']     ?? '';
            $message   = $post['message']   ?? '';
            $type      = $post['type']      ?? 'info';
            if ($recipient === 'all') {
                $customers = User::find()->where(['role' => User::ROLE_CUSTOMER])->all();
                foreach ($customers as $customer) {
                    $notif             = new Notification();
                    $notif->user_id    = $customer->id;
                    $notif->title      = $title;
                    $notif->message    = $message;
                    $notif->type       = $type;
                    $notif->is_read    = 0;
                    $notif->created_at = time();
                    $notif->save();
                }
            } else {
                $notif             = new Notification();
                $notif->user_id    = (int) $recipient;
                $notif->title      = $title;
                $notif->message    = $message;
                $notif->type       = $type;
                $notif->is_read    = 0;
                $notif->created_at = time();
                $notif->save();
            }
            Yii::$app->session->setFlash('success', 'Notification sent.');
            return $this->redirect(['admin/index']);
        }
        $customers = User::find()->where(['role' => User::ROLE_CUSTOMER])->all();
        return $this->render('send-notification', ['customers' => $customers]);
    }
}