<?php

namespace app\components;

use yii\authclient\clients\GoogleOAuth as BaseGoogleOAuth;

/**
 * Class GoogleOAuth
 * @package app\components
 */
class GoogleOAuth extends BaseGoogleOAuth
{
    private $_returnUrl;

    /**
     * Fix double encoded redirect_uri
     *
     * @return string
     */
    public function getReturnUrl()
    {
        if ($this->_returnUrl === null) {
            $this->_returnUrl = $this->defaultReturnUrl(); // Certifique-se de que este método está correto
        }

        // Adicionando um log para depuração
        \Yii::info('Return URL: ' . $this->_returnUrl, __METHOD__);

        return urldecode($this->_returnUrl);
    }

    /**
     * Método opcional para definir um returnUrl personalizado
     * 
     * @param string $url
     */
    public function setReturnUrl($url)
    {
        $this->_returnUrl = $url;
    }
}