<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::factory()->create();

        return [
            'user_id' => $user->id,
            'amount' => 0,
            'status' => 1,
            'created_at' => $this->faker->dateTimeThisMonth(),
            'updated_at' => $this->faker->dateTimeThisMonth(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Order $order) {
            $products = Product::factory(3)->create();

            $totalAmount = 0;

            foreach ($products as $product) {
                $quantity = $this->faker->numberBetween(1, 10);
                $price = $product->price;

                $order->orderDetails()->create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $price,
                ]);

                $totalAmount += $quantity * $price;
            }

            $order->update(['amount' => $totalAmount]);
        });
    }
}
