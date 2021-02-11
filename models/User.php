<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "tbl_user".
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property string $auth_key
 * @property string $status
 * @property int|null $created_by
 * @property string|null $created_date
 * @property string $username
 * @property string $groupid
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_user';
    }
    public $rawpassword;
    public $passwd = '';

    /**
     * Constants
     */
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'email', 'passwd', 'username','status'], 'required'],
            [['email', 'first_name', 'last_name'], 'trim'],
            ['email', 'unique'],
            ['email', 'email'],
            [['first_name', 'last_name', 'email'], 'string', 'max' => 100],
            [['passwd'], 'string', 'length' => [6, 100]],
            [['groupid'], 'integer'],
            [['first_name', 'last_name', 'email','passwd'], 'required', 'on' => self::SCENARIO_CREATE],
            [['first_name', 'last_name', 'email'], 'required', 'on' => self::SCENARIO_UPDATE],
            [['created_by'], 'integer'],
            [['created_date'], 'safe'],
            [['username'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
            'password' => 'Password',
            'passwd' => 'Password',
            'auth_key' => 'Auth Key',
            'status' => 'Status',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'username' => 'Username',
        ];
    }

    public function attributeHints() {
        return [
            'first_name'        => \Yii::t('app', 'Enter your First Name'),
            'last_name'         => \Yii::t('app', 'Enter your Last Name'),
            'email'             => \Yii::t('app', 'Enter your Email'),
            'passwd'            => \Yii::t('app', 'Pick your  Password'),
            'groupid'          => \Yii::t('app', 'Pick a Group for this user'),
            'status'            => \Yii::t('app', 'Pick a status for this user'),
            'username'          => \Yii::t('app', 'Enter your Username'),
        ];
    }

    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
        return $this->auth_key;
    }

    public function getId()
    {
        // TODO: Implement getId() method.
        return $this->id;
    }

    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
        return $this->auth_key === $authKey;
    }

    public static function findIdentity($id)
    {
        // TODO: Implement findIdentity() method.
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
        throw new \yii\base\NotSupportedException();
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username'=>$username]);
    }

    public function validatePassword($password)
    {
        //return $this->password === $password;
        return \Yii::$app->security->validatePassword($password,$this->password);
    }

    /*generating a hash password fro user*/
    public function setpassword($password)
    {
        $this->password = \Yii::$app->security->generatePasswordHash($password);
    }

    /*generating authkey*/
    public function generateAuthkey()
    {
        $this->authkey = \Yii::$app->security->generateRandomString();
    }

    public function getStatusesList()
    {
        return [
            'suspended' => \Yii::t('app', 'Suspended'),
            'active'   => \Yii::t('app', 'Active'),
        ];
    }

    public function getFullName()
    {
        return trim(sprintf('%s %s', $this->first_name, $this->last_name));
    }
}
