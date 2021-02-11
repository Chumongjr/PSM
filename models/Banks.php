<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "banks".
 *
 * @property int|null $BANK_ID
 * @property string|null $BANK_NAME
 */
class Banks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'banks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['BANK_ID'], 'integer'],
            [['BANK_NAME'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'BANK_ID' => 'Bank ID',
            'BANK_NAME' => 'Bank Name',
        ];
    }
}
