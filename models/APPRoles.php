<?php

namespace app\models;

use Yii;
use yii\base\Model;

class APPRoles extends Model
{
    public static function isSupervisor()
    {
        $id = Yii::$app->user->id;
        $conn = Yii::$app->db;
        $q = "select count(*) from tbl_user where status = 'A' and groupid in (3,1) and id = '$id'";
        $role = $conn->createCommand($q)->queryScalar();
        if($role > 0)
        {
            return true;
        }
        return false;
    }

    public static function isManager()
    {
        $id = Yii::$app->user->id;
        $conn = Yii::$app->db;
        $q = "select count(*) from tbl_user where status = 'A' and groupid in (2,1) and id = '$id'";
        $role = $conn->createCommand($q)->queryScalar();
        if($role > 0)
        {
            return true;
        }
        return false;
    }

    public static function ismakepayment($invid)
    {
        $conn = Yii::$app->db;
        $q = "select count(*) from debtor_sales where invoice_no = $invid and status in ('C','I')";
        $role = $conn->createCommand($q)->queryScalar();
        if($role > 0)
        {
            return true;
        }
        return false;
    }
}
