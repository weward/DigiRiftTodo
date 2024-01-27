<?php

namespace Tests\Feature;

use App\Models\Task;
use Nuwave\Lighthouse\Testing\MakesGraphQLRequests;
use Nuwave\Lighthouse\Testing\RefreshesSchemaCache;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\CreatesApplication;

class TaskUpdateGraphQLTest extends BaseTestCase
{
    use CreatesApplication;
    use MakesGraphQLRequests;
    use RefreshesSchemaCache;
    use RefreshDatabase;
    
    /**
     * Update a specific task
     */
    public function test_update_specific_task(): void
    {
        $task = Task::factory()->create();
        $originalStatus = $task->status;
        $name = $task->name;
        $taskId = $task->id;

        $this->graphQL(
            /** @lang GraphQL */
            '
            mutation($taskId: ID!) {
                updateTask(id:$taskId) {
                    id
                    name
                    status
                }
            }
        ',
        [
            'taskId' => $taskId,
        ]
        )->assertJson(function (AssertableJson $json) use ($name, $originalStatus) {
            $json->where('data.updateTask.name', $name);
            // status was updated
            $json->where('data.updateTask.status', !$originalStatus); 
        });
    }


    /**
     * Update a specific task
     */
    public function test_update_specific_task_not_existing_returns_null(): void
    {
        $taskId = 999999999999;
        $this->graphQL(
            /** @lang GraphQL */
            '
            mutation($taskId: ID!) {
                updateTask(id:$taskId) {
                    id
                    name
                    status
                }
            }
        ',
            [
                'taskId' => $taskId,
            ]
        )->assertJson(function (AssertableJson $json) {
            $json->where('data.updateTask', null);
        });
    }
}
