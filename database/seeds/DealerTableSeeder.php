<?php

use Illuminate\Database\Seeder;

class DealerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dealers')->insert([
            'code' => 'ABCDEFGHIJ',
            'name' => '本店',
            'customer_type_id' => 1,
            'address' => '东区-浙江省杭州',
            'link' => '18512342345',
            'dd_account' => '44672379',
            'level' => 1,
            'parent_id' => 0,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
    }
}
