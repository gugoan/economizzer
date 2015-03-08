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
            // test..
            Yii::$app->formatter->defaultTimeZone = 'Europe/Malta';
            Yii::$app->formatter->timeZone = 'Europe/Malta';
            Yii::$app->formatter->dateFormat = 'php:d/m/Y';
            Yii::$app->formatter->datetimeFormat = 'php:d/m/Y H:i:s';
            Yii::$app->formatter->currencyCode = 'EUR';
            Yii::$app->formatter->decimalSeparator = ',';
        }
	}

}
