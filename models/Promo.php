<?php


namespace app\models;


use app\models\Generated\PromoGenerated;
use phpDocumentor\Reflection\Types\Boolean;
use yii\helpers\Html;
use yii\web\UploadedFile;

/**
 * Class Promo
 * @property UploadedFile $imageFile
 * @property string $fileName
 * @package app\models
 */
class Promo extends PromoGenerated
{
    public $imageFile;


    public function rules()
    {
        return [
            [['title', 'clinics', 'html'], 'string'],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['clinicList', 'startDate', 'endDate'], 'safe'],
            ['html', 'filter', 'filter' => function ($value) {
                return ($value);
            }],

        ];
    }

    public function load($data, $formName = null)
    {
        $res = parent::load($data, $formName);

        if ($res && \Yii::$app->request->isPost) {
            $this->imageFile = UploadedFile::getInstance($this, 'imageFile');
            if (!array_key_exists("clinicList", $data["Promo"])) $this->clinics = null;
        }
        return $res;
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        $res = parent::save($runValidation, $attributeNames);
        if ($res) {
            if ($this->imageFile) {
                $res = $this->imageFile->saveAs('images/promo/' . $this->id . '.' . $this->imageFile->extension);
            }
        }
        return $res;
    }

    public function getFileName()
    {
        $path = __DIR__ . '/../web/images/promo/';
        if ($this->id) {
            if (file_exists($path . $this->id . '.png')) {
                return $this->id . '.png';
            }
            if (file_exists($path . $this->id . '.jpg')) {
                return $this->id . '.jpg';
            }
        }
        return null;
    }

    public function setClinicList($list)
    {
        if (is_array($list)) {
            $this->clinics = json_encode($list);
        } else {
            $this->clinics = json_encode([$list]);
        }
    }

    public function getClinicList()
    {
        return json_decode($this->clinics);
    }

    /**
     * @param Clinic|int $clinic
     */
    public function doShowWithClinic($clinic): bool
    {
        $clinicsList = $this->clinicList;
        if (!is_array($clinicsList)) return true;
        if (count($clinicsList) === 0) return true;

        $clinicId = null;
        if ($clinic instanceof Clinic) $clinicId = $clinic->id;
        if (is_integer($clinic) && $clinic > 0) $clinicId = $clinic;
        if (!$clinicId) {
            if (in_array(0, $clinicsList)) return true;
            return false;
        }
        if (in_array($clinicId, $clinicsList)) return true;
        return false;
    }

    public static function getListForClinic($clinic): array
    {
        $promos = Promo::find()->where(['and',
            ["or",
                ['<=', 'startDate', date("Y-m-d")],
                ['startDate' => null],
            ],
            ["or",
                ['>=', 'endDate', date("Y-m-d")],
                ['endDate' => null],
            ],
        ])->orderBy(["id" => SORT_DESC])->all();

        $promoList = array_values(array_filter($promos, function (Promo $promo) use ($clinic) {
            if (!$promo->doShowWithClinic($clinic)) return false;
            return $promo->fileName;
        }));

        $promoList = array_map(function (Promo $promo) {
            return [
                "content" => Html::a(
                    Html::img("/images/promo/" . $promo->fileName),
                    ["promo/view", "id" => $promo->id]
                ),
                "caption" => null//$promo->startDate . " - " . $promo->endDate
            ];
        }, $promoList);
        return $promoList;
    }
}