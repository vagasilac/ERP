<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create Models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {

    $faker->addProvider(new Faker\Provider\ro_RO\Person($faker));
    $faker->addProvider(new Faker\Provider\ro_RO\Address($faker));
    $faker->addProvider(new Faker\Provider\ro_RO\PhoneNumber($faker));


    return [
        'firstname' => $faker->firstName,
        'lastname' => $faker->lastName,
        'email' => $faker->email,
        'personal_email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
        'job_title' => $faker->jobTitle,
        'address' => $faker->streetAddress,
        'city' => 'Carei',
        'county' => 'Satu Mare',
        'country' => 'RO',
        'phone' => $faker->tollFreePhoneNumber,
        'personal_phone' => $faker->tollFreePhoneNumber,
        'dob' => $faker->dateTimeBetween($startDate = '-60 years', $endDate = 'now'),
        'id_card' => strtoupper($faker->randomLetter . $faker->randomLetter) . $faker->randomNumber(6),
        'bank_account' => $faker->bankAccountNumber
    ];
});

$factory->define(App\Models\Customer::class, function (Faker\Generator $faker) {

    $faker->addProvider(new Faker\Provider\ro_RO\Person($faker));
    $faker->addProvider(new Faker\Provider\ro_RO\Address($faker));
    $faker->addProvider(new Faker\Provider\ro_RO\PhoneNumber($faker));


    return [
        'name' => $faker->company,
        'company_number' => $faker->randomNumber(6),
        'vat_number' => $faker->randomNumber(6),
        'address' => $faker->streetAddress,
        'city' => 'Satu Mare',
        'county' => 'Satu Mare',
        'country' => 'RO',
        'delivery_address' => $faker->streetAddress,
        'delivery_city' => 'Satu Mare',
        'delivery_county' => 'Satu Mare',
        'delivery_country' => 'RO',
        'office_phone' => $faker->tollFreePhoneNumber,
        'office_email' => $faker->email,
        'website' => $faker->url
    ];
});

$factory->define(App\Models\Supplier::class, function (Faker\Generator $faker) {

    $faker->addProvider(new Faker\Provider\ro_RO\Person($faker));
    $faker->addProvider(new Faker\Provider\ro_RO\Address($faker));
    $faker->addProvider(new Faker\Provider\ro_RO\PhoneNumber($faker));


    return [
        'name' => $faker->company,
        'type' => rand(1, 2),
        'company_number' => $faker->randomNumber(6),
        'vat_number' => $faker->randomNumber(6),
        'address' => $faker->streetAddress,
        'city' => 'Satu Mare',
        'county' => 'Satu Mare',
        'country' => 'RO',
        'office_phone' => $faker->tollFreePhoneNumber,
        'office_email' => $faker->email,
        'website' => $faker->url
    ];
});

$factory->define(App\Models\Project::class, function (Faker\Generator $faker) {

    $faker->addProvider(new Faker\Provider\ro_RO\Person($faker));
    $faker->addProvider(new Faker\Provider\ro_RO\Address($faker));
    $faker->addProvider(new Faker\Provider\ro_RO\PhoneNumber($faker));


    return [
        'name' => $faker->sentence(6, true),
        'description' => $faker->text(200),
        'customer_id' => rand(1, 5),
        'primary_responsible' => rand(1, 5),
        'secondary_responsible' => rand(1, 5),
        'deadline' => $faker->date('Y-m-d 00:00:00'),
        'management_note' => $faker->text(200),
        'primary_code' => rand(1, 5),
        'secondary_code' => rand(1, 8),
        'production_code' => strtoupper($faker->lexify('??')),
        'version' => 1
    ];
});