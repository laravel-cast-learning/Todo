<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoRequest;
use App\Http\Resources\TodoResource;
use App\Models\Status;
use App\Models\Todo;
use Illuminate\Http\Client\Request;
use Illuminate\Http\JsonResponse;

class TodoController extends Controller
{
    public function index(): JsonResponse
    {
        $page = request()->query('page',1);
        $perPage = request()->query('per_page',10);
        $todos = Todo::with(['user','status'])
            ->where('user_id',auth()->id())
            ->paginate(perPage: $perPage,page: $page);
        return response()->json([
            'status'=>true,
            'message'=>'success',
            'data' => TodoResource::collection($todos),
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
        $validated['user_id'] = auth()->id();
        return response()->json([
            'success' => true,
            'message' => 'Successfully Created!',
            'errors' => null,
            'data' => Todo::create($validated)
        ]);
    }

    public function update(Request $request,int $id): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string'
        ]);

        $todo = $this->getTodo($id);

        if (!$todo) {
            return response()->json([
                'success' => false,
                'message' => 'Todo not found or not authorized',
                'error' => 'Not found or unauthorized',
                'data' => null
            ], 404);
        }

        $todo->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Todo updated successfully',
            'data' => [
                'todo' => $todo->fresh()
            ]
        ]);
    }

    public function markAsCompleted(int $id): JsonResponse
    {

        $todo = $this->getTodo($id);
        if ($todo) {
            $todo->status_id = Status::where('name', 'completed')->firstOrFail()->id;
            $todo->save();
            return response()->json([
                'success' => true,
                'message' => 'Mark as completed!',
                'error' => null,
                'data' => $todo->fresh()
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
        $todo = $this->getTodo($id);
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

    public function getTodo(int $id){
        return Todo::where('id',$id)
            ->where('user_id',auth()->id())
            ->firstOrFail();
    }

}
