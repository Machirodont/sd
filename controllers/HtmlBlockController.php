<?php

namespace app\controllers;

use app\models\Pages;
use app\models\Persons;
use Yii;
use app\models\HtmlBlock;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class HtmlBlockController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }


    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => HtmlBlock::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate($class, $key)
    {
        $classes = [
            "person" => Persons::class,
            "page" => Pages::class,
        ];
        if (!array_key_exists($class, $classes)) throw new HttpException(404, "Неправильно указан класс");
        if (!$entity = $classes[$class]::findOne($key)) {
            throw new HttpException(404, "Неправильно указан ключ");
        }
        /**@var ActiveRecord $entity */

        $model = new HtmlBlock();
        $model->itemKey = $entity->primaryKey;
        $model->itemTable = get_class($entity)::tableName();

        if ($model->load(Yii::$app->request->post())) {
            if (!$model->order) {
                $model->order = 1;
            }
            if ($model->save()) {
                return $this->redirect($model->entityRoute);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }


    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect($model->entityRoute);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = HtmlBlock::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
