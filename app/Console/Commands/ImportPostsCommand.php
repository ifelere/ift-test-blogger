<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Contracts\Console\Isolatable;

use App\Models\User;

use Exception;

use Illuminate\Support\Str;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Http;

use Illuminate\Support\Carbon;

use App\Models\Blog;

use Illuminate\Support\Facades\DB;

class ImportPostsCommand extends Command implements Isolatable
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'posts:import 
                            {user? : The ID of the system user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import posts from configured api';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $this->handleImportWithUser($this->getSessionUser());
        } catch (\Throwable $th) {
            $this->error('An error occurred while processing imports');
            Log::error($th);
            return Command::FAILURE;
        }
        return Command::SUCCESS;
    }

    private function handleImportWithUser($userId) {
        $this->info('Importing posts...');
        $response = Http::get(config('posts.import.url'));
        if (!$response->ok()) {
            throw new Exception('Fetching from exteral post API failed');
        }

        $array_result = $response->json();

        $count = [0];

        // Wrap every thing in a transaction

        DB::transaction(function () use ($count, $userId, $array_result) {

            $posts = $array_result['articles'];

            /**
             * No need for model events that does another db query to ensure slug i unique.
             * This is being taken care of here to avoid performance penalty
             */
            Blog::withoutEvents(function () use ($posts, $count, $userId) {
                foreach ($posts as $post) {
                    $slug = Str::slug($post['title']);

                    $exist = Blog::where('slug', 'like', $slug)->selectRaw('1')->first();
                    // Don't add if the blug exists before
                    if (!is_null($exist)) {
                        $this->warn("'{$post['title']}' will not be added because it already exists");
                        continue;
                    }

                    Blog::create([
                        'title' => $post['title'],
                        'slug' => $slug,
                        'description' => $post['description'],
                        'published_at' => Carbon::parse($post['publishedAt']),
                        'publisher_id' => $userId
                    ]);

                    $count[0] = $count[0] + 1;
                }

            });
        });

        $this->info("{$count[0]} post(s) were imported");
    }

    /**
     * Try to use three strategies to resolve user
     * 
     * If a user argument is not passed to this command use the last created model if it exists
     * If no system user as found generate a new one
     * But if a user is passeord to the script ensure that it is a system user
     */
    private function getSessionUser() {
        $arg = $this->argument('user');
        if (is_null($arg)) {
            $last_system_user = User::where('is_system', true)
                    ->orderBy('created_at', 'desc')
                    ->select('id')
                    ->first();

            if (is_null($last_system_user)) {
                return static::generateSystemUser();
            }
            return $last_system_user->id;      
        }
        if (static::isSystemUser($arg)) {
            return $arg;
        }
        throw new Exception('Only a system user session is allowed for post imports');
    }

    private static function isSystemUser($id): bool {
        $g = User::where([
            'is_system' => true,
            'id' => $id
        ])->selectRaw('1')->first();
        return !is_null($g);
    }

    private static function generateSystemUser() {
        $user = new User([
            'name' => 'System',
            'email' => Str::random(12) . 'iftblogger.app',
            'password' => Hash::make(Str::random(8))
        ]);
        $user->is_system = true;

        $user->saveOrFail();

        return $user->id;
    }
}
