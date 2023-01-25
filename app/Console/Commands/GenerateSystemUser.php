<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Str;

use Illuminate\Support\Facades\Hash;

use App\Models\User;

class GenerateSystemUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'su:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a system user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $data = [
            'email' => $this->askForEmail(),
            'password' => $this->askForPassword(3)
        ];
        if (is_null($data['password'])) {
            return Command::FAILURE;
        }

        $user = new User([
            'name' => 'System',
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);


        $user->is_system = true;

        $user->safeOrFail();

        return Command::SUCCESS;
    }


    private function askForEmail() {
        $default_email = Str::random(8) . 'iftblogger.app';
        return $this->ask('Email?', $default_email);
    }

    private function askForPassword($trial_left) {
        if ($trial_left < 0) {
            return null;
        }
        $pwd = $this->secret('Password:');
        if (empty($pwd)) {
            $this->error('Password is required');
            return $this->askForPassword($trial_left - 1);
        }
        return $pwd;
    }
}
