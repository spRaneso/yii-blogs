<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Update Blog: ' . Html::encode($model->title);
$this->params['breadcrumbs'][] = ['label' => 'Blogs', 'url' => ['/blog']];
$this->params['breadcrumbs'][] = 'Update';
?>

<h3 class="d-flex justify-content-between">
    Update Blog
    <?= Html::a('Back', ['blog/index'], ['class' => 'btn btn-dark btn-sm']) ?>
</h3>

<div class="blog-update-form mt-4">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="row">
        <div class="col-md-6">
            <!-- Current Image Display with Preview for New Image -->
            <div id="image-preview-container-update" style="width: 200px; height: 200px; overflow: hidden; border: 1px solid #ccc; border-radius: 5px; margin-bottom: 10px;">
                <img id="image-preview-update"
                    src="<?= !empty($model->image_path) ? Yii::getAlias('@web') . $model->image_path : 'https://via.placeholder.com/200x200.png?text=No+Image' ?>"
                    style="width: 100%; height: 100%; object-fit: cover;"
                    alt="Current Image">
            </div>

            <!-- Image Upload Field -->
            <?= $form->field($model, 'image')->fileInput([
                'id' => 'image-input-update',
                'class' => 'form-control',
            ])->label('Upload New Blog Image') ?>
        </div>

        <div class="col-md-6">
            <!-- Title -->
            <?= $form->field($model, 'title')->textInput(['placeholder' => 'Update the title here'])->label('Blog Title') ?>

            <!-- Content -->
            <?= $form->field($model, 'content')->textarea(['rows' => 6, 'placeholder' => 'Update the blog content here'])->label('Blog Content') ?>
        </div>
    </div>

    <div class="form-group mt-3">
        <?= Html::submitButton('Update Blog', ['class' => 'btn btn-dark btn-lg w-100']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<?php
$this->registerJs("
// Image preview for Update
$('#image-input-update').on('change', function() {
    var file = this.files[0];
    if (file) {
        var reader = new FileReader();
        reader.onload = function(e) {
            // Update the existing image preview with the new file
            $('#image-preview-update').attr('src', e.target.result);
        };
        reader.readAsDataURL(file);
    }
});
");
?>