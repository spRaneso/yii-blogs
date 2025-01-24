<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = Html::encode('Blog: Update: ' . $model->title);
$this->params['breadcrumbs'][] = ['label' => 'Blogs', 'url' => ['/blog']];
$this->params['breadcrumbs'][] = $model->title;
?>

<h3 class="d-flex justify-content-between">
    Update Blog
    <?= Html::a('Back', ['blog/index'], ['class' => 'btn btn-dark btn-sm']) ?>
</h3>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'title')->textInput() ?>
<?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

<div class="form-group">
    <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>