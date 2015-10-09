<?php
namespace app\models;

use amnah\yii2\user\models\Profile as BaseProfile;
use Yii;
/**
 * This is the model class for table "tbl_profile".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string  $create_time
 * @property string  $update_time
 * @property string  $full_name
 * @property string  $language
 *
 * @property User    $user
 */
class Profile extends BaseProfile {

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//            [['user_id'], 'required'],
//            [['user_id'], 'integer'],
//            [['create_time', 'update_time'], 'safe'],
            [['full_name'], 'string', 'max' => 255],
            [['language'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => Yii::t('user', 'ID'),
            'user_id'     => Yii::t('user', 'User ID'),
            'create_time' => Yii::t('user', 'Create Time'),
            'update_time' => Yii::t('user', 'Update Time'),
            'full_name'   => Yii::t('user', 'Full Name'),
            'language' => Yii::t('user', 'Language'),
        ];
    }
}