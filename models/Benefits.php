<?php

namespace app\models;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * This is the model class for table "benefits".
 *
 * @property int $benid
 * @property string $ben_name
 * @property string|null $is_percentage
 * @property int|null $percentage
 * @property int|null $fixed_amount
 */
class Benefits extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'benefits';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ben_name'], 'required'],
            [['percentage', 'fixed_amount'], 'integer'],
            [['ben_name'], 'string', 'max' => 200],
            [['is_percentage'], 'string', 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'benid' => 'Benid',
            'ben_name' => 'Benefit Name',
            'is_percentage' => 'Is Percentage',
            'percentage' => 'Percentage',
            'fixed_amount' => 'Fixed Amount',
        ];
    }

    public static function benlist()
    {
        $r = "select benid,ben_name,case is_percentage when 'N' then 'No' when 'Y' then 'Yes' end percent,
                COALESCE(percentage,0) percentage,COALESCE(fixed_amount,0) fixed_amount
                from benefits";
        $rs = Yii::$app->db->createCommand($r)->queryAll(0);

        $tbB = "<table id='example1' class='table table-striped table-bordered'>";
        if(empty($rs))
        {
            $tbB .= "<tr><td><b>No Benefits Added. Click New Benefit to add one.</b></td></tr>";
            $tbB .= "</table";
        }else{
            $tbB .="<thead><tr><th>SN</th><th>Benefit Name</th><th>Is Percentage</th><th>Percentage</th><th>Fixed Amount</th><th>Action</th></tr></thead><tbody>";
            $i=1;
            foreach ($rs as $s)
            {
                $tbB .= "<tr><td>$i</td><td>$s[1]</td>";
                if($s[2]=='No'){
                    $tbB .="<td><span class='badge badge-warning'>$s[2]</span></td>";
                }else{
                    $tbB .="<td><span class='badge badge-info'>$s[2]</span></td>";
                }
                $tbB .="<td>$s[3]</td><td>".number_format($s[4])."</td>";
                $tbB .= "<td><b>" . Html::button('<i class="fa fa-edit"></i> Update Details', ['value'=>Url::to(['benefits/update','bid'=>$s[0]]),'title'=>'Update Benefit Info','class' => 'showModalButton btn btn-success btn-xs']) . "</b> </td></tr> ";
                //$tbB .= "<td><b>" . Html::a('<i class="fa fa-folder-open"></i> View Details', ['debtors/debtordet','debid'=>$s[0]], ['class' => 'btn btn-success btn-xs']) . "</b> | ";
                //$tbB .= "<b>" . Html::a('<i class="fa fa-shopping-cart"></i> Make Order', ['debtors/debtor-order','debid'=>$s[0]], ['class' => 'btn btn-info btn-xs']) . "</b></td></tr>";
                $i++;
            }
            $tbB .="</tbody></table>";
        }


        return $tbB;
    }
}
