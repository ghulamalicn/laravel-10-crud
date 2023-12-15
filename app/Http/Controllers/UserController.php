<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Validation\Rule;
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
        $users = $this->userService->getAllUsers($sortField,$sortOrder);

        return view('users.index', compact('users','sortField', 'sortOrder'));
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
    public function store(Request $reques )
    {
        $request->validate([
            'user_name' => ['required', 'string', 'min:3', 'regex:/^[a-zA-Z0-9]+([ -@_][a-zA-Z0-9]+)*$/', Rule::unique('users')],
            'first_name' => ['required', 'string', 'min:3', 'regex:/^[a-zA-Z]+([ -][a-zA-Z]+)*$/'],
            'last_name' => ['required', 'string', 'min:3', 'regex:/^[a-zA-Z]+([ -][a-zA-Z]+)*$/'],
            'email' => ['required', 'email', Rule::unique('users')],
            'phone' => ['required', 'string', 'regex:/^(?:(?:\+\d{1,3}|\(\d{1,4}\)|\d{1,4})[\s-]?)?(\(\d{3}\)\s?\d{8}|\d{10})$/'],
            'dob' => ['required','regex:/^(\d{4})(-(0[1-9]|1[0-2])(-(0[1-9]|[12][0-9]|3[01]))?)?$/','before_or_equal:' . now()->subYears(18)->format('Y-m-d')],
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
            return view('users.edit', compact('user'));
        }else{
            return redirect()->route('users.index')->with('error', 'User not found.');
        }
    }


    /**
     * Update a specific user.
    */
    public function update(Request $request, $id)
    {
        if($this->userExist($id)){
            $request->validate([
                'user_name' => ['required', 'string', 'min:3', 'regex:/^[a-zA-Z0-9]+([ -@_][a-zA-Z0-9]+)*$/', Rule::unique('users')->ignore($id)],
                'first_name' => ['required', 'string', 'min:3', 'regex:/^[a-zA-Z]+([ -][a-zA-Z]+)*$/'],
                'last_name' => ['required', 'string', 'min:3', 'regex:/^[a-zA-Z]+([ -][a-zA-Z]+)*$/'],
                'email' => ['required', 'email', Rule::unique('users')->ignore($id)],
                'phone' => ['required', 'string', 'regex:/^(?:(?:\+\d{1,3}|\(\d{1,4}\)|\d{1,4})[\s-]?)?(\(\d{3}\)\s?\d{8}|\d{10})$/'],
                'dob' => ['required', 'date', 'regex:/^(\d{4})(-(0[1-9]|1[0-2])(-(0[1-9]|[12][0-9]|3[01]))?)?$/','before_or_equal:' . now()->subYears(18)->format('Y-m-d')],
            ]);
            $userData = $request->all();
            $this->userService->updateUser($id, $userData);
            return redirect()->route('users.index')->with('success', 'User updated Successfully!.');
        }else{
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
        if($this->userExist($id)){
            $request->validate([
                'user_name' => ['required', 'string', 'min:3', 'regex:/^[a-zA-Z0-9]+([ -@_][a-zA-Z0-9]+)*$/', Rule::unique('users')->ignore($id)],
                'first_name' => ['required', 'string', 'min:3', 'regex:/^[a-zA-Z]+([ -][a-zA-Z]+)*$/'],
                'last_name' => ['required', 'string', 'min:3', 'regex:/^[a-zA-Z]+([ -][a-zA-Z]+)*$/'],
                'email' => ['required', 'email', Rule::unique('users')->ignore($id)],
                'phone' => ['required', 'string', 'regex:/^(?:(?:\+\d{1,3}|\(\d{1,4}\)|\d{1,4})[\s-]?)?(\(\d{3}\)\s?\d{8}|\d{10})$/'],
                'dob' => ['required', 'date', 'regex:/^(\d{4})(-(0[1-9]|1[0-2])(-(0[1-9]|[12][0-9]|3[01]))?)?$/','before_or_equal:' . now()->subYears(18)->format('Y-m-d')],
            ]);
            $userData = $request->all();
            $this->userService->updateUser($id, $userData);
            return redirect()->route('profile')->with('success', 'User updated Successfully!.');
        }else{
            return redirect()->route('profile')->with('error', 'User are not authenticated/login user.');
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
}
