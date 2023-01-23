<?php

namespace App\Repositories;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\Blog;

use Illuminate\Support\Arr;

/**
 * This is a repository class to have queries for blogs in one place.
 * 
 * It also ensures that blogs are automatically scoped to logged in user, sorted and filtered using current request
 * 
 */
class BlogRepository {
    private $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Search for blogs that will be scoped to current user if logged in and automatically apply request filter and sorting
     * @return QueryBuilder
     */
    public function findAll() {
        $query = Blog::with(['publisher']);
        if (Auth::check()) {
            $query = $query->publishedBy(Auth::id());
        }
        if (!empty($this->request->input('q'))) {
            $term = $this->request->input('q');
            $query = $query->where('title', 'like', "%$term%");
        }

        // Allow sorting with atttibutes that aliases of db columns

        $sort = $this->request->input('sort', 'created desc');

        $attribute_aliases = [
            'created' => 'created_at',
            'updated' => 'updated_at',
            'date' => 'created_at'
        ];

        $parts = explode(' ', $sort);


        $sort_column = Arr::get($attribute_aliases, $parts[0], $parts[0]);

        $sort_order = count($parts) > 1 ? $parts[1] : 'desc';

        return $query->orderBy($sort_column, $sort_order);
    }

    /**
     * Finds a blog by id and ensures that it is tied to user session if it exists
     * @return Blog
     */
    public function find($id): ?Blog {
        $query = Blog::with(['publisher']);
        if (Auth::check()) {
            $query = $query->publishedBy(Auth::id());
        }
        return $query->where('id', $id)->firstOrFail();
    }

}