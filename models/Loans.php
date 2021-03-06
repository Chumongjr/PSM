<?php

namespace app\models;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * This is the model class for table "loans".
 *
 * @property int $loanid
 * @property string $loan_name
 * @property int $payperiod
 * @property int $interest
 */
class Loans extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'loans';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['loan_name', 'payperiod', 'interest'], 'required'],
            [['payperiod', 'interest'], 'integer'],
            [['loan_name'], 'string', 'max' => 200],
            [['loan_name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'loanid' => 'Loanid',
            'loan_name' => 'Loan Name',
            'payperiod' => 'Payperiod',
            'interest' => 'Interest',
        ];
    }

    public static function loanlist()
    {
        $r = "select loanid,loan_name,payperiod,interest  from loans";
        $rs = Yii::$app->db->createCommand($r)->queryAll(0);

        $tbB = "<table id='example1' class='table table-striped table-bordered'>";
        if(empty($rs))
        {
            $tbB .= "<tr><td><b>No Loans Added. Click New Loan to add one.</b></td></tr>";
            $tbB .= "</table";
        }else{
            $tbB .="<thead><tr><th>SN</th><th>Loan Name</th><th>Repayment Period</th><th>Interest Rate</th><th>Action</th></tr></thead><tbody>";
            $i=1;
            foreach ($rs as $s)
            {
                $tbB .= "<tr><td>$i</td><td>$s[1]</td><td>$s[2]</td><td>$s[3]</td>";
                $tbB .= "<td><b>" . Html::button('<i class="fa fa-edit"></i> Update', ['value'=>Url::to(['benefits/loanupd','lid'=>$s[0]]),'title'=>'Update Loan Info','class' => 'showModalButton btn btn-success btn-xs']) . "</b> </td></tr> ";
                //$tbB .= "<td><b>" . Html::a('<i class="fa fa-folder-open"></i> View Details', ['debtors/debtordet','debid'=>$s[0]], ['class' => 'btn btn-success btn-xs']) . "</b> | ";
                //$tbB .= "<b>" . Html::a('<i class="fa fa-shopping-cart"></i> Make Order', ['debtors/debtor-order','debid'=>$s[0]], ['class' => 'btn btn-info btn-xs']) . "</b></td></tr>";
                $i++;
            }
            $tbB .="</tbody></table>";
        }


        return $tbB;
    }
}
