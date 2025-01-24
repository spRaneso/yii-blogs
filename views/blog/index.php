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

<!-- Table to display Records -->
<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Title</th>
            <th class="w-400">Content</th>
            <th class="w-200">Status</th>
            <th class="w-200 text-end">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($blogs)): ?>
            <tr>
                <td colspan="5" class="text-center">
                    <div class="alert alert-info">No records found.</div>
                </td>
            </tr>
        <?php else: ?>
            <?php foreach ($blogs as $key => $blog): ?>
                <tr>
                    <td><?= $key + 1 ?></td>
                    <td><?= Html::encode($blog->title) ?></td>
                    <td><?= Yii::$app->formatter->asHtml(mb_substr($blog->content, 0, 100) . '...') ?></td>
                    <td>
                        <!-- <?= Html::encode(Blog::getStatusList()[$blog->status] ?? 'Unknown') ?> -->
                        <?= Html::encode($blog->getStatusMessage()) ?>
                    </td>
                    <td class="text-end">
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

<!-- Pagination -->
<div class="pagination-container d-flex justify-content-end">
    <?= LinkPager::widget([
        'pagination' => $pagination,
        'options' => ['class' => 'pagination'],
        'linkOptions' => ['class' => 'page-link'],
    ]) ?>
</div>

<?php $this->registerCss('
    .w-200 {
        width: 200px;
    }
    .w-400 {
        width: 400px;
    }
');
?>