<?php

namespace App\View\Components\Blogs;

use App\Repositories\BlogRepository;
use Illuminate\View\Component;

use Illuminate\Support\Facades\Auth;

class CentralList extends Component
{
   
    public $searchRoute;
    public $blogRoute;
    public $blogs;
    private $repository;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(BlogRepository $repository, $blogRoute, $searchRoute)
    {
        $this->repository = $repository;
        $this->blogRoute = $blogRoute;
        $this->searchRoute = $searchRoute;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $authenticated = Auth::check();
        $limit = config('view.blogs.central_list_limit', 5);
        $this->blogs = $this->repository->findAll(!$authenticated)->take($limit)->get();
        return view('components.blogs.central-list');
    }
}
