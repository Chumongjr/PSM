<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "station_sells".
 *
 * @property int $sell_id
 * @property int $station_id
 * @property int $pump_id
 * @property int $staff_id
 * @property int $opening_litres
 * @property int|null $closing_litres
 * @property int|null $litre_sold
 * @property int|null $total_sell
 * @property string|null $shift_start
 * @property string|null $shift_end
 * @property int $crby
 * @property string $crdate
 * @property string $iscurrent
 * @property int|null $shift_ended_by
 * @property string|null $shift_ended_at
 */
class Stationsells extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'station_sells';
    }
    public $staff_name;
    public $from_date;
    public $to_date;

    public $date_from;
    public $date_to;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['station_id', 'pump_id', 'staff_id', 'opening_litres', 'crby', 'crdate', 'closing_litres'], 'required'],
            [['staff_name'], 'string', 'max' => 200],
            [['station_id', 'pump_id', 'staff_id', 'opening_litres', 'closing_litres', 'litre_sold', 'total_sell', 'crby', 'shift_ended_by'], 'integer'],
            [['shift_start', 'shift_end', 'crdate', 'shift_ended_at','from_date','to_date','date_from','date_to'], 'safe'],
            [['iscurrent'], 'string', 'max' => 5],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'sell_id' => 'Sell ID',
            'station_id' => 'Station Name',
            'pump_id' => 'Pump ID',
            'staff_id' => 'Staff Name',
            'opening_litres' => 'Opening Litres',
            'closing_litres' => 'Closing Litres',
            'litre_sold' => 'Litre Sold',
            'total_sell' => 'Total Sell',
            'shift_start' => 'Shift Start',
            'shift_end' => 'Shift End',
            'crby' => 'Crby',
            'crdate' => 'Crdate',
            'iscurrent' => 'Iscurrent',
            'shift_ended_by' => 'Shift Ended By',
            'shift_ended_at' => 'Shift Ended At',
            'staff_name'=> 'Staff Name',
            'from_date'=>'Enter Start Date',
            'to_date'=>'Enter End Date',
            'date_from'=>'Enter Start Date',
            'date_to'=>'Enter End Date'
        ];
    }
}
