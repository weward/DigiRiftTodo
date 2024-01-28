export const useTaskStore = defineStore('task', {
  state: () => ({ 
    tasks: JSON.parse(localStorage?.getItem('tasks')),
  }),

  getters: {
    getTasks: (state) => state.tasks,
  },
  
  actions: {
    async updateTasks(payload) {
      const tasks = await JSON.stringify(payload)

      await localStorage.setItem('tasks', tasks)
      this.tasks = await payload
    },
    /**
     * Create a new Task
     * @param {String} input  name
     */
    async createTaskApi(input) {
        const query = await gql`
            mutation createTask ($INPUT: String!) {
                createTask(name: $INPUT) {
                    id
                    name
                    status
                }
            }
        `
        const variables = await {
            INPUT: input
        }
        // form mutation
        const { mutate } = await useMutation(query, { variables })
        // send to api
        const { data } = await mutate(variables)
        
        if (data.createTask) {
          // append to list
            this.tasks = await [
                ...this.tasks,
                data.createTask
            ]

            return await true
        }

        return await false
    },
    async updateTaskApi(taskId) {
      const query = await gql`
            mutation updateTask ($TASK_ID: ID!) {
                updateTask(id: $TASK_ID) {
                    id
                    name
                    status
                }
            }
        `
        // compose variable
        const variables = await {
            TASK_ID: taskId
        }
        // form mutation
        const { mutate } = await useMutation(query, { variables })
        // send to api
        let { data } = await mutate(variables)

        if (data.updateTasks) {
          // update store state
          this.tasks = this.tasks.map((elem) => 
            elem = {
              ...elem,
              status: elem.id == taskId ? !elem.status : elem.status
            }
          )
        }

        return await data.updateTasks
    },
    async deleteTaskApi(type, payload) {
      const query = await (type == 'id') 
        ?   gql`
          mutation deleteTask($TASK_ID: ID!) {
              deleteTask(id: $TASK_ID)
          }
        `
        :  gql`
          mutation deleteTask($STATUS: String!) {
              deleteTask(status: $STATUS)
          }
        `
      // compose variable
      const variables = await (type == 'id') ? { TASK_ID: payload } : { STATUS: payload }
      
      const { mutate } = await useMutation(query, { variables })

      // send to api
      let { data } = await mutate(variables)

      if (data.deleteTask) {
        this.tasks = this.tasks.filter((elem) => elem[type] != payload)
      }

      return data.deleteTask
    }
  },
})