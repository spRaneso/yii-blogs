<?php

/** @var yii\web\View $this */
/** @var app\models\Blog[] $blogs */
/** @var yii\data\Pagination $pagination */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = 'Blogs';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container py-5">
    <h1 class="text-center mb-5"><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <?php foreach ($blogs as $blog): ?>
            <div class="col-md-6 mb-4">
                <div class="blog-post p-3 border rounded">
                    <a href="<?= Url::to(['site/blog-details', 'slug' => $blog->slug]) ?>" class="text-decoration-none">
                        <h3 class="blog-title"><?= Html::encode($blog->title) ?></h3>
                    </a>

                    <p class="blog-content"><?= Yii::$app->formatter->asHtml(mb_substr($blog->content, 0, 100)) ?>...</p>

                    <div class="blog-meta text-muted">
                        <span class="author"><?= Html::encode($blog->user ? $blog->user->full_name : 'Unknown User') ?></span> |
                        <span class="date"><?= Yii::$app->formatter->asDate($blog->approved_at) ?></span>
                    </div>

                    <div class="text-center mt-2">
                        <a href="<?= Url::to(['site/blog-details', 'slug' => $blog->slug]) ?>" class="btn btn-link">Read More</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Pagination -->
    <div class="pagination-container d-flex justify-content-end">
        <?= LinkPager::widget([
            'pagination' => $pagination,
            'options' => ['class' => 'pagination'],
            'linkOptions' => ['class' => 'page-link'],
            'disabledListItemSubTagOptions' => ['class' => 'page-link disabled'],
        ]) ?>
    </div>

    <?php $this->registerCss('
    .blog-post {
        background: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 8px;
        transition: transform 0.2s ease-in-out;
    }

    .blog-post:hover {
        transform: translateY(-5px);
    }

    .blog-title {
        font-size: 1.5em;
        color: #333;
    }

    .blog-content {
        font-size: 1em;
        color: #555;
    }

    .blog-meta {
        font-size: 0.9em;
        color: #888;
    }

    .btn-link {
        color: #3498db;
        text-decoration: none;
    }

    .btn-link:hover {
        color: black;
    }
');
    ?>