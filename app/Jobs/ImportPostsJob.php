<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Support\Str;

use Illuminate\Support\Facades\Http;

use Illuminate\Support\Carbon;

use App\Models\Blog;

use Illuminate\Support\Facades\DB;


use Exception;

use App\Models\User;


class ImportPostsJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $userId;

    private $count;

    private $skippedTtitles = [];

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (!static::isSystemUser($this->userId)) {
            throw new Exception('Attached user does not have system permission');
        }
        $response = Http::get(config('posts.import.url'));

        if (!$response->ok()) {
            throw new Exception('Fetching from exteral post API failed');
        }

        $array_result = $response->json();

        // Wrap every thing in a transaction

        DB::transaction(function () use ($array_result) {

            $posts = $array_result['articles'];

            /**
             * No need for model events that does another db query to ensure slug i unique.
             * This is being taken care of here to avoid performance penalty
             */
            Blog::withoutEvents(function () use ($posts) {
                foreach ($posts as $post) {
                    $slug = Str::slug($post['title']);

                    $exist = Blog::where('slug', 'like', $slug)->selectRaw('1')->first();
                    // Don't add if the blug exists before
                    if (!is_null($exist)) {
                        $this->skippedTtitles[] = $post['title'];
                        continue;
                    }

                    Blog::create([
                        'title' => $post['title'],
                        'slug' => $slug,
                        'description' => $post['description'],
                        'published_at' => Carbon::parse($post['publishedAt']),
                        'publisher_id' => $this->userId
                    ]);

                    $this->count += 1;
                }

            });
        });
    }

    private static function isSystemUser($id): bool {
        $g = User::where([
            'is_system' => true,
            'id' => $id
        ])->selectRaw('1')->first();
        return !is_null($g);
    }


    public function getNumberOfImportedRecords(): int {
        return $this->count;
    }

    public function getSkippedTitles(): array {
        return $this->skippedTtitles;
    }
}
