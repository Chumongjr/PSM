<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "company_profile".
 *
 * @property int $company_no
 * @property string $company_name
 * @property string|null $address
 * @property string $company_tel
 * @property string|null $email
 * @property string|null $contact_person
 * @property string|null $phone_no
 * @property string|null $location
 * @property string|null $bank_acc
 * @property int $bank_name
 */
class CompanyProfile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'company_profile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_name', 'company_tel'], 'required'],
            [['company_name', 'address', 'company_tel', 'email', 'contact_person', 'phone_no', 'location','bank_acc','bank_name'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'company_no' => 'Company No',
            'company_name' => 'Company Name',
            'address' => 'Address',
            'company_tel' => 'Company Telephone',
            'email' => 'Email',
            'contact_person' => 'Contact Person',
            'phone_no' => 'Phone No',
            'location' => 'Location',
            'bank_acc'=>'Bank Account',
            'bank_name'=>'Bank Name',
        ];
    }
}
