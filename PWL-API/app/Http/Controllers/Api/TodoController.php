<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TodoRequest;
use App\Models\Todo;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $todos = $request->user()->todos;
        return $this->apiSuccess($todos);
    }

    public function store(TodoRequest $request)
    {
        $todo = $request->user()->todos()->create($request->validated());
        return $this->apiSuccess($todo, 'Todo created successfully', 201);
    }

    public function show(Todo $todo, Request $request)
    {
        if ($request->user()->id !== $todo->user_id) {
            return $this->apiError(null, 'Unauthorized', 403);
        }

        return $this->apiSuccess($todo);
    }

    public function update(TodoRequest $request, Todo $todo)
    {
        if ($request->user()->id !== $todo->user_id) {
            return $this->apiError(null, 'Unauthorized', 403);
        }

        $todo->fill($request->validated())->save();
        return $this->apiSuccess($todo, 'Todo updated successfully');
    }

    public function destroy(Todo $todo, Request $request)
    {
        if ($request->user()->id !== $todo->user_id) {
            return $this->apiError(null, 'Unauthorized', 403);
        }

        Todo::destroy($todo->id);
        return $this->apiSuccess(null, 'Todo deleted successfully');
    }
}
