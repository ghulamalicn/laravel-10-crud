<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Validation\Rule;
use App\Models\Role;
use Illuminate\Support\Facades\Validator;
class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Show users record on the base of sorting and pagination.
    */
    public function index(Request $request)
    {
        $sortField = $request->query('sort', 'id');
        $sortOrder = $request->query('sortOrder', 'desc');
        $search = $request->query('search');
        /**
         * (?![^<>?/]*\s{2}) ensures there are no double spaces.
         *   [^<>?/]* allows any characters except <, >, ?, and /.
         *   (?<!--)$$ ensures there are no consecutive hyphens.
         *   (?<!__)$$ ensures there are no consecutive underscores.
         *   (?<!\*)$$ ensures there is no asterisk.
         *   (?<!<|>)$$ ensures there is no < or >.
         *   (?i)(?!script|select|delete|insert|update) disallows the specified keywords (case-insensitive).
         */
        $request->validate([
            'search' => [
                'nullable',
                'regex:#^(?![^<>?/]*\s{2})[^<>?/]*(?<!--)$$[^<>?/]*(?<!__)$$[^<>?/]*(?<!\*)$$[^<>?/]*(?!<|>)$$(?i)(?!script|select|delete|insert|update)#',
            ],
        ]);

        $users = $this->userService->getAllUsers($sortField,$sortOrder,$search);

        return view('users.index', compact('users','sortField', 'sortOrder', 'search'));
    }

    /**
     * Details of a specific user.
    */
    public function show($id)
    {
        if($this->userExist($id)){
            $user = $this->userService->getUserById($id);
            return view('users.show', compact('user'));
        }else{
            return redirect()->route('users.index')->with('error', 'User not found.');
        }
    }

     /**
     * New user creation form.
    */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Create  a new user.
    */
    public function store(Request $request)
    {
        $request->validate([
            'user_name' => ['required', 'string', 'min:3', 'regex:/^[a-zA-Z0-9]+([ -@_][a-zA-Z0-9]+)*$/', Rule::unique('users')],
            'first_name' => ['required', 'string', 'min:3', 'regex:/^[a-zA-Z]+([ -][a-zA-Z]+)*$/'],
            'last_name' => ['required', 'string', 'min:3', 'regex:/^[a-zA-Z]+([ -][a-zA-Z]+)*$/'],
            'email' => ['required', 'email', Rule::unique('users')],
            'phone' => ['required', 'string', 'regex:/^(?:(?:\+\d{1,3}|\(\d{1,4}\)|\d{1,4})[\s-]?)?(\(\d{3}\)\s?\d{8}|\d{10})$/'],
            'dob' => ['required', 'date', 'regex:/^(\d{4})(-(0[1-9]|1[0-2])(-(0[1-9]|[12][0-9]|3[01]))?)?$/','before_or_equal:' . now()->subYears(18)->format('Y-m-d')],
            'password' => ['required', 'string', 'min:4'],
        ]);
        $userData = $request->all();
        $this->userService->createUser($userData);
        return redirect()->route('users.index')->with('success', 'User Created Successfully!.');
    }

    /**
     * Edit a user.
    */
    public function edit($id)
    {
        // Validate that the user ID exists
        if($this->userExist($id)){
            $user = $this->userService->getUserById($id);

            $roles = $this->userService->getAllRoles();
            return view('users.edit', compact('user','roles'));
        }else{
            return redirect()->route('users.index')->with('error', 'User not found.');
        }
    }


    /**
     * Update a specific user.
    */
    public function update(Request $request, $id)
    {
        if ($this->userExist($id)) {
            // Define the validation rules with conditional password validation
            $validationRules = [
                'user_name' => ['required', 'string', 'min:3', 'regex:/^[a-zA-Z0-9]+([ -@_][a-zA-Z0-9]+)*$/', Rule::unique('users')->ignore($id)],
                'first_name' => ['required', 'string', 'min:3', 'regex:/^[a-zA-Z]+([ -][a-zA-Z]+)*$/'],
                'last_name' => ['required', 'string', 'min:3', 'regex:/^[a-zA-Z]+([ -][a-zA-Z]+)*$/'],
                'email' => ['required', 'email', Rule::unique('users')->ignore($id)],
                'phone' => ['required', 'string', 'regex:/^(?:(?:\+\d{1,3}|\(\d{1,4}\)|\d{1,4})[\s-]?)?(\(\d{3}\)\s?\d{8}|\d{10})$/'],
                'dob' => ['required', 'date', 'regex:/^(\d{4})(-(0[1-9]|1[0-2])(-(0[1-9]|[12][0-9]|3[01]))?)?$/','before_or_equal:' . now()->subYears(18)->format('Y-m-d')],
                'role' => ['required', 'integer'],
            ];

            // Check if new_password is present and add password validation rules
            if ($request->filled('new_password') || $request->filled('confirm_password')) {
                $validationRules['new_password'] = ['required', 'string', 'min:4'];
                $validationRules['confirm_password'] = ['required', 'string', 'min:4', 'same:new_password'];
            }

            // Validate the request data
            $request->validate($validationRules);

            // Prepare the user data for update
            $userData = $request->only(['user_name', 'first_name', 'last_name', 'email', 'phone', 'dob']);

            // Update the password only if new_password is present
            if ($request->filled('new_password')) {
                $userData['password'] = bcrypt($request->input('new_password'));
            }

            // Update the user
            $this->userService->updateUser($id, $userData);

            // Update or create the user role
            $user = $this->userService->getUserById($id);
            $user->roles()->sync([$request->input('role')]);
            return redirect()->route('users.index')->with('success', 'User updated Successfully!');
        } else {
            return redirect()->route('users.index')->with('error', 'User not found.');
        }
    }



    /**
     * Delete user.
     * by a id
    */
    public function destroy($id)
    {
        if($this->userExist($id)){
            $this->userService->deleteUser($id);
            return redirect()->route('users.index')->with('success', 'User Deleted Successfully!.');
        }else{
            return redirect()->route('users.index')->with('error', 'User not found.');
        }
    }

    /**
     * User Profile Update.
    */
    public function profileUpdate(Request $request, $id)
    {
        if ($this->userExist($id)) {
            $validationRules = [
                'user_name' => ['required', 'string', 'min:3', 'regex:/^[a-zA-Z0-9]+([ -@_][a-zA-Z0-9]+)*$/', Rule::unique('users')->ignore($id)],
                'first_name' => ['required', 'string', 'min:3', 'regex:/^[a-zA-Z]+([ -][a-zA-Z]+)*$/'],
                'last_name' => ['required', 'string', 'min:3', 'regex:/^[a-zA-Z]+([ -][a-zA-Z]+)*$/'],
                'email' => ['required', 'email', Rule::unique('users')->ignore($id)],
                'phone' => ['required', 'string', 'regex:/^(?:(?:\+\d{1,3}|\(\d{1,4}\)|\d{1,4})[\s-]?)?(\(\d{3}\)\s?\d{8}|\d{10})$/'],
                'dob' => ['required', 'date', 'regex:/^(\d{4})(-(0[1-9]|1[0-2])(-(0[1-9]|[12][0-9]|3[01]))?)?$/','before_or_equal:' . now()->subYears(18)->format('Y-m-d')],

            ];

            // Check if new_password is present and add password validation rules
            if ($request->filled('new_password') || $request->filled('confirm_password')) {
                $validationRules['new_password'] = ['required', 'string', 'min:4'];
                $validationRules['confirm_password'] = ['required', 'string', 'min:4', 'same:new_password'];
            }

            // Validate the request data
            $request->validate($validationRules);

            // Prepare the user data for update
            $userData = $request->only(['user_name', 'first_name', 'last_name', 'email', 'phone', 'dob']);

            // Update the password only if new_password is present
            if ($request->filled('new_password')) {
                $userData['password'] = bcrypt($request->input('new_password'));
            }

            // Update the user
            $this->userService->updateUser($id, $userData);

            return redirect()->route('profile')->with('success', 'Profile updated Successfully!');
        } else {
            return redirect()->route('profile')->with('error', 'User is not authenticated/login user.');
        }
    }


    /**
     * specific user exist or not.
     * by a id
    */
    function userExist($id){
        $validator = Validator::make(['id' => $id], [
            'id' => ['required', 'integer', Rule::exists('users', 'id')],
        ]);

        if ($validator->fails()) {
            return false;
        }else{
            return true;
        }
    }

    private function presentUser(User $user)
    {
        return $user->presenter();
    }
}
