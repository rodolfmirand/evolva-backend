<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Services\TaskService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\QueryException;

class TaskController extends Controller
{
    public function __construct(private TaskService $taskService) {}

    public function store(TaskRequest $request)
    {
        $user = Auth::user();

        try {
            $task = $this->taskService->createTask($request->validated(), $user);

            return response()->json([
                'message' => 'Tarefa criada com sucesso!',
                'data' => $task
            ], 201);

        } catch (AuthorizationException $e) {
            return response()->json(['error' => $e->getMessage()], 403);

        } catch (QueryException $e) {
            return response()->json(['error' => 'Erro ao criar a tarefa no banco.'], 500);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro inesperado: ' . $e->getMessage()], 500);
        }
    }
}
