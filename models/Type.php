<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tb_type".
 *
 * @property integer $id_type
 * @property string $desc_type
 * @property string $hexcolor_type
 * @property string $icon_type
 *
 * @property Cashbook[] $cashbooks
 */
class Type extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['desc_type'], 'required'],
            [['desc_type', 'hexcolor_type', 'icon_type'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_type' => Yii::t('app', 'ID'),
            'desc_type' => Yii::t('app', 'Description'),
            'hexcolor_type' => Yii::t('app', 'Hex Cor'),
            'icon_type' => Yii::t('app', 'Icon'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCashbooks()
    {
        return $this->hasMany(Cashbook::className(), ['type_id' => 'id_type']);
    }
}
