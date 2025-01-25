<?php

namespace app\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;
use yii\data\Pagination;
use app\models\Blog;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class BlogController extends Controller
{
    // Add Access Control Filter to manage access
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'create'], // Only authenticated users can create and see the list of blogs
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['approve'], // Only admin can approve
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'actions' => ['update', 'delete'], // Update and delete only for normal users when status is pending or for admin
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $slug = Yii::$app->request->get('slug');
                            $blog = Blog::findOne(['slug' => $slug]);

                            // Allow admins and users who created the blog with status 'pending'
                            return Yii::$app->user->identity->role === 'admin' ||
                                (Yii::$app->user->id == $blog->user_id && $blog->status == Blog::STATUS_PENDING);
                        }
                    ],
                ],
            ],
        ];
    }
    public function actionIndex()
    {
        if (Yii::$app->user->identity->role === 'admin') {
            $query = Blog::find();
        } else {
            $query = Blog::find()->where(['user_id' => Yii::$app->user->id]);
        }

        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->count(),
        ]);

        $records = $query->orderBy(['created_at' => SORT_DESC])
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('index', [
            'blogs' => $records,
            'pagination' => $pagination,
        ]);
    }

    // Action for Blog create
    public function actionCreate()
    {
        $model = new Blog();
        $model->setScenario(Blog::SCENARIO_CREATE);

        if (Yii::$app->request->isPost) {
            $model->image = UploadedFile::getInstance($model, 'image');

            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                if ($model->uploadImage() && $model->save()) {
                    Yii::$app->session->setFlash('success', 'Blog created successfully.');
                    return $this->redirect(['index']);
                }
            }
        }

        return $this->render('create', ['model' => $model]);
    }

    // Action for Blog update
    public function actionUpdate($slug)
    {
        $model = Blog::findOne(['slug' => $slug]);
        if ($model === null) {
            throw new NotFoundHttpException('Blog not found.');
        }
        $model->setScenario(Blog::SCENARIO_UPDATE);

        if (Yii::$app->request->isPost) {
            $model->image = UploadedFile::getInstance($model, 'image');

            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                if ($model->image && $model->uploadImage()) {
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'Blog updated successfully.');
                        return $this->redirect(['index']);
                    }
                } elseif ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Blog updated successfully.');
                    return $this->redirect(['index']);
                }
            }
        }

        return $this->render('update', ['model' => $model]);
    }

    public function actionDelete($slug)
    {
        $record = Blog::findOne(['slug' => $slug]);
        if ($record) {
            $blogTitle = $record->title;
            if ($record->delete()) {
                Yii::$app->session->setFlash('success', "Blog: '$blogTitle' DELETED successfully.");
                return $this->redirect(['index']);
            }
        }

        return $this->redirect(['index']);
    }

    // Admin can approve the blog
    public function actionApprove($slug)
    {
        $model = Blog::findOne(['slug' => $slug]);
        if ($model && $model->status === Blog::STATUS_PENDING) {
            $model->status = Blog::STATUS_APPROVED;
            $model->approved_by = Yii::$app->user->id;
            $model->approved_at = new \yii\db\Expression('NOW()');

            if ($model->save()) {
                $blogTitle = $model->title;
                Yii::$app->session->setFlash('success', "Blog: '$blogTitle' APPROVED successfully.");
            }
        }
        return $this->redirect(['index']);
    }
}
