<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Validation\Rule;
class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $sortField = $request->query('sort', 'id');
        $sortOrder = $request->query('sortOrder', 'desc');
        $users = $this->userService->getAllUsers($sortField,$sortOrder);

        return view('users.index', compact('users','sortField', 'sortOrder'));
    }

    public function show($id)
    {
        $user = $this->userService->getUserById($id);
        return view('users.show', compact('user'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
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
        return redirect()->route('users.index');
    }

    public function edit($id)
    {
        $user = $this->userService->getUserById($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
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
        return redirect()->route('users.index');
    }

    public function destroy($id)
    {
        $this->userService->deleteUser($id);
        return redirect()->route('users.index');
    }
}
