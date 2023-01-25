<?php

namespace App\Http\Controllers;

use App\Jobs\ImportPostsJob;
use Illuminate\Http\Request;

class SystemController extends Controller
{
    public function importPosts(Request $request) {
        ImportPostsJob::dispatch($request->user()->id);
        return redirect()->back()->with(['flash_message' => 'Import job has been queued up', 'flash_type' => 'plain']);
    }
}
