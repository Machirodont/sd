<?php

namespace app\controllers;

use app\models\Clinic;
use app\models\Traits;
use app\models\UploadForm;
use Yii;
use yii\data\ArrayDataProvider;
use yii\db\Query;
use yii\filters\AccessControl;
use app\models\Persons;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Institutions;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;

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
                'only' => ['edit'],
                'rules' => [
                    [
                        'actions' => ['edit', 'list', 'remove-trait'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'remove-trait' => ['POST'],
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
        $persons = $clinic ? $clinic->persons : Persons::find()->where(["removed" => null])->all();

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
        if ($person->removed) {
            return $this->redirect(["persons/index"]);
        }
        $person->currentClinic = Clinic::findOne(Yii::$app->session->get("cid"));

        return $this->render('view', [
            'model' => $person,
        ]);
    }

    public function actionList()
    {
        $showRemoved = !!Yii::$app->request->get("showRemoved");
        $query = Persons::find();
        if (!$showRemoved) {
            $query->where(["removed" => null]);
        }

        $personsDataProvider = new ActiveDataProvider([
            "query" => $query,
            'pagination' => [
                'pageSize' => 0,
            ],
        ]);

        return $this->render("list", [
            "personsDataProvider" => $personsDataProvider,
            'showRemoved' => $showRemoved
        ]);
    }

    public function actionEdit($id = null)
    {
        if ($id) {
            $person = $this->findModel($id);
        } else {
            $person = new Persons();
        }

        if ($person->load(Yii::$app->request->post())) {
            $person->save();
            return $this->redirect(["/persons/edit", "id" => $person->person_id]);
        }

        return $this->render('edit', [
            'person' => $person,
            'institutions' => array_merge([null], ArrayHelper::map(Institutions::find()->all(), "institution_id", "name")),
            'traitTypes' => array_merge([null], ArrayHelper::map((new Query())->select(["title"])->distinct()->from("sd_traits")->all(), "title", "title"))
        ]);
    }

    public function actionDelete($id)
    {
        $person = $this->findModel($id);
        $person->removed = date("Y-m-d H:i:s");
        $person->save();
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionRestore($id)
    {
        $person = $this->findModel($id);
        $person->removed = null;
        $person->save();
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionLoadPhoto($id)
    {
        $uploadForm = new UploadForm();
        $uploadForm->person = $this->findModel($id);
        if (Yii::$app->request->isPost) {
            $uploadForm->imageFile = UploadedFile::getInstance($uploadForm, 'imageFile');
            if ($uploadForm->upload()) {
                return $this->redirect(Yii::$app->request->referrer);
            }
        }
        return $this->render('load-photo', [
            'uploadForm' => $uploadForm,
        ]);
    }


    public function actionRemoveTrait($id)
    {
        $trait = Traits::findOne($id);
        $person_id = $trait->person_id;
        $trait->delete();
        return $this->redirect(["/persons/edit", "id" => $person_id]);
    }

    protected function findModel($id)
    {
        if (($model = Persons::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
