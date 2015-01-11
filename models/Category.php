<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property integer $id_category
 * @property string $desc_category
 * @property string $hexcolor_category
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['desc_category'], 'required'],
            [['desc_category', 'hexcolor_category'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_category' => Yii::t('app', 'Id Category'),
            'desc_category' => Yii::t('app', 'Desc Category'),
            'hexcolor_category' => Yii::t('app', 'Hexcolor Category'),
        ];
    }
}
