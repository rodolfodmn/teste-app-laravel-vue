<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     title="Minha API de Tarefas",
 *     version="1.0",
 *     description="Documentação da API para gerenciamento de tarefas",
 *     @OA\Contact(
 *         email="seuemail@exemplo.com"
 *     )
 * )
 *
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="Servidor local"
 * )
 */

class TaskController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/tasks",
     *     tags={"Tasks"},
     *     summary="Listar tarefas",
     *     description="Retorna todas as tarefas, com filtro opcional por status.",
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="Filtrar por status (pending, done)",
     *         required=false,
     *         @OA\Schema(type="string", enum={"pending", "done"})
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de tarefas retornada com sucesso"
     *     )
     * )
     */
    public function index(Request $request)
    {
        $query = Task::query();

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        return response()->json($query->get(), 200);
    }

    /**
     * @OA\Post(
     *     path="/api/tasks",
     *     tags={"Tasks"},
     *     summary="Criar nova tarefa",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "status"},
     *             @OA\Property(property="title", type="string", maxLength=255),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="status", type="string", enum={"pending", "done"})
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Tarefa criada com sucesso"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Dados inválidos"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,done',
        ]);

        $task = Task::create($validated);

        return response()->json($task, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/tasks/{id}",
     *     tags={"Tasks"},
     *     summary="Visualizar uma tarefa",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tarefa encontrada"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tarefa não encontrada"
     *     )
     * )
     */
    public function show($id)
    {
        $task = Task::findOrFail($id);
        return response()->json($task, 200);
    }

    /**
     * @OA\Put(
     *     path="/api/tasks/{id}",
     *     tags={"Tasks"},
     *     summary="Atualizar uma tarefa",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string", maxLength=255),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="status", type="string", enum={"pending", "done"})
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tarefa atualizada com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tarefa não encontrada"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'sometimes|required|in:pending,done',
        ]);

        $task->update($validated);

        return response()->json($task, 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/tasks/{id}",
     *     tags={"Tasks"},
     *     summary="Deletar uma tarefa",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Tarefa deletada com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tarefa não encontrada"
     *     )
     * )
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return response()->json(null, 204);
    }
}
