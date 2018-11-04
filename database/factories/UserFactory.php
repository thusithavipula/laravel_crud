<?php

use Faker\Generator as Faker;
use App\SubjectCategory;
use App\Services\SubjectService;

/*
  |--------------------------------------------------------------------------
  | Model Factories
  |--------------------------------------------------------------------------
  |
  | This directory should contain each of the model factory definitions for
  | your application. Factories provide a convenient way to generate new
  | model instances for testing / seeding your application's database.
  |
 */

$factory->define(App\User::class, function (Faker $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'role' => 'admin',
    ];
});

$factory->define(App\Instructor::class, function (Faker $faker) {
    $titles = [
        'MR' => 'Mr.',
        'MRS' => 'Mrs.',
        'MISS' => 'Miss.',
        'REV' => 'Rev.',
    ];

    return [
        'title' => $faker->randomElement($titles),
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'education' => $faker->jobTitle,
        'is_active' => $faker->randomElement([0, 1]),
    ];
});

$factory->define(App\Student::class, function (Faker $faker) {
    $titles = [
        'MR' => 'Mr.',
        'MRS' => 'Mrs.',
        'MISS' => 'Miss.',
        'REV' => 'Rev.',
    ];

    return [
        'title' => $faker->randomElement($titles),
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'address' => $faker->address,
        'is_active' => $faker->randomElement([0, 1]),
    ];
});

$factory->define(App\Subject::class, function (Faker $faker) {
    $subjectCategory = SubjectCategory::all()->pluck('id');
    $subjectService = new SubjectService();

    return [
        'name' => $faker->firstName,
        'short_code' => $subjectService->getShortCode($faker->firstName),
        'description' => $faker->text,
        'duration' => mt_rand(1, 6),
        'category' => $faker->randomElement($subjectCategory),
        'is_active' => $faker->randomElement([0, 1]),
    ];
});
