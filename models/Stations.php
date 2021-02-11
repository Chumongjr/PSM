<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "shells".
 *
 * @property int $shell_id
 * @property string $shell_name
 * @property string|null $location
 * @property string|null $address
 * @property string|null $phone_no
 * @property int|null $supervisor
 * @property int|null $no_pumps
 * @property int $crby
 * @property string $crdate
 * @property int|null $updated_by
 * @property string|null $date_updated
 */
class Stations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'shells';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['shell_name', 'crby', 'crdate'], 'required'],
            [['supervisor', 'no_pumps', 'crby', 'updated_by'], 'integer'],
            [['crdate', 'date_updated'], 'safe'],
            [['shell_name', 'location'], 'string', 'max' => 200],
            [['address'], 'string', 'max' => 100],
            [['phone_no'], 'string', 'max' => 45],
            [['shell_name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'shell_id' => 'Shell ID',
            'shell_name' => 'Shell Name',
            'location' => 'Location',
            'address' => 'Address',
            'phone_no' => 'Phone No',
            'supervisor' => 'Supervisor',
            'no_pumps' => 'No Pumps',
            'crby' => 'Crby',
            'crdate' => 'Crdate',
            'updated_by' => 'Updated By',
            'date_updated' => 'Date Updated',
        ];
    }
}
