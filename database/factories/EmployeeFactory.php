<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_no' => $this->faker->numberBetween($min = 5000, $max = 10000),
            'first_name' => $this->faker->firstName(),
            'middle_name' => $this->faker->lastName(),
            'last_name' => $this->faker->lastName(),
            'sex' => $this->faker->randomElement($array = array('Male', 'Female')),
            'contact_no' => '09'.$this->faker->numberBetween($min = 8888888888, $max = 9999999999),
            'birthday' => date("d/m/Y", strtotime($this->faker->date())),
            'address' => $this->faker->streetName(),
        ];
    }
}
