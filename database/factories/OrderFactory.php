<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Food;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        $user = User::inRandomOrder()->first() ?? User::factory()->create();
        $foods = Food::inRandomOrder()->limit(rand(1, 5))->get();

        $totalPrice = 0;
        $foodDetails = [];
        $totalQuantity = 0;

        foreach ($foods as $food) {
            $quantity = $this->faker->numberBetween(1, 10);

            $itemTotalPrice = $food->price * $quantity;
            $totalPrice += $itemTotalPrice;
            $totalQuantity += $quantity;

            $foodDetails[] = [
                'name' => $food->title,
                'price' => $food->price,
                'quantity' => $quantity,
            ];
        }

        return [
            'name' => implode(', ', $foods->pluck('title')->toArray()),
            'price' => $totalPrice,
            'username' => $user->name,
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'status' => $this->faker->randomElement(['pending', 'completed', 'cancelled']),
            'total_price' => $totalPrice,
            'quantity' => $totalQuantity,
            'food_details' => json_encode($foodDetails),
            'is_read' => $this->faker->boolean,
        ];
    }
}
