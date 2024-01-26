<?php

namespace Tests\Feature;

use App\Models\Task;
use Nuwave\Lighthouse\Testing\MakesGraphQLRequests;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskListGraphQLTest extends TestCase
{
    use MakesGraphQLRequests, RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_list_all_tasks(): void
    {
        $tasks = Task::factory()->count(3)->create();
        $name = $tasks[0]->name;
        $status = $tasks[0]->status;

        $this->graphQL(/** @lang GraphQL */ '
        {
            tasks {
                id,
                name,
                status
            }
        }
        ')->assertJson(function (AssertableJson $json) use ($name, $status) {
            $json->whereType('data.tasks.0.name', 'string|null');
            $json->whereType('data.tasks.0.status', 'boolean|null');
            $json->where('data.tasks.0.name', $name);
            $json->where('data.tasks.0.status', $status);
        });
    }

    public function test_list_all_tasks_empty_and_no_errors(): void
    {
        $this->graphQL(
        /** @lang GraphQL */
        '
        {
            tasks {
                id,
                name,
                status
            }
        }
        ')->assertJsonCount(0, "data.tasks");
    }
}
