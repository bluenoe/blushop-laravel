<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255|unique:categories,name',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        Category::create($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Category created.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|max:255|unique:categories,name,' . $category->id,
        ]);

        if ($request->name !== $category->name) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $category->update($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated.');
    }

    /**
     * Delete a category with safety checks.
     * Option A: Prevent deletion if category has products.
     */
    public function destroy(Category $category)
    {
        try {
            $categoryName = $category->name;

            // SAFETY CHECK 1: Category has products?
            if ($category->products()->exists()) {
                $productCount = $category->products()->count();
                return redirect()->route('admin.categories.index')
                    ->with('error', "Cannot delete \"{$categoryName}\" because it contains {$productCount} product(s). Please move or delete the products first.");
            }

            // SAFETY CHECK 2: Category has child categories?
            if ($category->children()->exists()) {
                $childCount = $category->children()->count();
                return redirect()->route('admin.categories.index')
                    ->with('error', "Cannot delete \"{$categoryName}\" because it has {$childCount} sub-category(ies). Please delete or reassign them first.");
            }

            // Delete the category
            $category->delete();

            // Log for audit
            Log::info('Category deleted', ['id' => $category->id, 'name' => $categoryName]);

            return redirect()->route('admin.categories.index')
                ->with('success', "Category \"{$categoryName}\" has been deleted successfully.");

        } catch (\Illuminate\Database\QueryException $e) {
            Log::error('Category deletion failed (DB)', ['error' => $e->getMessage()]);
            return redirect()->route('admin.categories.index')
                ->with('error', 'Failed to delete category due to a database error.');

        } catch (\Exception $e) {
            Log::error('Category deletion failed (General)', ['error' => $e->getMessage()]);
            return redirect()->route('admin.categories.index')
                ->with('error', 'An unexpected error occurred while deleting the category.');
        }
    }
}
