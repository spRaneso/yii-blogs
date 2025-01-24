<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Blog: Create';
$this->params['breadcrumbs'][] = ['label' => 'Blogs', 'url' => ['/blog']];
$this->params['breadcrumbs'][] = 'Create';
?>

<h3 class="d-flex justify-content-between">
    Create Blog
    <?= Html::a('Back', ['blog/index'], ['class' => 'btn btn-dark btn-sm']) ?>
</h3>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'title')->textInput()->hint('Enter title here') ?>
<?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

<div class="form-group">
    <?= Html::submitButton('Create', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>