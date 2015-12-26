<?php

namespace app\models;

use Yii;

class Type extends \yii\db\ActiveRecord
{

    public function rules()
    {
        return [
            [['desc_type'], 'required'],
            [['desc_type', 'hexcolor_type', 'icon_type'], 'string', 'max' => 45]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id_type' => Yii::t('app', 'ID'),
            'desc_type' => Yii::t('app', 'Description'),
            'hexcolor_type' => Yii::t('app', 'Hex Cor'),
            'icon_type' => Yii::t('app', 'Icon'),
        ];
    }

    public function getCashbooks()
    {
        return $this->hasMany(Cashbook::className(), ['type_id' => 'id_type']);
    }
}
