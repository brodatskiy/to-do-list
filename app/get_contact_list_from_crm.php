<?php
declare(strict_types=1);

use Bitrix24\SDK\Services\ServiceBuilderFactory;

// Register the Composer autoloader...
require __DIR__ . '/../vendor/autoload.php';

// init bitrix24-php-sdk service from webhook
$b24Service = ServiceBuilderFactory::createServiceBuilderFromWebhook('https://b24-v16t89.bitrix24.ru/rest/1/9j5ubmfd0m7xc2gm/');

$contacts = $b24Service->getCRMScope()->contact()->list([], [], [
    'ID',
    'NAME',
    'SECOND_NAME',
    'LAST_NAME',
    'PHONE',
    'EMAIL',
], 0)->getCoreResponse()->getResponseData()->getResult();



foreach ($contacts as &$contact) {
    $deals = $b24Service->getCRMScope()->deal()->list([], ['CONTACT_ID' => $contact['ID']], ['ID'], 0)->getCoreResponse()->getResponseData()->getResult();
    $contact['DEALS'] = $deals;
    $contact['DEALS_COUNT'] = count($deals);
}

dump(json_encode($contacts));