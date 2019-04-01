<?php

namespace app\models\Generated;

use Yii;

/**
 * This is the model class for table "sd_price_items".
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property int $item_type
 * @property double $global_price
 * @property string $info
 */
class PriceItemsGenerated extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sd_price_items';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code',], 'required'],
            [['code', 'name', 'info'], 'string'],
            [['item_type','groupId'], 'integer'],
            [['global_price'], 'number'],
            [['code', 'name', 'removed', 'item_type', 'global_price', 'info', 'groupId'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'name' => 'Name',
            'item_type' => 'Item Type',
            'global_price' => 'Global Price',
            'info' => 'Info',
        ];
    }
}
