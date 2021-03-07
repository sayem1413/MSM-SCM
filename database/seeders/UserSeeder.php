<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = 'Admin';
        $email = 'admin@gmail.com';
        $phone = '01680611205';
        $pin = '123456';
        $password = '123456789';
        $user = User::where('email', $email)->first();
        if ( !$user ) {
            User::create([
                'name'              => $name,
                'email'             => $email,
                'phone'             => $phone,
                'pin'               => $pin,
                'email_verified_at' => now(),
                'password'          => bcrypt($password),
            ]);
        } else {
            $user->update([
                'name'              => $name,
                'email'             => $email,
                'phone'             => $phone,
                'pin'               => $pin,
                'email_verified_at' => now(),
                'password'          => bcrypt($password),
            ]);
        }
    }
}
