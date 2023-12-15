<?php
    namespace App\Presenters;
    // Carbon is a popular date and time manipulation library for PHP.
    use Carbon\Carbon;
    use App\Models\User;
    //  use Illuminate\Support : namespace contains various utility classes and functions that are used throughout the framework
    use Illuminate\Support\Str;
    class UserPresenter
    {
        protected $user;

        public function __construct(User $user)
        {
            $this->user = $user;
        }

        public function formattedDob()
        {
            // Add any date formatting logic you need
            // Check if dob is a string and convert it to a Carbon instance
            if (is_string($this->user->dob)) {
                $dob = new Carbon($this->user->dob);
            } else {
                $dob = $this->user->dob;
            }

            // Add any other date formatting logic you need
            return $dob->format('Y-m-d');
        }

        // Convert the first_name to title case
        public function formattedNameStr($column)
        {
            // Convert the first_name to title case
            // Ensure the specified column exists in the user model
            if (isset($this->user->{$column})) {
                // Convert the column value to title case
                return Str::title($this->user->{$column});
            }

            // Return the original value if the column is not found
            return $this->user->{$column};
        }


        // Add any other formatting methods as needed
    }
