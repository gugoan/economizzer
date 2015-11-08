<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%currency}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $short_name
 * @property string $iso_code
 * @property string $currency_rate
 * @property integer $user_id
 *
 * @property Account[] $accounts
 * @property User $user
 */
class Currency extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return '{{%currency}}';
    }

    public function rules()
    {
        return [
            [['currency_rate'], 'number'],
            [['user_id'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['short_name'], 'string', 'max' => 10],
            [['iso_code'], 'string', 'max' => 3],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Currency'),
            'short_name' => Yii::t('app', 'Short Name'),
            'iso_code' => Yii::t('app', 'Iso Code'),
            'currency_rate' => Yii::t('app', 'Currency Rate'),
            'user_id' => Yii::t('app', 'User ID'),
        ];
    }

    public function getAccounts()
    {
        return $this->hasMany(Account::className(), ['currency_id' => 'id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function beforeSave($insert)
    {
        $this->user_id = Yii::$app->user->id;
        return parent::beforeSave($insert);
    }
}
