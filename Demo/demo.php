<?php
$loader = require '../vendor/autoload.php';
require 'config_dev.php';

use MediaGateway\Provider\ProviderChain;
use MediaGateway\Provider\YoutubeProvider;
use MediaGateway\Provider\VimeoProvider;
use MediaGateway\Provider\DailymotionProvider;

//Youtube Client init
$youtubeClient = new \Google_Client();
$youtubeClient->setDeveloperKey($youtubeConfig['developer_key']);
//Youtube Provider init
$youtubeProvider = new YoutubeProvider(new \Google_Service_YouTube($youtubeClient));


//Vimeo Client init
$vimeoClient = new \Vimeo\Vimeo($vimeoConfig['api_key'], $vimeoConfig['secret_key'], $vimeoConfig['access_token']);
//Vimeo Provider init
$vimeoProvider = new VimeoProvider($vimeoClient);


//Dailymotion Client init
$dailymotionClient = new \Dailymotion();
$dailymotionClient->setGrantType(\Dailymotion::GRANT_TYPE_CLIENT_CREDENTIALS, $dailymotionConfig['api_key'], $dailymotionConfig['secret_key']);
//Vimeo Provider init
$dailymotionProvider = new DailymotionProvider($dailymotionClient);

//providerChain init and doing search
$providerChain = new ProviderChain();
$providerChain
    ->addProvider($youtubeProvider)
    ->addProvider($vimeoProvider)
    ->addProvider($dailymotionProvider)
;
$query = new \MediaGateway\Query();
$query->setTerm('kittens')->setLimit(10);

$result = $providerChain->search($query);

print '<pre>';
print_r($result);
