<?php

namespace App\View\Components\Blogs;

use App\Repositories\BlogRepository;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;


/**
 * This component will render a list of blogs that is paginated and never filtered
 */
class SidebarList extends Component
{

    public $blogRoute;
    public $blogs;
    private $repository;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(BlogRepository $repository, $blogRoute)
    {
        $this->repository = $repository;
        $this->blogRoute = $blogRoute;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        // Always use 'latest' sorting for this list and ignre use-supplied sort key

        $this->blogs = $this->repository->findAll(false, false)
            ->reorder('created_at', 'desc')
            ->paginate(10);

        return view('components.blogs.sidebar-list');
    }
}
