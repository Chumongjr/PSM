<?php

namespace app\models;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * This is the model class for table "deductions".
 *
 * @property int $dedid
 * @property string|null $ded_name
 * @property string|null $is_percentage
 * @property int|null $employee_perc
 * @property int|null $employer_perc
 * @property int|null $fixed_amount
 */
class Deductions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'deductions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['employee_perc','employer_perc', 'fixed_amount'], 'integer'],
            [['ded_name'], 'string', 'max' => 45],
            [['is_percentage'], 'string', 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'dedid' => 'Dedid',
            'ded_name' => 'Deduction Name',
            'is_percentage' => 'Is Percentage',
            'employee_perc' => 'Employee Percentage',
            'employer_perc' => 'Employer Percentage',
            'fixed_amount' => 'Fixed Amount',
        ];
    }

    public static function dedlist()
    {
        $r = "select dedid,ded_name,case is_percentage when 'N' then 'No' when 'Y' then 'Yes' end percent,
                COALESCE(employer_perc,0) emp_perc,COALESCE(employee_perc,0) empl_perc,COALESCE(fixed_amount,0) fixed_amount
                from deductions";
        $rs = Yii::$app->db->createCommand($r)->queryAll(0);

        $tbB = "<table id='example1' class='table table-striped table-bordered'>";
        if(empty($rs))
        {
            $tbB .= "<tr><td><b>No Deduction Added. Click New Deduction to add one.</b></td></tr>";
            $tbB .= "</table";
        }else{
            $tbB .="<thead><tr><th>SN</th><th>Deduction Name</th><th>Is Percentage</th><th>Employee Perc</th><th>Employer Perc</th><th>Fixed Amount</th><th>Action</th></tr></thead><tbody>";
            $i=1;
            foreach ($rs as $s)
            {
                $tbB .= "<tr><td>$i</td><td>$s[1]</td>";
                if($s[2]=='No'){
                    $tbB .="<td><span class='badge badge-warning'>$s[2]</span></td>";
                }else{
                    $tbB .="<td><span class='badge badge-info'>$s[2]</span></td>";
                }
                $tbB .="<td>$s[3]</td><td>$s[4]</td><td>".number_format($s[5])."</td>";
                $tbB .= "<td><b>" . Html::button('<i class="fa fa-edit"></i> Update', ['value'=>Url::to(['benefits/dedupdate','dedid'=>$s[0]]),'title'=>'Update Deduction Info','class' => 'showModalButton btn btn-success btn-xs']) . "</b> </td></tr> ";
                //$tbB .= "<td><b>" . Html::a('<i class="fa fa-folder-open"></i> View Details', ['debtors/debtordet','debid'=>$s[0]], ['class' => 'btn btn-success btn-xs']) . "</b> | ";
                //$tbB .= "<b>" . Html::a('<i class="fa fa-shopping-cart"></i> Make Order', ['debtors/debtor-order','debid'=>$s[0]], ['class' => 'btn btn-info btn-xs']) . "</b></td></tr>";
                $i++;
            }
            $tbB .="</tbody></table>";
        }


        return $tbB;
    }
}
