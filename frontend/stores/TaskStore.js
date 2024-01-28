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
      this.tasks = await tasks
    },
    increment() {
      this.count++
    },
  },
})