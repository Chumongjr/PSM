<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "positions".
 *
 * @property int $posid
 * @property string $pos_name
 */
class Positions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'positions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pos_name'], 'required'],
            [['pos_name'], 'string', 'max' => 45],
            [['pos_name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'posid' => 'Posid',
            'pos_name' => 'Position Name',
        ];
    }
}
