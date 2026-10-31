<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

/** Create the first admin — no seeded default users. */
class CreateAdminCommand extends Command
{
    protected $signature = 'khati:create-admin {email} {password} {--name=Admin}';
    protected $description = 'Create an admin user (use once for fresh install)';

    public function handle(): int
    {
        if (User::where('email', $this->argument('email'))->exists()) {
            $this->error('Email already exists.');
            return 1;
        }
        User::create([
            'name' => $this->option('name'),
            'email' => $this->argument('email'),
            'password' => Hash::make($this->argument('password')),
            'role' => User::ROLE_ADMIN,
            'is_active' => true,
        ]);
        $this->info('Admin created. You can log in with that email/password.');
        return 0;
    }
}
