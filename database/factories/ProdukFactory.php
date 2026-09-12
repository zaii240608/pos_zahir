<?php

namespace Database\Factories;

use App\Models\Produk;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Produk>
 */
class ProdukFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $hargabeli = fake()->numberBetween(5000, 50000);
        $hargajual = $hargabeli + fake()->numberBetween(1000, 10000);

        return [
            'user_id' => User::where('role_id', 1)->inRandomOrder()->value('id'),
            'foto' => 'produk/' . $this->faker->uuid . '.jpg',
            'nama' => $this->faker->words(3, true),
            'harga_beli' => $hargabeli,
            'harga_jual' => $hargajual,
            'stok' => fake()->numberBetween(1, 500),
        ];
    }
}
