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
            'name' => $this->faker->firstName().' '.$this->faker->lastName(),
            'sex' => $this->faker->randomElement($array = array('Male', 'Female')),
            'contact_no' => '09'+$this->faker->numberBetween($min = 8888888888, $max = 9999999999),
            'birthday' => date("d/m/Y", strtotime($this->faker->date())),
            'address' => $this->faker->streetName(),
        ];
    }
}
