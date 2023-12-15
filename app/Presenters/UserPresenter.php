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
            // Check if dob is set and not null
            if (isset($this->user->dob)) {
                // Check if dob is a string and convert it to a Carbon instance
                if (is_string($this->user->dob)) {
                    $dob = new Carbon($this->user->dob);
                    // Add any other date formatting logic you need
                    return $dob->format('Y-m-d');
                }
            }

            // Return an empty string or handle the case as needed
            return '';
        }

        // Convert the specified column to title case
        public function formattedNameStr($column)
        {
            // Ensure the specified column exists in the user model and is not null
            if (isset($this->user->{$column}) && !is_null($this->user->{$column})) {
                // Convert the column value to title case
                return Str::title($this->user->{$column});
            }

            // Return an empty string or handle the case as needed
            return '';
        }


        // Add any other formatting methods as needed
    }
