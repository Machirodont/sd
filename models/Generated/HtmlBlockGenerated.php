<?php

namespace app\models\Generated;

use Yii;

/**
 * This is the model class for table "sd_html_block".
 *
 * @property int $id
 * @property int $itemKey
 * @property string $itemTable
 * @property string $html
 * @property string $order
 */
class HtmlBlockGenerated extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sd_html_block';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['itemKey', 'itemTable', 'html'], 'required'],
            [['itemKey', 'order'], 'integer'],
            [['itemTable', 'html'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'itemKey' => 'Item Key',
            'itemTable' => 'Item Table',
            'html' => 'Html',
            'order' => 'Order',
        ];
    }
}
