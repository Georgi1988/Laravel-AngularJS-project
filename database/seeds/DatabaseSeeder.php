<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleTableSeeder::class);
        $this->call(CustomerKindTableSeeder::class);
        $this->call(ShopKindTableSeeder::class);
        $this->call(ShopLevelTableSeeder::class);
        $this->call(ShopPropertyTableSeeder::class);

        $this->call(DealerTableSeeder::class);

/*
        $this->call(ProductLevelTableSeeder::class);
        $this->call(ProductTableSeeder::class);
        $this->call(PriceTableSeeder::class);
        $this->call(CustomerTableSeeder::class);
        $this->call(OptionTableSeeder::class);
*/
    }
}
