<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Role;
use Illuminate\Validation\Rule;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:user {username} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user and assign role_id = 1';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $username = $this->argument('username');
        $passwordString = $this->argument('password');
        $password = bcrypt($this->argument('password'));

        // Validate input
        $this->validateInput($username,$password);

        try {
            // Create user
            $user = User::create([
                'user_name' => $username,
                'email' => $username . '@example.com', // Adjust the email as needed
                'password' => $password,
            ]);

            // Attach role_id = 1 to the user in the role_user table
            $role = Role::findOrFail(1); // Assuming role_id = 1 exists in the roles table
            $user->roles()->attach($role->id);

            $this->info("User {$username} created successfully!.");
            $this->info("Now you can login using, User Name : {$username} and password : {$passwordString}");
        } catch (\Exception $e) {
            // Handle exceptions (e.g., unique constraint violation) gracefully
            $this->error("Failed to create user: " . $e->getMessage());
        }
    }

    /**
     * Validate the input.
     *
     * @param string $username
     * @return void
     */
    protected function validateInput($username,$password)
    {
        $validator = validator([
            'user_name' => $username,
            'password' => $password,
        ], [
            'user_name' => [
                'required',
                'string',
                'min:3',
                'regex:/^[a-zA-Z0-9]+([ -@_][a-zA-Z0-9]+)*$/',
                Rule::unique('users'),
            ],
            'password' => [
                'required',
                'string',
                'min:4',  // Adjust the minimum length as needed
                // Add more password validation rules as needed
            ],
        ]);

        if ($validator->fails()) {
            $this->error("Validation failed: " . implode(' ', $validator->errors()->all()));
            exit(1);
        }
    }
}
