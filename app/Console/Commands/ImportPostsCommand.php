<?php

namespace App\Console\Commands;

use App\Jobs\ImportPostsJob;
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
        $job = new ImportPostsJob($userId);
        $job->handle();
        foreach ($job->getSkippedTitles() as $title) {
            $this->warn("'$title' was skipped");
        }
        $count = $job->getNumberOfImportedRecords();
        $this->info("$count record(s) were imported");
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
