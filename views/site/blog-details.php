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
    <!-- Center the title using Bootstrap's text-center class -->
    <h1 class="blog-title text-center mb-4"><?= Html::encode($blog->title) ?></h1>

    <!-- Blog meta information -->
    <div class="blog-meta text-center mb-4">
        <!-- Handle missing user gracefully -->
        <span class="author"><?= Html::encode($blog->user ? $blog->user->full_name : 'Unknown User') ?></span> |
        <span class="date"><?= Yii::$app->formatter->asDate($blog->approved_at) ?></span>
    </div>

    <!-- Blog content with HTML formatting -->
    <div class="blog-content mb-4">
        <?= Yii::$app->formatter->asHtml($blog->content) ?>
    </div>

    <!-- Back to Blogs button -->
    <div class="back-link text-center">
        <a href="<?= Url::to(['blog/index']) ?>" class="btn btn-dark btn-sm">Back to Blogs</a>
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