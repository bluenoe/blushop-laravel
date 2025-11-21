<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(Request $request): View
    {
        $search = (string) $request->query('q', '');
        $categories = Category::query()
            ->when($search !== '', function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('slug', 'like', "%$search%");
            })
            ->withCount('products')
            ->latest('id')
            ->paginate(10)
            ->withQueryString();
        $allCategories = Category::query()->select(['id', 'name', 'slug'])->orderBy('name')->get();

        return view('admin.categories.index', compact('categories', 'search', 'allCategories'));
    }

    public function create(): View
    {
        return view('admin.categories.create');
    }

    public function store(CategoryRequest $request): RedirectResponse
    {
        $data = $request->validated();
        Category::create([
            'name' => $data['name'],
            'slug' => $data['slug'],
            'description' => $data['description'] ?? null,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(Category $category): View
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(CategoryRequest $request, Category $category): RedirectResponse
    {
        $data = $request->validated();
        $category->update([
            'name' => $data['name'],
            'slug' => $data['slug'],
            'description' => $data['description'] ?? null,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $reassignTo = request()->input('reassign_to');
        $productCount = $category->products()->count();

        if ($productCount > 0) {
            if (! $reassignTo) {
                return redirect()->route('admin.categories.index')
                    ->with('warning', 'Category has products. Please reassign them before deleting.');
            }

            // Prevent self-reassign
            if ((int) $reassignTo === (int) $category->id) {
                return redirect()->route('admin.categories.index')
                    ->with('warning', 'Cannot reassign products to the same category.');
            }

            // Validate target category exists
            $target = Category::query()->find($reassignTo);
            if (! $target) {
                return redirect()->route('admin.categories.index')
                    ->with('warning', 'Target category not found.');
            }

            // Reassign products
            DB::table('products')->where('category_id', $category->id)->update(['category_id' => $target->id]);
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }
}
