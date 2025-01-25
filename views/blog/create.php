<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Create Blog';
$this->params['breadcrumbs'][] = ['label' => 'Blogs', 'url' => ['/blog']];
$this->params['breadcrumbs'][] = 'Create';
?>

<h3 class="d-flex justify-content-between">
    Create Blog
    <?= Html::a('Back', ['blog/index'], ['class' => 'btn btn-dark btn-sm']) ?>
</h3>

<div class="blog-create-form mt-4">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="row">
        <div class="col-md-6">
            <!-- Image Upload Field -->
            <?= $form->field($model, 'image')->fileInput([
                'id' => 'image-input-create',
                'class' => 'form-control',
                'required' => $this->context->action->id === 'create'
            ])->label('Upload Blog Image') ?>

            <!-- Image Preview -->
            <div id="image-preview-container-create" style="display: none; width: 200px; height: 200px; overflow: hidden; border: 1px solid #ccc; border-radius: 5px; margin-top: 10px;">
                <img id="image-preview-create" src="" style="width: 100%; height: 100%; object-fit: cover;" alt="Image Preview">
            </div>
        </div>

        <div class="col-md-6">
            <!-- Title -->
            <?= $form->field($model, 'title')->textInput(['placeholder' => 'Enter title here'])->label('Blog Title') ?>

            <!-- Content -->
            <?= $form->field($model, 'content')->textarea(['rows' => 6, 'placeholder' => 'Write the blog content here'])->label('Blog Content') ?>
        </div>
    </div>

    <div class="form-group mt-3">
        <?= Html::submitButton('Create Blog', ['class' => 'btn btn-dark btn-lg w-100']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<?php
$this->registerJs("
    // Image preview for Create
    $('#image-input-create').on('change', function() {
        var file = this.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#image-preview-create').attr('src', e.target.result);
                $('#image-preview-container-create').show();
            };
            reader.readAsDataURL(file);
        } else {
            $('#image-preview-container-create').hide();
        }
    });
");
?>