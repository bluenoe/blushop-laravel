<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

/**
 * Searchable Trait — Reusable search scope for Eloquent models.
 *
 * Usage:
 *   1. Add `use Searchable;` to your model
 *   2. Define `protected $searchable = ['column1', 'column2', ...]`
 *   3. Use `Model::search($term)->get()` in your controller
 */
trait Searchable
{
    /**
     * Scope a query to search across the model's searchable columns.
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

        $searchTerm = '%' . trim($term) . '%';
        $columns = $this->getSearchableColumns();

        return $query->where(function (Builder $q) use ($searchTerm, $columns) {
            foreach ($columns as $i => $column) {
                if ($i === 0) {
                    $q->where($column, 'like', $searchTerm);
                } else {
                    $q->orWhere($column, 'like', $searchTerm);
                }
            }
        });
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
