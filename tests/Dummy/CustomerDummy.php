<?php

namespace Tests\Dummy;

use Faker\Generator;

class CustomerDummy
{
    private Generator $faker;

    public function __construct(Generator $faker)
    {
        $this->faker = $faker;
    }

    public function create(): array
    {
        $gender = ['male', 'female'];
        $selectedGender = array_rand($gender);

        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->email,
            'username' => $this->faker->userName,
            'password' => $this->faker->password,
            'gender' => $gender[$selectedGender],
            'country' => $this->faker->country(),
            'city' => $this->faker->city(),
            'phone' => $this->faker->phoneNumber,
        ];
    }
}
