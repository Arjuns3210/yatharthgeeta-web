<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;

class UserFactory extends Factory
{
    protected $model = User::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'phone' => random_int(999999999, 1000000000),
            'whatsapp_no' => random_int(999999999, 1000000000),
            'gender' => $this->faker->randomElement(['M', 'F', 'O']),
            'city' => $this->faker->city(),
            'state' => $this->faker->state(),
            'pin_code' => $this->faker->postcode(),
            'approval_status' => 'accepted',
            'approved_on' => null,
            'approved_by' => 0,
            'admin_remark' => null,
            'login_allowed' => 1,
            'otp_allowed' => 1,
            'password_allowed' => 1,
            'sms_notification' => 1,
            'email_notification' => 1,
            'whatsapp_notification' => 1,
            'is_verified' => 'Y',
            'fpwd_flag' => 'N',
            'last_login' => null,
            'email_verified_at' => null,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
