<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "oil_inventory".
 *
 * @property int $inv_id
 * @property int $station_id
 * @property int $tank_id
 * @property int $oil_type
 * @property int $total_litres
 * @property int $crby
 * @property string $crdate
 * @property int|null $edited_by
 * @property string|null $edited_date
 */
class OilInventory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'oil_inventory';
    }

    public $avail_ltr;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['station_id', 'tank_id', 'oil_type', 'total_litres', 'crby', 'crdate'], 'required'],
            [['station_id', 'tank_id', 'oil_type', 'total_litres', 'crby', 'edited_by'], 'integer'],
            [['crdate', 'edited_date','avail_ltr'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'inv_id' => 'Inv ID',
            'station_id' => 'Station ID',
            'tank_id' => 'Tank ID',
            'oil_type' => 'Oil Type',
            'total_litres' => 'Total Litres',
            'crby' => 'Crby',
            'crdate' => 'Crdate',
            'edited_by' => 'Edited By',
            'edited_date' => 'Edited Date',
            'avail_ltr'=>'Available Litres',
        ];
    }
}
