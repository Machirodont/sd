<?php

namespace app\models\Generated;

use Yii;

/**
 * This is the model class for table "sd_price_group".
 *
 * @property int $id
 * @property string $groupName
 * @property int $parentId
 * @property string $removed
 */
class PriceGroupGenerated extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sd_price_group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['groupName'], 'string'],
            [['parentId'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'groupName' => 'Group Name',
            'itemId' => 'Item ID',
        ];
    }
}
