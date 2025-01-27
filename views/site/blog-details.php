<?php

/** @var yii\web\View $this */
/** @var app\models\Blog $blog */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Html::encode($blog->title);
$this->params['breadcrumbs'][] = ['label' => 'Blogs', 'url' => ['/site/blog']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="blog-details container py-5">

    <h2 class="blog-title text-center mb-4 fw-bold text-dark bg-light p-3 rounded-3 shadow">
        <?= Html::encode($blog->title) ?>
    </h2>
    
    <div class="blog-meta text-center mb-4">
        <span class="author fw-semibold"><?= Html::encode($blog->user ? $blog->user->full_name : 'Unknown User') ?></span> |
        <span class="date text-muted"><?= Yii::$app->formatter->asDate($blog->approved_at) ?></span>
    </div>

    <?php if ($blog->image_path): ?>
        <div class="blog-image-wrapper text-center mb-4">
            <img src="<?= Yii::getAlias('@web') . Html::encode($blog->image_path) ?>"
                class="img-fluid rounded" alt="<?= Html::encode($blog->title) ?>">
        </div>
    <?php endif; ?>

    <div class="blog-content mb-4">
        <?= Yii::$app->formatter->asHtml($blog->content) ?>
    </div>

    <div class="back-link text-center">
        <a href="<?= Url::to(['site/blog']) ?>" class="btn btn-dark btn-sm">Back to Blogs</a>
    </div>
</div>
