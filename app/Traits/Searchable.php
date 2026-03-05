<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

/**
 * Searchable Trait — Reusable search scope with relevance sorting.
 *
 * Usage:
 *   1. Add `use Searchable;` to your model
 *   2. Define `protected $searchable = ['name', 'sku', 'description']`
 *   3. Use `Model::search($term)->get()` in your controller
 *
 * The first column in $searchable is used as the primary relevance column.
 * Results are sorted by: exact match → starts with → contains.
 */
trait Searchable
{
    /**
     * Scope a query to search across the model's searchable columns,
     * then order results by relevance.
     *
     * @param  Builder  $query
     * @param  string|null  $term
     * @return Builder
     */
    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (!$term || trim($term) === '') {
            return $query;
        }

        $term = trim($term);
        $searchTerm = '%' . $term . '%';
        $columns = $this->getSearchableColumns();

        if (empty($columns)) {
            return $query;
        }

        // --- 1. FILTER: match any searchable column ---
        $query->where(function (Builder $q) use ($searchTerm, $columns) {
            foreach ($columns as $i => $column) {
                if ($i === 0) {
                    $q->where($column, 'like', $searchTerm);
                } else {
                    $q->orWhere($column, 'like', $searchTerm);
                }
            }
        });

        // --- 2. SORT BY RELEVANCE ---
        // Use the first searchable column (e.g. 'name') as the primary relevance column.
        //
        // Priority weights (lower = more relevant):
        //   1 = Exact match    → column = 'men'
        //   2 = Starts with    → column LIKE 'men%'
        //   3 = Contains       → column LIKE '%men%' (everything else)
        //
        // This ensures "Men's Fashion" ranks above "Women's Fashion" when searching "men".
        //
        // Security: All values are passed as bound parameters (?) to prevent SQL injection.
        $primaryColumn = $columns[0];

        $query->orderByRaw(
            "CASE
                WHEN {$primaryColumn} = ? THEN 1
                WHEN {$primaryColumn} LIKE ? THEN 2
                ELSE 3
            END ASC",
            [
                $term,          // Binding for exact match
                $term . '%',    // Binding for starts-with
            ]
        );

        return $query;
    }

    /**
     * Get the columns that should be searchable.
     *
     * @return array<string>
     */
    protected function getSearchableColumns(): array
    {
        return property_exists($this, 'searchable') ? $this->searchable : [];
    }
}
