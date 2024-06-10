<?php
namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function store(Request $request)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string',
            'due_date' => 'nullable|date',
        ]);

        // Vérification de la validation
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Création de la tâche
        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'due_date' => $request->due_date,
            'user_id' => auth()->user()->id, // Utilisateur actuellement authentifié
        ]);

        // Réponse avec la tâche créée
        return response()->json([
            'message' => 'Task created successfully',
            'task' => $task
        ], 201);
    }


    public function index()
    {
        $tasks = auth()->user()->role_id != 1 ? Task::withTrashed()->get() : Task::where('user_id', auth()->id())->orWhereNull('deleted_at')->get();
        return response()->json($tasks);
    }

    public function show($id)
    {
        $task = Task::withTrashed()->findOrFail($id);
        if (auth()->user()->role_id != 1 && $task->user_id != auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        return response()->json($task);
    }

    public function update(Request $request, $id)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string',
            'status' => 'sometimes|required|string',
            'due_date' => 'sometimes|nullable|date',
        ]);
    
        // Vérification de la validation
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
    
        // Récupération de la tâche
        $task = Task::withTrashed()->findOrFail($id);
    
        // Vérification de l'autorisation
        if (auth()->user()->role_id != 1 && $task->user_id != auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
    
        // Mise à jour de la tâche
        $task->update($request->all());
    
        // Réponse avec la tâche mise à jour
        return response()->json([
            'message' => 'Task updated successfully',
            'task' => $task
        ]);
    }
    

    public function destroy($id)
    {
        // Trouver la tâche, y compris les tâches supprimées
        $task = Task::withTrashed()->find($id);

        // Vérifier si la tâche existe
        if (!$task) {
            return response()->json(['message' => 'The task ID does not exist'], 404);
        }

        // Vérifier si l'utilisateur est autorisé à supprimer la tâche (administrateur ou propriétaire de la tâche)
        if (auth()->user()->role_id != 1 && $task->user_id != auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Vérifier si la tâche a déjà été supprimée
        if ($task->trashed()) {
            return response()->json(['message' => 'Cannot delete this task. It has already been deleted.'], 400);
        }

        // Supprimer la tâche (soft delete)
        $task->delete();

        return response()->json(['message' => 'Task deleted successfully'], 201);
    }

    public function deleted()
    {
        // Vérifiez si l'utilisateur est un administrateur
        if (auth()->user()->role_id != 1) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Récupérer toutes les tâches supprimées
        $tasks = Task::onlyTrashed()->get();

        // Si aucune tâche supprimée n'est trouvée, retournez un message approprié
        if ($tasks->isEmpty()) {
            return response()->json(['message' => 'The trash is empty'], 200);
        }

        // Retournez les tâches supprimées
        return response()->json(['message' => 'The trash is empty'],$tasks, 200);
    }

}
