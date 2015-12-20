<?php

namespace app\models;
use amnah\yii2\user\models\User as BaseUser;
use Yii;

class User extends BaseUser
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        // set initial rules
        $rules = [
            // general email and username rules
            [['email', 'username'], 'string', 'max' => 255],
            [['email', 'username'], 'unique'],
            [['email', 'username'], 'filter', 'filter' => 'trim'],
            [['email'], 'email'],
            [['username'], 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u', 'message' => Yii::t('user', '{attribute} can contain only letters, numbers, and "_"')],

            // password rules
            [['newPassword'], 'string', 'min' => 3],
            [['newPassword'], 'filter', 'filter' => 'trim'],
            [['newPassword'], 'required', 'on' => ['register', 'reset', 'socialonlyaccount']],
            [['newPasswordConfirm'], 'required', 'on' => ['reset', 'socialonlyaccount']],
            [['newPasswordConfirm'], 'compare', 'compareAttribute' => 'newPassword', 'message' => Yii::t('user','Passwords do not match')],

            // account page
            [['currentPassword'], 'required', 'on' => ['account']],
            [['currentPassword'], 'validateCurrentPassword', 'on' => ['account']],

            // admin crud rules
            [['role_id', 'status'], 'required', 'on' => ['admin']],
            [['role_id', 'status'], 'integer', 'on' => ['admin']],
            [['ban_time'], 'integer', 'on' => ['admin']],
            [['ban_reason'], 'string', 'max' => 255, 'on' => 'admin'],
        ];

        // add required rules for email/username depending on module properties
        $requireFields = ["requireEmail", "requireUsername"];
        foreach ($requireFields as $requireField) {
            if (Yii::$app->getModule("user")->$requireField) {
                $attribute = strtolower(substr($requireField, 7)); // "email" or "username"
                $rules[]   = [$attribute, "required"];
            }
        }

        return $rules;
    }
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app', 'Username'),
            'newPassword' => Yii::t('app', 'New Password'),
            'currentPassword' => Yii::t('app', 'Current Password'),
        ];
    }    
}
