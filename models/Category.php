<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tb_category".
 *
 * @property integer $id_category
 * @property string $desc_category
 * @property string $hexcolor_category
 *
 * @property Cashbook[] $cashbooks
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_category';
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
            'id_category' => Yii::t('app', 'ID'),
            'desc_category' => Yii::t('app', 'Description'),
            'hexcolor_category' => Yii::t('app', 'Hex Color'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCashbooks()
    {
        return $this->hasMany(Cashbook::className(), ['category_id' => 'id_category']);
    }
}
