<?php
namespace app\widgets\authchoice;
use yii\authclient\widgets\AuthChoice as BaseAuthChoice;

class AuthChoice extends BaseAuthChoice {
    /**
     * We do not need to show providers from $keychainConnects.
     * UserKeychain::getKeychainConnects()
     * @var array
     */
    public $keychainConnects = [];

    /**
     * Returns default auth clients list.
     * @return ClientInterface[] auth clients list.
     */
    protected function defaultClients()
    {
        /* @var $collection \yii\authclient\Collection */
        $collection = \Yii::$app->get($this->clientCollection);
        $collectionClients = $collection->getClients();
        $providersToExclude = [];
        foreach($this->keychainConnects as $connect){
            $providersToExclude[] = $connect['provider'];
        }
        $clients = [];
        foreach ($collectionClients as $id=>$client){
            if(!in_array($id,$providersToExclude)){
                $clients[$id] = $client;
            }
        }
        return $clients;
    }
}