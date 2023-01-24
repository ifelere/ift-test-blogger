<?php

namespace App\Repositories;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\Blog;
use Exception;
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
    public function findAll($withEagerLoads = false, $filter = TRUE) {
        $query =$withEagerLoads ? Blog::with(['publisher']) : (new Blog())->newQuery();

        if (Auth::check()) {
            $query = $query->publishedBy(Auth::id());
        }
        if ($filter) {
            if (!empty($this->request->input('q'))) {
                $term = $this->request->input('q');
                $query = $query->where('title', 'like', "%$term%");
            }
    
            foreach (['from_date' => '>=', 'to_date' => '<='] as $attr => $op) {
                if ($this->request->has($attr)) {
                    $query = $query->where('created_at', $op, $this->request->input($attr));
                }
            }
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
    public function find($id, $withEagerLoads = false): ?Blog {
        $query = $withEagerLoads ? Blog::with(['publisher']) : (new Blog())->newQuery();
        if (Auth::check()) {
            $query = $query->publishedBy(Auth::id());
        }
        return $query->where('id', $id)->firstOrFail();
    }

    /**
     * Looks for a glub given it's slug
     * */
    public function findBySlug($id): ?Blog {
        $query = Blog::with(['publisher']);
        if (Auth::check()) {
            $query = $query->publishedBy(Auth::id());
        }
        return $query->where('slug', 'like', $id)->firstOrFail();
    }

    /**
     * Gets a stat record of blogs for a user
     * Returns a record of object having number_of_blogs, latest_publish_date and earliest_publish_date attributes
     */
    public function getStats() {
        if (!Auth::check()) {
            throw new Exception('Cannot be called on guest users', 422);
        }
        return Blog::publishedBy(Auth::id())
         ->selectRaw(implode(',', [
            'count(*) as number_of_blogs',
            'max(published_at) as latest_publish_date',
            'min(published_at) as earliest_publish_date',
         ]))->get()->first();
    }

}