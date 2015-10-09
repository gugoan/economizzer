<?php

namespace app\controllers;

use amnah\yii2\user\controllers\DefaultController as BaseUserController;
use Yii;

class UserController extends BaseUserController{

    public function init(){
        parent::init();
        Yii::$app->i18n->translations['user'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => '@app/messages',
            //'forceTranslation' => true,
        ];
    }

    public function actionAuth(){
        return "wrong!";
    }
}