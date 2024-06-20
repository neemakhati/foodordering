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
        // Get a random existing user, or create one if none exists
        $user = User::inRandomOrder()->first() ?? User::factory()->create();

        // Get random existing foods (between 1 to 5)
        $foods = Food::inRandomOrder()->limit(rand(1, 5))->get();

        // Initialize variables for total price and food details
        $totalPrice = 0;
        $foodDetails = [];
        $totalQuantity = 0;

        // Define order details for each food item
        foreach ($foods as $food) {
            // Random quantity between 1 and 10 for each food item
            $quantity = $this->faker->numberBetween(1, 10);

            // Calculate total price for each food item
            $itemTotalPrice = $food->price * $quantity;
            $totalPrice += $itemTotalPrice;
            $totalQuantity += $quantity;

            // Build food details array for this order
            $foodDetails[] = [
                'name' => $food->title,
                'price' => $food->price,
                'quantity' => $quantity,
            ];
        }

        return [
            'name' => implode(', ', $foods->pluck('title')->toArray()), // Concatenate all food titles
            'price' => $totalPrice,
            'username' => $user->name,
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'status' => $this->faker->randomElement(['pending', 'completed', 'cancelled']),
            'total_price' => $totalPrice,
            'quantity' => $totalQuantity, // Store the total quantity
            'food_details' => json_encode($foodDetails), // Store food details as JSON
            'is_read' => $this->faker->boolean,
        ];
    }
}
