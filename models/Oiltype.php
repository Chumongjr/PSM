<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "oil_type".
 *
 * @property int $type_id
 * @property string $oil_type
 * @property int $cur_price
 * @property int $crby
 * @property string $crdate
 */
class Oiltype extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'oil_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['oil_type', 'cur_price', 'crby', 'crdate'], 'required'],
            [['cur_price', 'crby'], 'integer'],
            [['crdate'], 'safe'],
            [['oil_type'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'type_id' => 'Type ID',
            'oil_type' => 'Oil Type',
            'cur_price' => 'Cur Price',
            'crby' => 'Crby',
            'crdate' => 'Crdate',
        ];
    }
}
