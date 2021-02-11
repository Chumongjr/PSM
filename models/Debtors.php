<?php

namespace app\models;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;


/**
 * This is the model class for table "debtors".
 *
 * @property int $debtor_id
 * @property string $debtor_code
 * @property string $debtor_name
 * @property string|null $address
 * @property string|null $tellephone
 * @property string|null $Email
 * @property string|null $contact_person
 * @property string|null $phone_no
 * @property int|null $invoice_period
 * @property int|null $crby
 * @property string|null $crdate
 */
class Debtors extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'debtors';
    }
    public $search_debtors;
    public $oil_type;
    public $total_litre;
    public $station;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['debtor_code', 'debtor_name','oil_type','total_litre','station'], 'required'],
            [['invoice_period', 'crby','oil_type','total_litre','station'], 'integer'],
            [['crdate'], 'safe'],
            [['debtor_code', 'address', 'tellephone','search_debtors'], 'string', 'max' => 100],
            [['debtor_name', 'contact_person'], 'string', 'max' => 255],
            [['Email'], 'string', 'max' => 200],
            [['phone_no'], 'string', 'max' => 50],
            [['debtor_code'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'debtor_id' => 'Debtor ID',
            'debtor_code' => 'Debtor Code',
            'debtor_name' => 'Debtor Name',
            'address' => 'Address',
            'tellephone' => 'Telephone',
            'Email' => 'Email',
            'contact_person' => 'Contact Person',
            'phone_no' => 'Phone No',
            'invoice_period' => 'Invoice Period Days',
            'crby' => 'Crby',
            'crdate' => 'Crdate',
            'search_debtors'=>'Search Debtor',
            'total_litre'=>'Total Liters',
            'oil_type'=>'Oil Type',
            'station'=>'Station'
        ];
    }

    public static function getOrder($debinv)
    {

        $r = "select d.dbs_id,o.oil_type,d.total_litres,o.cur_price,d.total_sale from debtor_sales_oil d inner join oil_type o on o.type_id=d.oil_type where  invoice_no = :debinv and d.debtorsales_id is null";
        $dr = Yii::$app->db->createCommand($r)->bindParam(':debinv',$debinv)->queryAll(0);

        $tbD = "<table id='example1' class='table table-striped table-condensed table-bordered'>";
        $tbD .="<thead><tr><th>SN</th><th>Description</th><th>Qty</th><th>Unit Price</th><th>Total</th><th>Action</th></tr></thead><tbody>";
        $i=1;
        foreach ($dr as $d)
        {
            $tbD .= "<tr><td>$i</td><td>$d[1]</td><td>".number_format($d[2])."</td><td>".number_format($d[3],2)."</td><td>".number_format($d[4],2). "</td>";
            $tbD .= "<td><b>" . Html::button('<i class="icon edit"></i> Edit', ['value'=>Url::to(['debtors/edorderunit','dedid'=>$d[0]]),'title'=>'Edit Litres', 'class' => 'showModalButton btn btn-primary btn-xs']) . "</b> | ";
            $tbD .= "<b>" . Html::a('<i class="icon edit"></i> Remove', ['debtors/rmorderunit','dedid'=>$d[0]], ['class' => 'btn btn-danger btn-xs','onClick' => 'return confirm("Are you sure you want to remove this Item?")']) . "</b></td></tr>";
            $i++;
        }
        $tbD .="</tbody></table>";

        return $tbD;

    }

    public static function getCompleteOrder($debinv)
    {

        $r = "select d.dbs_id,o.oil_type,d.total_litres,coalesce (d.unit_price,o.cur_price),d.total_sale from debtor_sales_oil d inner join oil_type o on o.type_id=d.oil_type where  invoice_no = :debinv";
        $dr = Yii::$app->db->createCommand($r)->bindParam(':debinv',$debinv)->queryAll(0);

        $tbD = "<table id='example1' class='table table-striped table-condensed table-bordered'>";
        $tbD .="<thead><tr><th>SN</th><th>Description</th><th>Qty</th><th>Unit Price</th><th>Total</th></tr></thead><tbody>";
        $i=1;
        foreach ($dr as $d)
        {
            $tbD .= "<tr><td>$i</td><td>$d[1]</td><td>".number_format($d[2])."</td><td>".number_format($d[3],2)."</td><td>".number_format($d[4],2). "</td></tr>";
            $i++;
        }
        $tbD .="</tbody></table>";

        return $tbD;

    }
}
