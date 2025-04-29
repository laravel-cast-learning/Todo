<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoRequest;
use App\Http\Resources\TodoResource;
use App\Models\Status;
use App\Models\Todo;
use App\Traits\ApiResponses;
use Illuminate\Http\Client\Request;
use Illuminate\Http\JsonResponse;

class TodoController extends Controller
{
    use ApiResponses;
    public function index(): JsonResponse
    {
        $page = request()->query('page',1);
        $perPage = request()->query('per_page',10);
        $todos = Todo::with(['user','status'])
            ->where('user_id',auth()->id())
            ->paginate(perPage: $perPage,page: $page);
        return $this->paginatedResponse(
            message: "Data Found!",
            data: TodoResource::collection($todos),
            meta: $todos
        );
    }

    public function store(TodoRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $validated['user_id'] = auth()->id();
        return $this->successResponse(
            message: "Todo Created!",
            code: 201,
            data: Todo::create($validated)
        );
    }

    public function update(Request $request,int $id): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string'
        ]);

        $todo = $this->getTodo($id);
        return $todo ? $this->successResponse(
            message: "Data Found!",
            data: $todo->update($validated)->fresh()
        ):$this->notFoundResponse();
    }

    public function markAsCompleted(int $id): JsonResponse
    {
        $todo = $this->getTodo($id);
        if ($todo) {
            $todo->status_id = Status::where('name', 'completed')->firstOrFail()->id;
            $todo->save();
            return $this->successResponse(
                message: 'Marked as completed!',
                data: $todo->fresh()
            );
        } else {
            return $this->notFoundResponse();
        }
    }

    public function delete(int $id): JsonResponse
    {
        if (!$todo = $this->getTodo($id)) {
            return $this->notFoundResponse();
        }
        $todo->delete();
        return $this->successResponse(message: "Successfully deleted!");
    }

    public function getTodo(int $id){
        return Todo::where('id',$id)
            ->where('user_id',auth()->id())
            ->firstOrFail();
    }

}
