<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = 'Add New Product';
?>
<div class="card shadow border-0">
    <div class="card-header bg-primary text-white d-flex justify-content-between">
        <h4 class="mb-0">💊 Add New Product</h4>
        <?= Html::a('← Back', ['/admin/products'], ['class' => 'btn btn-light btn-sm']) ?>
    </div>
    <div class="card-body">
        <?php $form = ActiveForm::begin(); ?>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'name')->textInput(['placeholder' => 'Product name']) ?>
                    <?= $form->field($model, 'category_id')->dropDownList($categories, ['prompt' => 'Select Category']) ?>
                    <?= $form->field($model, 'manufacturer')->textInput(['placeholder' => 'e.g. Cipla, GSK']) ?>
                    <?= $form->field($model, 'dosage_form')->textInput(['placeholder' => 'e.g. Tablet, Syrup']) ?>
                    <?= $form->field($model, 'description')->textarea(['rows' => 3]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'price')->input('number', ['placeholder' => '0.00', 'step' => '0.01']) ?>
                    <?= $form->field($model, 'stock_qty')->input('number', ['placeholder' => '0']) ?>
                    <?= $form->field($model, 'moq')->input('number', ['placeholder' => 'Minimum order quantity']) ?>
                    <?= $form->field($model, 'status')->dropDownList([1 => 'Active', 0 => 'Inactive']) ?>
                </div>
            </div>
            <div class="mt-3">
                <?= Html::submitButton('💾 Save Product', ['class' => 'btn btn-primary btn-lg']) ?>
            </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>