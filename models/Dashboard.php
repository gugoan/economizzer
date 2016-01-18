<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cashbook".
 *
 * @property integer $id
 * @property double $value
 * @property string $description
 * @property string $date
 * @property integer $is_pending
 * @property string $attachment
 * @property string $inc_datetime
 * @property string $edit_datetime
 * @property integer $user_id
 * @property integer $category_id
 * @property integer $type_id
 *
 * @property Category $category
 * @property Type $type
 * @property User $user
 */
class Dashboard extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cashbook';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['value', 'date', 'user_id', 'category_id', 'type_id'], 'required'],
            [['value'], 'number'],
            [['date', 'inc_datetime', 'edit_datetime'], 'safe'],
            [['is_pending', 'user_id', 'category_id', 'type_id'], 'integer'],
            [['description'], 'string', 'max' => 45],
            [['attachment'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id_category']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => Type::className(), 'targetAttribute' => ['type_id' => 'id_type']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'value' => Yii::t('app', 'Value'),
            'description' => Yii::t('app', 'Description'),
            'date' => Yii::t('app', 'Date'),
            'is_pending' => Yii::t('app', 'Is Pending'),
            'attachment' => Yii::t('app', 'Attachment'),
            'inc_datetime' => Yii::t('app', 'Inc Datetime'),
            'edit_datetime' => Yii::t('app', 'Edit Datetime'),
            'user_id' => Yii::t('app', 'User ID'),
            'category_id' => Yii::t('app', 'Category ID'),
            'type_id' => Yii::t('app', 'Type ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id_category' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(Type::className(), ['id_type' => 'type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
