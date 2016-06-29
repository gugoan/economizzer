<?php

namespace app\models;

use Yii;

class Category extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'category';
    }

    public function rules()
    {
        return [
            [['desc_category', 'is_active'], 'required'],
            [['is_active','user_id','parent_id'], 'integer'],
            [['desc_category', 'hexcolor_category'], 'string', 'max' => 45]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id_category' => Yii::t('app', 'ID'),
            'desc_category' => Yii::t('app', 'Description'),
            'hexcolor_category' => Yii::t('app', 'Color'),
            'parent_id' => Yii::t('app', 'Parent Category'),
            'is_active' => Yii::t('app', 'Active'),
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

    public static function getHierarchy() {
        $options = [];
         
        $parents = self::find()->where(['parent_id' => null,'user_id' => Yii::$app->user->identity->id, 'is_active' => 1])->all();
        foreach($parents as $id_category => $p) {
            $children = self::find()->where("parent_id=:parent_id", [":parent_id"=>$p->id_category])->all();
            $child_options = [];
            foreach($children as $child) {
                $child_options[$child->id_category] = $child->desc_category;
            }
            $options[$p->desc_category] = $child_options;
        }
        return $options;
    }      

    public function getParent()
    {
        return $this->hasOne(Category::className(), ['id_category' => 'parent_id']);
    }      
}
