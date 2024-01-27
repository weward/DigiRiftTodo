<?php declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\Task;

final class UpdateTaskMutator
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        try {
            $task = Task::find($args['id']);
            
            $task->update([
                'status' => !$task->status
            ]);

            return $task;
        } catch (\Throwable $th) {
            info($th->getMessage());
        }

        return null;
    }
}
