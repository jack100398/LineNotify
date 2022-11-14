<?php

use App\TokenSetting;
use Illuminate\Database\Seeder;

class defaultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TokenSetting::query()->create(['name' => '測試1', 'token' => 'zclCI31BfNXv0u9VgdhsqC7A3lypM1iwJA40ao0rfIu']);
    }
}
