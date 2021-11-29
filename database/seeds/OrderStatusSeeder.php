<?php

use App\OrderStatus;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OrderStatus::insert(
            [
                ['value' => 'Open'],
                ['value' => 'In progress'],
                ['value' => 'Completed'],
                ['value' => 'Cancel']
            ]
        );
    }
}
