<?php


namespace app\models;


use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Class UploadForm
 * @property Persons $person
 */
class UploadForm extends Model
{
    public $imageFile;
    public $person;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'jpg'],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->imageFile->saveAs('images/persons/' . $this->person->person_id . '.jpg');
            return true;
        } else {
            return false;
        }
    }
}