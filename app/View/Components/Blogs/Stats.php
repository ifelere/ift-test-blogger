<?php

namespace App\View\Components\Blogs;

use App\Repositories\BlogRepository;
use Illuminate\View\Component;

class Stats extends Component
{
    private $repository;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(BlogRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.blogs.stats', [
            'stat' => $this->repository->getStats()
        ]);
    }
}
