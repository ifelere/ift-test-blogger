<?php

namespace App\View\Components\Blogs;

use App\Repositories\BlogRepository;
use Illuminate\View\Component;

use Illuminate\Support\Facades\Auth;

class CentralList extends Component
{
   
    public $searchUrl;
    public $blogRoute;
    public $blogs;
    private $repository;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(BlogRepository $repository, $blogRoute, $searchUrl)
    {
        $this->repository = $repository;
        $this->blogRoute = $blogRoute;
        $this->searchUrl = $searchUrl;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $authenticated = Auth::check();
        $limit = config('view.blogs.central_list_limit', 10);
        $this->blogs = $this->repository->findAll(!$authenticated)->take($limit)->get();
        return view('components.blogs.central-list');
    }
}
