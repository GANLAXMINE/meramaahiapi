<?php
namespace Database\seeders;
use App\Models\Admin;
use Illuminate\Database\seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $data = [
            'name' => 'admin',
            'email' => 'admin@hito.com',
            'password' => Hash::make('12345678'),
                // 'phone' => '98166422',
        ];

        Admin::create($data);
    }
}
