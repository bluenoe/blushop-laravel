<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateLegacyProductPricesSeeder extends Seeder
{
    /**
     * Populate original_price and randomize is_on_sale for existing products.
     * Run with: php artisan db:seed --class=UpdateLegacyProductPricesSeeder
     */
    public function run(): void
    {
        $products = Product::all();
        $updatedCount = 0;
        $saleCount = 0;

        foreach ($products as $product) {
            // 40% chance of being on sale
            $isOnSale = rand(1, 100) <= 40;

            if ($isOnSale && $product->base_price > 0) {
                $product->is_on_sale = true;

                // Random multiplier between 1.2x and 1.5x
                $multiplier = rand(120, 150) / 100;
                $rawOriginal = $product->base_price * $multiplier;

                // Round UP to nearest 10,000 for realistic pricing
                $product->original_price = ceil($rawOriginal / 10000) * 10000;

                $saleCount++;
            } else {
                $product->is_on_sale = false;
                $product->original_price = null;
            }

            $product->save();
            $updatedCount++;
        }

        $this->command->info("✅ Updated prices for {$updatedCount} products.");
        $this->command->info("🏷️  {$saleCount} products are now on sale.");
    }
}
