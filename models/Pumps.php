<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pumps".
 *
 * @property int $pump_id
 * @property string $pump_name
 * @property int $station_id
 * @property int $initial_litres
 * @property int|null $cur_litres
 * @property int|null $cur_staff_assigned
 * @property int $crby
 * @property string $crdate
 * @property int|null $updated_by
 * @property string|null $date_updated
 * @property int|null $oil_type
 */
class Pumps extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pumps';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pump_name', 'station_id', 'crby', 'crdate'], 'required'],
            [['station_id', 'initial_litres', 'cur_litres', 'cur_staff_assigned', 'crby', 'updated_by', 'oil_type'], 'integer'],
            [['crdate', 'date_updated'], 'safe'],
            [['pump_name'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pump_id' => 'Pump ID',
            'pump_name' => 'Pump Name',
            'station_id' => 'Station ID',
            'initial_litres' => 'Initial Litres',
            'cur_litres' => 'Cur Litres',
            'cur_staff_assigned' => 'Cur Staff Assigned',
            'crby' => 'Crby',
            'crdate' => 'Crdate',
            'updated_by' => 'Updated By',
            'date_updated' => 'Date Updated',
            'oil_type' => 'Oil Type',
        ];
    }
}
