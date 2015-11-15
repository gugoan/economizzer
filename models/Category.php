<?php

namespace app\models;

use Yii;

class Category extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'tb_category';
    }

    public function rules()
    {
        return [
            [['desc_category'], 'required'],
            [['user_id'], 'integer'],
            [['desc_category', 'hexcolor_category'], 'string', 'max' => 45]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id_category' => Yii::t('app', 'ID'),
            'desc_category' => Yii::t('app', 'Description'),
            'hexcolor_category' => Yii::t('app', 'Color'),
        ];
    }

    public function getCashbooks()
    {
        return $this->hasMany(Cashbook::className(), ['category_id' => 'id_category']);
    }

    public function getUser() 
    { 
       return $this->hasOne(User::className(), ['id' => 'user_id']); 
    } 
}
