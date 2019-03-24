<?php

namespace app\models\Generated;

use Yii;

/**
 * This is the model class for table "sd_url_tags".
 *
 * @property int $id
 * @property string $tag
 * @property string $param
 * @property string $value
 * @property string $route
 */
class UrlTagsGenerated extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sd_url_tags';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tag', 'param', 'value'], 'required'],
            [['tag', 'param', 'value'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tag' => 'Tag',
            'param' => 'Param',
            'value' => 'Value',
        ];
    }
}
