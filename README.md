# DigiRift Todo Application

```
Author: Roland Santos
Email: dev.weward@gmail.com
Github: https://github.com/weward
LinkedIn: https://www.linkedin.com/in/roland-edward-santos/
```


## Table Of Contents 

- [Installation](#installation)
    - [API Installation](#api-installation)
    - [Frontend Installation](#frontend-nuxt-installation)
- [Tech Stack](#tech-stack)
- [Notes](#notes)
    - [CORS](#cors)
    - [User Stories](#user-stories)
    - [Sample Data - (Request / Response)](#sample-data)




.
## INSTALLATION 



### Clone the repository

`git clone git@github.com:weward/DigiDriftTodo.git`


.
---

### API Installation



```sh
# Go to ./api
cd api

```


Copy `.env` File

```sh
cp .env.example .env
```

- Initialize Docker

```sh
# Install Docker Containers
docker-compose up -d --build

# Check installed containers
docker ps 
```

- Composer install 

```sh
# Enter Container
docker exec -it {APP_NAME}_php composer install
```

- Initialize App Key

```sh
# Generate app key 
docker exec -it {APP_NAME}_php php artisan key:generate 
```

- Migrate the database

```sh
docker exec -it {APP_NAME}_php php artisan migrate 
```

- Seed the database

```sh
docker exec -it {APP_NAME}_php php artisan db:seed
```

- Run the application

```sh
docker exec -it {APP_NAME}_php php artisan serve
```




---
---


### Frontend (NUXT) Installation


```sh
# Go to ./frontend
cd frontend

```


- Configure API endpoint in `.env`

```sh

# Copy default
cp .env.example .env

# Update the API url (laravel)
GRAPHQL_URL=

```


- Install Dependencies

```sh
npm install
```

- Run Dev

```sh
npm run dev

# Default URL
# http://localhost:3000/

```

## TECH STACK

- API
    - [Laravel 10](https://laravel.com/)
    - [nuwave/lighthouse (GraphQL)](https://github.com/nuwave/lighthouse)


- FROTNEND
    - [Nuxt 3](https://nuxt.com/docs/getting-started/introduction)
    - [@nuxt/apollo](https://apollo.nuxtjs.org/)
    - [Vuetify](https://vuetifyjs.com/en/getting-started/installation/)
    - [Pinia (store)](https://pinia.vuejs.org/ssr/nuxt.html)
    - [Vue3 perfect scrollbar](https://github.com/mercs600/vue3-perfect-scrollbar)
    - [Formkit/auto-animate](https://auto-animate.formkit.com/)
    - [Sass](https://vuetifyjs.com/en/features/sass-variables/#installation)


## NOTES 

---

### TaskFactory 

I've added a `TaskFactory` for generating random tasks

```php

    # Generate 'TODO' tasks
    Task::factory()->todo()->count(10)->create();


    # Generate 'Done' tasks
    Task::factory()->done()->count(10)->create();


    # Geneate a Task with a specifc name/label
    Task::factory()->name("Attend Family Day")->create();

```

- Custom Query Scope

I've added custom query scope for the status columnd. 

```php

    # Query all tasks marked as done
    Task::status(true)->get();

    # Query all 'TODO' tasks
    Task::status(false)->get();

```



### CORS

Added Cors middleware to `api/config/lighthouse.php`

```php
    'middleware' => [
        // ... other middlwers
        \Illuminate\Http\Middleware\HandleCors::class,

    ]
```





### User Stories

- User can input a text in the `input field`.
- User can `submit` the text in the input field.
- User may `click` or `press the enter` key to `submit` the input.
- User `cannot submit` a `blank` input.
- User can see a `scrollable list` of tasks.
- User can toggle (`check` or `uncheck`) each task in the list to `update` the status from `todo` to `done` or vice-versa.
- User can see the indicator on the task that has been marked as `done`.
- User can see the `unticked checkbox` if the task is of `todo` status.
- User can click the `delete` button on each task in the list to delete the corresponding task.
- User can click the `All Done` button to delete all the `done` tasks in the list.
- User may only click the `All Done` button if there are `done` tasks in the list. If none, the button disappears automatically.
- User can click the `All Todos` button to delete all the `todo` tasks in the list.
- User may only click the `All Todos` button if there are `todo` tasks in the list. If none, the button disappears automatically.
- User is prompted for confirmation whether to proceed with the batch (all todos/all done) deletion.
- User can see the count of tasks marked as `todo` in the toolbar.
- User can see the count of tasks marked as `done` in the toolbar.



### Sample Data
---

### Task Creation

Input: "Reformat PC"

Output:

```js
{
    "data":
    {
        "createTask":
        {
            "id": "77",
            "name": "Reformat PC",
            "status": false
        }
    }
}

```

---
### Task Updating
---

From todo to done


- **Input:** (Toggle checkbox)
- **Output:**

    ```js
    {
        "data":
        {
            "updateTask":
            {
                "id": "75",
                "name": "Reformat PC",
                "status": true // done
            }
        }
    }
    ```
    Failed

    ```js
    {
        "data": {
            "updateTask": null
        }
    }
    ```

---
### Task Deletion
---



Delete a single task (by ID):

**Input:** 

```graphql
mutation {
    deleteTask(id: 8)
}

```


**Output:**

`Successful`
```js
{
    "data":
    {
        "deleteTask": true
    }
}
```
`Failed`

```js
{
    "data": {
        "deleteTask": false
    }
}
```


---

Delete All Todos (status: `false`) 



**Input:**

```graphql
mutation {
    deleteTask(status: false)
}

```


**Output:**
    
`Successful`

```js
{
    "data":
    {
        "deleteTask": true
    }
}
```

`Failed`

```js
{
    "data": {
        "deleteTask": false
    }
}
```

---
    

Delete All `Done` Tasks (status: `true`) 


**Input:**

```graphql
mutation {
    deleteTask(status: true)
}
```

**Output:**

`Successful`

```js
{
    "data":
    {
        "deleteTask": true
    }
}
```

`Failed`

```js
{
    "data": {
        "deleteTask": false
    }
}
```


### Improvements

- UI Improvements 
    - UI/UX 
    - Error notifications / validations

    > Due to time constraints, conceptualizing and implementing a decent theme/UI/UX was reserved in favor of a simple but functional UI. Only Vuetify, Sass, Formkit/auto-animate and Vue3 perfect-scrollbar were used.


- Better Docker configuration (+ image)

    > It would have been nicer to have the configuration in an image 



### Testing

This application was fully tested and necessary tests were set-up for QA and TDD.


To test, 

```sh
docker exec -it {APP_NAME}_php php artisan test

```
