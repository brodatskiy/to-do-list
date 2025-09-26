<?php
declare(strict_types=1);

use Bitrix24\SDK\Services\ServiceBuilderFactory;

// Register the Composer autoloader...
require __DIR__ . '/../vendor/autoload.php';

// init bitrix24-php-sdk service from webhook
$b24Service = ServiceBuilderFactory::createServiceBuilderFromWebhook('https://b24-v16t89.bitrix24.ru/rest/1/9j5ubmfd0m7xc2gm/');
$faker = Faker\Factory::create();

for ($i = 0; $i < 5; $i++) {
    $b24Service->getCRMScope()->contact()->add([
        'NAME' => $faker->firstName(),
        'SECOND_NAME' => $faker->lastName,
        'LAST_NAME' => $faker->lastName,
        'BIRTHDATE' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'PHONE' => [[
            'VALUE_TYPE' => 'MOBILE',
            'VALUE' => $faker->phoneNumber,
        ]
        ],
        'EMAIL' => [[
            'VALUE_TYPE' => 'MAILING',
            'VALUE' => $faker->email,
        ]
        ],
    ]);
}


$contactsIds = $b24Service->getCRMScope()->contact()->list([], [], ['ID'], 0)->getContacts();

for ($i = 0; $i < 15; $i++) {
    $b24Service->getCRMScope()->deal()->add([
        'TITLE' => $faker->word(),
        'OPPORTUNITY' => $faker->numberBetween($min = 1000, $max = 10000),
        'CONTACT_IDS' => [$contactsIds[array_rand($contactsIds)]->ID],
    ]);
}