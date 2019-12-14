<?php

namespace app\controllers;

use app\models\Clinic;
use Yii;
use yii\data\ArrayDataProvider;
use yii\db\Query;
use yii\filters\AccessControl;
use app\models\Persons;
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
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['index', 'view',],
                        'allow' => true,
                        'roles' => ['@', '?'],
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
        $clinic = Clinic::findOne(Yii::$app->session->get("cid"));
        $query = Persons::find()->where(["removed" => null]);
        if ($clinic) {
            $query
                ->from([
                    "p" => "sd_persons",
                    "t" => "sd_timelines",
                    "w" => "sd_workplaces",
                    "c" => "sd_clinics",
                ])
                ->where(["and",
                    "c.id = " . $clinic->id,
                    "c.hash_id = w.clinic_hash",
                    "c.hash_id = w.clinic_hash",
                    "w.workplace_hash = t.workplace_hash",
                    "t.person_id=p.person_id",
                    "p.removed IS NULL"
                ]);
        }

        $persons = $query->all();
        usort($persons, function (Persons $a, Persons $b) {
            return $a->primarySpec > $b->primarySpec;
        });

        $dataProvider = new ArrayDataProvider([
            'allModels' => $persons,

        ]);
        $dataProvider->pagination->pageSize = count($persons);


        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'clinic' => $clinic
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
        $person = $this->findModel($id);
        $person->currentClinic = Clinic::findOne(Yii::$app->session->get("cid"));

        return $this->render('view', [
            'model' => $person,
            'cid' => Yii::$app->session->get("cid"),
        ]);
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
