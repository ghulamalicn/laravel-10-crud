<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\UserService;
class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $sortField = $request->query('sort', 'name');
        $users = $this->userService->getAllUsers($sortField);

        return view('users.index', compact('users'));
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
