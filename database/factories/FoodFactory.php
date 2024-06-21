<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Food;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Food>
 */
class FoodFactory extends Factory
{
    protected $model = Food::class;

    public function definition()
    {
        $category = Category::inRandomOrder()->first();
        $categoryId = $category ? $category->id : Category::factory()->create()->id;
        $imagePath = $this->getRandomImagePath();
        return [
            'title' => $this->faker->word,
            'price' => $this->faker->numberBetween(1, 1000),
            'image' => $imagePath,
            'description' => $this->faker->words(5, true),
            'categories_id' => $categoryId,
            'isTrending' => $this->faker->boolean,
        ];
    }
    private function getRandomImagePath()
    {
        $path = public_path('foodimage');
        $files = scandir($path);

        $images = array_filter($files, function($file) use ($path) {
            return is_file($path . DIRECTORY_SEPARATOR . $file);
        });

        if (count($images) > 0) {
            $randomImage = $this->faker->randomElement($images);
            return $randomImage;
        }

        return 'default.jpg';
    }
}
