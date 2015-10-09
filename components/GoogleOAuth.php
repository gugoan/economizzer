<?php

namespace app\components;
use yii\authclient\clients\GoogleOAuth as BaseGoogleOAuth;

/**
 * Class GoogleOAuth
 * @package app\components
 */
class GoogleOAuth extends BaseGoogleOAuth{
    private $_returnUrl;

    /**
     * Fix wrong redirect_uri
     *
     * @return string
     */
    public function getReturnUrl()
    {
        if ($this->_returnUrl === null) {
            $this->_returnUrl = $this->defaultReturnUrl();
        }
        return urldecode($this->_returnUrl);
    }
}