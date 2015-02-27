<?php

namespace app\controllers;
//namespace app\components;

use Yii;

class BaseController extends \yii\web\Controller
{
    public function init()
	{
	    parent::init();

	    if(!Yii::$app->user->isGuest) {
            //Yii::$app->user->getIdentity()->language = Yii::$app->language;
            Yii::$app->language = Yii::$app->user->identity->profile->language;
        }
	}

}
