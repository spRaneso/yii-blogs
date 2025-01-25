<?php

use app\models\Blog;
use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = 'Blogs';
$this->params['breadcrumbs'][] = $this->title;
?>

<h3 class="d-flex justify-content-between">
    Blogs
    <?= Html::a('Add', ['blog/create'], ['class' => 'btn btn-dark btn-sm']) ?>
</h3>

<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Image</th>
            <th>Title</th>
            <th class="w-400">Content</th>
            <th class="w-200">Status</th>
            <th class="w-200 text-end">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (empty($blogs)): ?>
            <tr>
                <td colspan="6" class="text-center">
                    <div class="alert alert-info">No records found.</div>
                </td>
            </tr>
        <?php else: ?>
            <?php foreach ($blogs as $key => $blog): ?>
                <tr>
                    <td class="align-middle"><?= $key + 1 ?></td>
                    <td class="align-middle">
                        <?php if ($blog->image_path): ?>
                            <img src="<?= Yii::getAlias('@web') . $blog->image_path ?>" alt="Blog Image" class="img-thumbnail" style="max-width: 100px; height: auto;">
                        <?php else: ?>
                            <span class="text-muted">No Image</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-center align-middle"><?= Html::encode($blog->title) ?></td>
                    <td class="text-center align-middle"><?= Yii::$app->formatter->asHtml(mb_substr($blog->content, 0, 100) . '...') ?></td>
                    <td class="text-center align-middle">
                        <?= Html::encode($blog->getStatusMessage()) ?>
                    </td>
                    <td class="text-end align-middle">
                        <?php if (Yii::$app->user->identity->role === 'admin' || $blog->status === Blog::STATUS_PENDING): ?>
                            <?= Html::a('<i class="fas fa-edit"></i>', ['/blog/update', 'slug' => $blog->slug], ['class' => 'btn btn-sm me-2']) ?>
                            <?= Html::a('<i class="fas fa-trash-alt"></i>', ['/blog/delete', 'slug' => $blog->slug], [
                                'class' => 'btn btn-sm',
                                'data' => [
                                    'confirm' => 'Are you sure you want to delete this blog?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                        <?php endif; ?>

                        <?php if (Yii::$app->user->identity->role === 'admin' && $blog->status === Blog::STATUS_PENDING): ?>
                            <?= Html::a('Approve', ['/blog/approve', 'slug' => $blog->slug], [
                                'class' => 'btn btn-sm btn-success',
                                'data' => [
                                    'confirm' => 'Are you sure you want to approve this blog?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<?php $this->registerCss('
    .align-middle {
        vertical-align: middle !important;
    }
    .text-center {
        text-align: center !important;
    }
    .w-200 {
        width: 200px;
    }
    .w-400 {
        width: 400px;
    }
    .table td {
        vertical-align: middle; /* Ensure all table cells align vertically */
    }
'); ?>