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

<div class="container py-2">
    <h2 class="blog-title text-center mb-4 fw-bold text-dark bg-light p-3 rounded-3 shadow">
        <?= Html::encode($this->title) ?>
    </h2>

    <div class="row">
        <?php if (empty($blogs)): ?>
            <div class="col-12">
                <div class="alert alert-info text-center">No records found.</div>
            </div>
        <?php else: ?>

            <?php foreach ($blogs as $blog): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm rounded-3 blog-card">
                        <?php if ($blog->image_path): ?>
                            <div class="card-img-top" style="height: 200px; overflow: hidden;">
                                <a href="<?= Url::to(['site/blog-details', 'slug' => $blog->slug]) ?>">
                                    <img src="<?= Yii::getAlias('@web') . Html::encode($blog->image_path) ?>"
                                        class="img-fluid rounded-3" alt="<?= Html::encode($blog->title) ?>"
                                        style="object-fit: cover; height: 100%; width: 100%;">
                                </a>
                            </div>
                        <?php endif; ?>

                        <div class="card-body d-flex flex-column">
                            <a href="<?= Url::to(['site/blog-details', 'slug' => $blog->slug]) ?>" class="text-decoration-none">
                                <h5 class="card-title text-dark"><?= Html::encode($blog->title) ?></h5>
                            </a>

                            <p class="card-text text-muted"><?= Yii::$app->formatter->asHtml(mb_substr($blog->content, 0, 100)) ?>...</p>

                            <div class="card-footer text-muted mt-auto">
                                <span class="author"><?= Html::encode($blog->user ? $blog->user->full_name : 'Unknown User') ?></span> |
                                <span class="date"><?= Yii::$app->formatter->asDate($blog->approved_at) ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <div class="pagination-container d-flex justify-content-end mt-4">
        <?= LinkPager::widget([
            'pagination' => $pagination,
            'options' => ['class' => 'pagination'],
            'linkOptions' => ['class' => 'page-link'],
            'disabledListItemSubTagOptions' => ['class' => 'page-link disabled'],
        ]) ?>
    </div>
</div>

<?php $this->registerCss('
    .card-img-top {
        border-radius: 15px 15px 0 0; /* Rounded top corners for the image */
    }

    .blog-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease; /* Smoother transition for scaling and shadow */
    }

    .blog-card:hover {
        transform: scale(1.05); /* Slight zoom effect on hover */
        box-shadow: 0 12px 20px rgba(0, 0, 0, 0.15); /* Stronger shadow on hover */
    }
');
?>