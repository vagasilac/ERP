<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('ro_RO');

        User::create([
            'firstname' => 'Root',
            'lastname' => 'Steiger',
            'email' => 'rootsteiger@mailinator.com',
            'personal_email' => 'rootsteigerpersonal@mailinator.com',
            'password' => bcrypt('st3ig3r00t'),
            'remember_token' => str_random(10),
            'job_title' => $faker->jobTitle,
            'address' => $faker->streetAddress,
            'city' => 'Satu Mare',
            'county' => 'Satu Mare',
            'country' => 'RO',
            'phone' => $faker->tollFreePhoneNumber,
            'personal_phone' => $faker->tollFreePhoneNumber,
            'dob' => $faker->dateTimeBetween($startDate = '-60 years', $endDate = 'now'),
            'id_card' => strtoupper($faker->randomLetter . $faker->randomLetter) . $faker->randomNumber(6),
            'bank_account' => $faker->bankAccountNumber
        ]);

        factory(User::class, 5)->create();
    }
}
