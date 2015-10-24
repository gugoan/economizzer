<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%account}}".
 *
 * @property integer $id
 * @property string $description
 * @property integer $user_id
 * @property integer $currency_id
 *
 * @property User $user
 * @property Currency $currency
 */
class Account extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%account}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['currency_id'], 'required'],
            [['user_id', 'currency_id'], 'integer'],
            [['description'], 'string', 'max' => 100],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['currency_id'], 'exist', 'skipOnError' => true, 'targetClass' => Currency::className(), 'targetAttribute' => ['currency_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'description' => Yii::t('app', 'Name'),
            'user_id' => Yii::t('app', 'User ID'),
            'currency_id' => Yii::t('app', 'Currency ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency()
    {
        return $this->hasOne(Currency::className(), ['id' => 'currency_id']);
    }

    public function beforeSave($insert)
    {
        $this->user_id = Yii::$app->user->id;
        return parent::beforeSave($insert);
    }
}
