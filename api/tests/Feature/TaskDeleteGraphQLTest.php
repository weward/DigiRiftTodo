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

class TaskDeleteGraphQLTest extends BaseTestCase
{
    use CreatesApplication;
    use MakesGraphQLRequests;
    use RefreshesSchemaCache;
    use RefreshDatabase;


    public function test_delete_a_task_by_id(): void
    {
        $task = Task::factory()->create();
        $taskId = $task->id;

        $this->graphQL(
            /** @lang GraphQL */
            '
            mutation($taskId: ID!) {
                deleteTask(id:$taskId)
            }
        ',
            [
                'taskId' => $taskId,
            ]
        )->assertJson(function (AssertableJson $json) {
            $json->where('data.deleteTask', true);
        });
    }

    /**
     * Delete ALL task with specified status
     */
    public function test_delete_all_task_by_specified_status(): void
    {
        Task::factory()->done()->count(3)->create();
        Task::factory()->active()->count(3)->create();

        $this->assertEquals(Task::count(), 6);

        $statusToDelete = 1;

        $this->graphQL(
            /** @lang GraphQL */
            '
            mutation($status: Boolean!) {
                deleteTask(status:$status)
            }
        ',
            [
                'status' => $statusToDelete ? true : false,
            ]
        )->assertJson(function (AssertableJson $json) {
            $json->where('data.deleteTask', true);
        });

        
        $this->assertEquals(Task::count(), 3);
    }
}
