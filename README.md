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
- 


## Installation 

### API Installation

- Clone the repository

`git clone git@github.com:weward/DigiDriftTodo.git`

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
docker exec -it DigiRiftTodo_php composer install
```

- Initialize App Key

```sh
# Generate app key 
docker exec -it DigiRiftTodo_php php artisan key:generate 
```

- Run the application

```sh
docker exec -it DigiRiftTodo_php php artisan serve
```




---
---


### Frontend (NUXT) Installation

- `cd frontend`
- `npm install`
- `npm run dev` 
- [http://localhost:3000/](http://localhost:3000/)

