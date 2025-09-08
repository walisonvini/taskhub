<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::create([
            'name' => 'TaskHub Corp',
            'alias' => 'taskhub',
            'cnpj' => '12345678000190',
        ]);

        Company::create([
            'name' => 'Tech Solutions',
            'alias' => 'techsol',
            'cnpj' => '98765432000110',
        ]);
    }
}
