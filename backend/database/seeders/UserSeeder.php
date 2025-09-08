<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companies = Company::all();

        User::create([
            'name' => 'Admin',
            'email' => 'admin@taskhub.com',
            'password' => Hash::make('password'),
            'company_id' => $companies->first()->id,
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'João Silva',
            'email' => 'joao@taskhub.com',
            'password' => Hash::make('password'),
            'company_id' => $companies->first()->id,
            'email_verified_at' => now(),
        ]);

        User::factory(8)->create()->each(function ($user) use ($companies) {
            $user->update([
                'company_id' => $companies->random()->id
            ]);
        });
    }
}
