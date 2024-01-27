<?php declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\Task;

final class DeleteTaskMutator
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        $key = array_keys($args)[0] ?? 'id';
        $col = $args['id'] ?? $args['status'];
        
        $res = match ($key) {
            'id' => $this->deleteTask($col),
            'status' => $this->deleteTaskByStatus($col),
            default => null
        };

        return $res ?: false;
    }

    /**
     * Delete By ID
     * 
     * @param int  $id
     * @return boolean
     */
    private function deleteTask($id)
    {
        try {
            $task = Task::find($id);
            
            return $task->delete();
        } catch (\Throwable $th) {
            info($th->getMessage());
        }
    }

    /**
     * Delete Tasks by status
     * 
     * @param boolean $status
     * @return boolean
     */
    private function deleteTaskByStatus($status)
    {
        try {
            return Task::status($status)->delete();

        } catch (\Throwable $th) {
            info($th->getMessage());
        }
    }
}
