<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tanks".
 *
 * @property int $tank_id
 * @property int $oil_type
 * @property int $tank_capacity
 * @property int $available_litres
 * @property int $station_id
 * @property int $crby
 * @property string $crdate
 */
class Tanks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tanks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['oil_type', 'tank_capacity', 'available_litres', 'station_id', 'crby', 'crdate'], 'required'],
            [['oil_type', 'tank_capacity', 'available_litres', 'station_id', 'crby'], 'integer'],
            [['crdate'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tank_id' => 'Tank ID',
            'oil_type' => 'Oil Type',
            'tank_capacity' => 'Tank Capacity',
            'available_litres' => 'Available Litres',
            'station_id' => 'Station ID',
            'crby' => 'Crby',
            'crdate' => 'Crdate',
        ];
    }
}
