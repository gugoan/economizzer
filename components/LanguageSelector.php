<?php

namespace app\components;
use yii\base\BootstrapInterface;
use Yii;
/**
 * Component for Detecting language automatically
 * Idea from https://github.com/samdark/yii2-cookbook/blob/master/book/i18n-selecting-application-language.md#detecting-language-automatically
 */

class LanguageSelector implements BootstrapInterface
{
    public $supportedLanguages = [];

    public function bootstrap($app)
    {
        if(!Yii::$app->user->isGuest) {

            Yii::$app->language = Yii::$app->user->identity->profile->language;
            //Yii::$app->user->getIdentity()->language = Yii::$app->language;
            // Yii::$app->formatter->defaultTimeZone = 'Europe/Malta';
            // Yii::$app->formatter->timeZone = 'Europe/Malta';
            // Yii::$app->formatter->dateFormat = 'php:d/m/Y';
            // Yii::$app->formatter->datetimeFormat = 'php:d/m/Y H:i:s';
            // Yii::$app->formatter->currencyCode = 'EUR';
            // Yii::$app->formatter->decimalSeparator = ',';
        }else{
            Yii::$app->language = Yii::$app->request->getPreferredLanguage($this->supportedLanguages);
        }
    }
}