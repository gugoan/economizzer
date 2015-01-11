<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%cashbook}}".
 *
 * @property integer $id
 * @property integer $category_id
 * @property integer $type_id
 * @property double $value
 * @property string $description
 * @property string $date
 * @property integer $is_pending
 * @property string $attachment
 * @property string $inc_datetime
 * @property string $edit_datetime
 */
class Cashbook extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cashbook}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'type_id', 'value', 'date'], 'required'],
            [['category_id', 'type_id', 'is_pending'], 'integer'],
            [['value'], 'number'],
            [['date', 'inc_datetime', 'edit_datetime'], 'safe'],
            [['description'], 'string', 'max' => 45],
            [['attachment'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'category_id' => Yii::t('app', 'Category ID'),
            'type_id' => Yii::t('app', 'Type ID'),
            'value' => Yii::t('app', 'Value'),
            'description' => Yii::t('app', 'Description'),
            'date' => Yii::t('app', 'Date'),
            'is_pending' => Yii::t('app', 'Is Pending'),
            'attachment' => Yii::t('app', 'Attachment'),
            'inc_datetime' => Yii::t('app', 'Inc Datetime'),
            'edit_datetime' => Yii::t('app', 'Edit Datetime'),
        ];
    }
}
