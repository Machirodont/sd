<?php

namespace app\controllers;

use app\models\Clinic;
use Yii;
use yii\filters\AccessControl;
use app\models\Persons;
use app\models\PersonsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Institutions;
use yii\data\ActiveDataProvider;

/**
 * PersonsController implements the CRUD actions for Persons model.
 */
class PersonsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
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

    /**
     * Lists all Persons models.
     * @return mixed
     */
    public function actionIndex()
    {
        $query = Persons::find();
        $clinic=null;
        if (isset(Yii::$app->request->queryParams["cid"])) {
            $query
                ->from([
                    "p" => "sd_persons",
                    "c" => "sd_clinics",
                    "s" => "sd_schedule",
                ])
                ->where(["and",
                    "c.id = ".intval(Yii::$app->request->queryParams["cid"]),
                    "c.hash_id = s.subdivision_hash",
                    "p.person_id=s.person_id"
                ]);
            $clinic=Clinic::findOne(Yii::$app->request->queryParams["cid"]);

        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'clinic'=>$clinic
        ]);
    }

    /**
     * Displays a single Persons model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Persons model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Persons();

        $institutionsList = array_map(
            function ($instituton) {
                return ($instituton->shortname && $instituton->shortname !== "") ? $instituton->shortname : $instituton->name;
            },
            Institutions::find()
                ->indexBy('institution_id')
                ->all()
        );

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->person_id]);
        }

        return $this->render('create', [
            'model' => $model,
            'institutionsList' => $institutionsList,
        ]);
    }

    /**
     * Updates an existing Persons model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->person_id]);
        }

        $institutionsList = array_map(
            function ($instituton) {
                return ($instituton->shortname && $instituton->shortname !== "") ? $instituton->shortname : $instituton->name;
            },
            Institutions::find()
                ->indexBy('institution_id')
                ->all()
        );

        return $this->render('update', [
            'model' => $model,
            'institutionsList' => $institutionsList,
        ]);
    }

    /**
     * Deletes an existing Persons model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Persons model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Persons the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Persons::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
