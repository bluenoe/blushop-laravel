<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ReassignProductCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:reassign-categories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reassign products from "Uncategorized" to suitable categories based on product attributes.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting product category reassignment...');
        Log::info('Starting product category reassignment...');

        $uncategorizedCategory = Category::query()->firstOrCreate(['name' => 'Uncategorized'], ['slug' => 'uncategorized']);
        $productsToReassign = Product::query()->where('category_id', $uncategorizedCategory->id)->get();

        if ($productsToReassign->isEmpty()) {
            $this->info('No products found in the "Uncategorized" category.');
            Log::info('No products found in the "Uncategorized" category.');
            return;
        }

        $this->info("Found {$productsToReassign->count()} products to reassign.");
        Log::info("Found {$productsToReassign->count()} products to reassign.");

        $categoryKeywords = $this->getCategoryKeywords();

        foreach ($productsToReassign as $product) {
            $this->reassignProduct($product, $categoryKeywords, $uncategorizedCategory);
        }

        $this->info('Product category reassignment completed.');
        Log::info('Product category reassignment completed.');
    }

    private function getCategoryKeywords(): array
    {
        return [
            'Tech' => ['tech', 'laptop', 'smartphone', 'tablet', 'camera', 'keyboard', 'mouse', 'monitor', 'headphone'],
            'Home' => ['home', 'furniture', 'kitchen', 'decor', 'lighting', 'garden', 'appliance'],
            'Accessories' => ['accessory', 'bag', 'watch', 'jewelry', 'sunglasses', 'hat', 'belt'],
            'Lifestyle' => ['lifestyle', 'book', 'music', 'movie', 'game', 'sport', 'outdoor'],
            'Fashion' => ['fashion', 'clothing', 'shirt', 'pants', 'dress', 'shoe', 'jacket'],
        ];
    }

    private function reassignProduct(Product $product, array $categoryKeywords, Category $uncategorizedCategory)
    {
        $productName = strtolower($product->name);
        $productDescription = strtolower($product->description);

        $assignedCategory = null;

        foreach ($categoryKeywords as $categoryName => $keywords) {
            foreach ($keywords as $keyword) {
                if (str_contains($productName, $keyword) || str_contains($productDescription, $keyword)) {
                    $assignedCategory = Category::query()->firstOrCreate(
                        ['name' => $categoryName],
                        ['slug' => Str::slug($categoryName)]
                    );
                    break 2;
                }
            }
        }

        if ($assignedCategory) {
            $product->category_id = $assignedCategory->id;
            $product->save();
            $this->line("Reassigned \"{$product->name}\" to \"{$assignedCategory->name}\"");
            Log::info("Reassigned \"{$product->name}\" to \"{$assignedCategory->name}\"");
        } else {
            $this->warn("Could not determine a category for \"{$product->name}\". It remains in \"Uncategorized\".");
            Log::warning("Could not determine a category for \"{$product->name}\". It remains in \"Uncategorized\".");
        }
    }
}
