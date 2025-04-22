<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoRequest;
use App\Models\Todo;
use Illuminate\Http\JsonResponse;

class TodoController extends Controller
{
    public function index(): JsonResponse
    {
        $page = request()->query('page',1);
        $perPage = request()->query('per_page',10);
        $todos = Todo::query()->paginate(perPage: $perPage,page: $page);
        return response()->json([
            'data' => $todos->items(),
            'meta' => [
                'current_page' => $todos->currentPage(),
                'prev' => $todos->previousPageUrl(),
                'next' => $todos->nextPageUrl(),
                'per_page' => $todos->perPage(),
                'total' => $todos->total(),
            ],
        ]);
    }

    public function store(TodoRequest $request): JsonResponse
    {
        $validated = $request->validated();
        return response()->json([
            'success' => true,
            'message' => 'Successfully Created!',
            'errors' => null,
            'data' => Todo::create($validated)
        ]);
    }

    public function update()
    {

    }

    public function markAsCompleted(int $id): JsonResponse
    {
        $todo = Todo::find($id);
        if ($todo) {
            $todo->completed = true;
            $todo->save();
            return response()->json([
                'success' => true,
                'message' => 'Mark as completed!',
                'error' => null,
                'data' => null
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Record not found!',
                'error' => 'Record not found!',
                'data' => null
            ]);
        }
    }

    public function delete(int $id): JsonResponse
    {
        $todo = Todo::find($id);
        if ($todo) {
            $todo->delete();
            return response()->json([
                'success' => true,
                'message' => 'Successfully Deleted!',
                'errors' => null,
                'data' => null
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Record not found!',
                'error' => 'Record not found!',
                'data' => null
            ]);
        }
    }

}
