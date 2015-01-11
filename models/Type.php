<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%type}}".
 *
 * @property integer $id_type
 * @property string $desc_type
 * @property string $hexcolor_type
 * @property string $icon_type
 */
class Type extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%type}}';
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
            'id_type' => Yii::t('app', 'Id Type'),
            'desc_type' => Yii::t('app', 'Desc Type'),
            'hexcolor_type' => Yii::t('app', 'Hexcolor Type'),
            'icon_type' => Yii::t('app', 'Icon Type'),
        ];
    }
}
