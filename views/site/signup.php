<?php

/** @var yii\web\View $this */
/** @var app\models\SignupForm $model */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Register';
?>

<div class="row justify-content-center mt-4">
    <div class="col-md-6">
        <div class="card shadow border-0">
            <div class="card-header bg-primary text-white text-center py-3">
                <h3 class="mb-0">⚕️ Create an Account</h3>
                <p class="mb-0 small">Join PharmaWholesale today</p>
            </div>
            <div class="card-body p-4">

                <?php $form = ActiveForm::begin(['id' => 'signup-form']); ?>

                    <?= $form->field($model, 'username')->textInput([
                        'placeholder' => 'Choose a username',
                        'autofocus' => true
                    ]) ?>

                    <?= $form->field($model, 'email')->input('email', [
                        'placeholder' => 'your@email.com'
                    ]) ?>

                    <?= $form->field($model, 'company_name')->textInput([
                        'placeholder' => 'Your company or business name'
                    ]) ?>

                    <?= $form->field($model, 'phone')->textInput([
                        'placeholder' => '+255 7XX XXX XXX'
                    ]) ?>

                    <?= $form->field($model, 'address')->textarea([
                        'rows' => 2,
                        'placeholder' => 'Your delivery address'
                    ]) ?>

                    <?= $form->field($model, 'password')->passwordInput([
                        'placeholder' => 'Minimum 6 characters'
                    ]) ?>

                    <?= $form->field($model, 'password_repeat')->passwordInput([
                        'placeholder' => 'Repeat your password'
                    ]) ?>

                    <div class="d-grid mt-3">
                        <?= Html::submitButton('Create Account', [
                            'class' => 'btn btn-primary btn-lg',
                            'name' => 'signup-button'
                        ]) ?>
                    </div>

                <?php ActiveForm::end(); ?>

                <hr>
                <p class="text-center mb-0">
                    Already have an account? 
                    <?= Html::a('Login here', ['/site/login']) ?>
                </p>
            </div>
        </div>
    </div>
</div>