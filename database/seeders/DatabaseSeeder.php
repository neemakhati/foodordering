<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Food;
use App\Models\Order;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Category::factory(10)->create();
        User::factory(20)->create();

        Food::factory(50)->create();

        $orders = Order::factory(100)->create();

        foreach ($orders as $order) {
            $user = User::where('name', $order->username)->first();

            $foodDetails = json_decode($order->food_details, true);

            foreach ($foodDetails as $foodDetail) {
                $food = Food::where('title', $foodDetail['name'])->first();

                $order->foods()->attach($food->id, [
                    'user_id' => $user->id,
                ]);
            }
        }
    }
}
