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

    <h1 class="blog-title text-center mb-4"><?= Html::encode($blog->title) ?></h1>
    <div class="blog-meta text-center mb-4">
        <span class="author"><?= Html::encode($blog->user ? $blog->user->full_name : 'Unknown User') ?></span> |
        <span class="date"><?= Yii::$app->formatter->asDate($blog->approved_at) ?></span>
    </div>

    <?php if ($blog->image_path): ?>
        <div class="blog-image-wrapper mb-4">
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

<?php $this->registerCss('
    .blog-title {
        font-size: 2.2em;
    }

    .blog-meta .author {
        font-weight: bold;
    }

    .blog-meta .date {
        color: #888;
    }

    .blog-content {
        font-size: 1.1em;
        line-height: 1.6;
        color: #333;
    }

    .back-link .btn {
        text-decoration: none;
    }
');
?>