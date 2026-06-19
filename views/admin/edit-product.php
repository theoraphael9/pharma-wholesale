<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = 'Edit Product';
?>
<div class="card shadow border-0">
    <div class="card-header bg-warning text-dark d-flex justify-content-between">
        <h4 class="mb-0">✏️ Edit: <?= Html::encode($model->name) ?></h4>
        <?= Html::a('← Back', ['/admin/products'], ['class' => 'btn btn-dark btn-sm']) ?>
    </div>
    <div class="card-body">
        <?php $form = ActiveForm::begin(); ?>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'name')->textInput() ?>
                    <?= $form->field($model, 'category_id')->dropDownList($categories, ['prompt' => 'Select Category']) ?>
                    <?= $form->field($model, 'manufacturer')->textInput() ?>
                    <?= $form->field($model, 'dosage_form')->textInput() ?>
                    <?= $form->field($model, 'description')->textarea(['rows' => 3]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'price')->input('number', ['step' => '0.01']) ?>
                    <?= $form->field($model, 'stock_qty')->input('number') ?>
                    <?= $form->field($model, 'moq')->input('number') ?>
                    <?= $form->field($model, 'status')->dropDownList([1 => 'Active', 0 => 'Inactive']) ?>
                </div>
            </div>
            <div class="mt-3">
                <?= Html::submitButton('💾 Update Product', ['class' => 'btn btn-warning btn-lg']) ?>
            </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>