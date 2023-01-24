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
    private $exclude;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(BlogRepository $repository, $blogRoute, $exludeId = NULL)
    {
        $this->repository = $repository;
        $this->blogRoute = $blogRoute;
        $this->exclude = $exludeId;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        // Always use 'latest' sorting for this list and ignre use-supplied sort key

        $query = $this->repository->findAll(false, false);

        if (!is_null($this->exclude)) {
            $query = $query->where('id', '<>', $this->exclude);
        }

        $this->blogs = $query->reorder('created_at', 'desc')
            ->paginate(10);

        return view('components.blogs.sidebar-list');
    }
}
