<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "debtor_sales".
 *
 * @property int $debtorsale_id
 * @property int $debtor_id
 * @property int $station_id
 * @property int $total_litres
 * @property int $total_sale
 * @property string $status
 * @property int $invoice_no
 * @property int $crby
 * @property string $crdate
 * @property int|null $paid_amount
 * @property string|null $payment_date
 * @property int|null $payment_method
 * @property int|null $captured_by
 */
class Debtorsales extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'debtor_sales';
    }
    public $payment_method;
    public $payment_type;
    public $station;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['debtor_id', 'station_id', 'total_litres', 'total_sale', 'paid_amount','invoice_no', 'crby', 'crdate','payment_type','payment_method'], 'required'],
            [['debtor_id', 'station_id', 'total_litres', 'total_sale', 'invoice_no', 'crby', 'paid_amount','payment_method', 'captured_by'], 'integer'],
            [['crdate', 'payment_date'], 'safe'],
            [['status','payment_type'], 'string', 'max' => 5],
            [['invoice_no'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'debtorsale_id' => 'Debtorsale ID',
            'debtor_id' => 'Debtor ID',
            'station_id' => 'Station ID',
            'total_litres' => 'Total Litres',
            'total_sale' => 'Total Sale',
            'status' => 'Status',
            'invoice_no' => 'Invoice No',
            'crby' => 'Crby',
            'crdate' => 'Crdate',
            'paid_amount' => 'Paid Amount',
            'payment_date' => 'Payment Date',
            'payment_method' => 'Payment Method',
            'captured_by' => 'Captured By',
        ];
    }
}
