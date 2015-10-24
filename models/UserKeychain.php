<?php

namespace app\models;
use amnah\yii2\user\models\UserAuth;
use yii\base\ErrorException;
use yii\helpers\Url;
use yii\web\UnauthorizedHttpException;

class UserKeychain {
    /**
     * Select all records from user_auth for current user and extract provider attributes
     * @return array
     */
    public static function getKeychainConnects()
    {
        $connectedAccounts = [];
        $accounts = UserAuth::find()
            ->where(['user_id' => \Yii::$app->user->id])
            ->orderBy('create_time')
            ->all();
        if ($accounts){
            foreach ($accounts as $account){
                switch ($account->provider){
                    case 'google':
                        $connectedAccounts[] = self::parseGoogleProviderAttributes($account);
                        break;
                    case 'facebook':
                        $connectedAccounts[] = self::parseFacebookProviderAttributes($account);
                        break;
                    case 'twitter':
                        $connectedAccounts[] = self::parseTwitterProviderAttributes($account);
                        break;
                    case 'vkontakte':
                        $connectedAccounts[] = self::parseVkontakteProviderAttributes($account);
                        break;
                }
            }
        }
        return $connectedAccounts;
    }

    /**
     * Extract provider attributes from google account
     * @param $account
     * @return array
     */
    protected static function parseGoogleProviderAttributes($account)
    {
        $encodedAttributes = json_decode($account->provider_attributes);
        return [
            'displayName' => $encodedAttributes->displayName,
            'imageUrl' => $encodedAttributes->image->url,
            'url' => $encodedAttributes->url,
            'provider' => $account->provider,
            'user_id' => $account->user_id,
            'id' => $account->id,
        ];
    }

    /**
     * Extract provider attributes from facebook account
     * @param $account
     * @return array
     */
    protected static function parseFacebookProviderAttributes($account)
    {
        $encodedAttributes = json_decode($account->provider_attributes);
        return [
            'displayName' => $encodedAttributes->name,
            'imageUrl' => Url::to('//graph.facebook.com/v2.5/'.$encodedAttributes->id.'/picture'),
            'url' => Url::to('//facebook.com/'.$encodedAttributes->id),
            'provider' => $account->provider,
            'user_id' => $account->user_id,
            'id' => $account->id,
        ];
    }

    /**
     * Extract provider attributes from twitter account
     * @param $account
     * @return array
     */
    protected static function parseTwitterProviderAttributes($account)
    {
        $encodedAttributes = json_decode($account->provider_attributes);
        return [
            'displayName' => $encodedAttributes->screen_name,
            'imageUrl' => $encodedAttributes->profile_image_url_https,
            'url' => Url::to('//twitter.com/intent/user?user_id='.$encodedAttributes->id),
            'provider' => $account->provider,
            'user_id' => $account->user_id,
            'id' => $account->id,
        ];
    }

    /**
     * Extract provider attributes from Vkontakte account
     * @param $account
     * @return array
     */
    protected static function parseVkontakteProviderAttributes($account)
    {
        $encodedAttributes = json_decode($account->provider_attributes);
        return [
            'displayName' => $encodedAttributes->first_name.' '.$encodedAttributes->last_name,
            'imageUrl' => $encodedAttributes->photo,
            'url' => Url::to('//vk.com/'.$encodedAttributes->id),
            'provider' => $account->provider,
            'user_id' => $account->user_id,
            'id' => $account->id,
        ];
    }

    /**
     * Delete user account connection
     * @param $userAuthId
     * @return false|int
     * @throws
     */
    public static function disconnect($userAuthId)
    {
        if (\Yii::$app->user->isGuest){
            throw new UnauthorizedHttpException(\Yii::t('user', 'Guests can not disconnect accounts'));
        }
        $user = \Yii::$app->user->identity;
        if (empty($user->password) && (count($user->userAuths) < 2)){
            throw new ErrorException(\Yii::t('user', 'Can not disconnect single authentication method. Please fill email and password and try again'));
        }
        $userAuth = UserAuth::findOne($userAuthId);
        if ($userAuth->user_id != \Yii::$app->user->id){
            throw new UnauthorizedHttpException(\Yii::t('user', 'Сan not disconnect a foreign account'));
        }
        return $userAuth->delete();
    }

}