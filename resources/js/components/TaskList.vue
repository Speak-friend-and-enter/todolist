<template>

    <div v-if="list === true" class="card col-lg-4 p-0">
        <div v-if="share === true">
            Enter user name to share:
            <input type="text" v-model="shareName"/>
            <button v-on:click="share = false">x</button>
        </div>
        <div class="card-header">
            <label>
                <input v-model="name">
            </label>
            <button class="btn-info" @click="updateListName">Update</button>
            <button class="btn-warning" @click="shareList(id)">Share</button>
            <button class="btn-danger" @click="deleteList">Delete</button>
        </div>
        <div class="card-body">
            <button class="btn-info" v-on:click="viewTasks">View</button>
        </div>
    </div>

    <div v-else class="card col-lg-4 p-0">
        <ul>
            <li v-for="task in tasks">
                <label>
                    <input type="checkbox" v-on:click.prevent="changeTaskStatus(task.id, task.status)" v-bind:checked="task.status"/>
                </label>
                <label>
                    <input v-model="task.name" v-on:keyup.13="updateTask(task.id, task.name)">
                </label>
                <button class="btn-info" @click="deleteTask(task.id)">Delete</button>
            </li>
        </ul>
        <div class="card-body">
            <button class="btn-info" @click="createTask">Add Task</button>
            <button class="btn-toolbar" @click="closeTasks">Close</button>
        </div>
    </div>

</template>

<script>
    export default {
        name: "TaskList",
        props: ['id', 'name'],
        data() {
          return {
              list: true,
              share: false,
              shareName: '',
              tasks: []
          }
        },
        methods: {
            updateListName() {
                this.$emit('update', this.id, this.name);
            },
            deleteList() {
                console.log('delete');
                this.$emit('delete', this.id);
            },
            createTask() {
                window.axios.post('/task/create', {'listId' : this.id}).then(({ data }) => {
                    console.log('createTask');
                    this.tasks.push({name:data['name'], status: false, id:data['id']});
                    console.log(data);
                });
            },
            viewTasks() {
                this.list = false;
                window.axios.post('/task/get-tasks', {'listId' : this.id}).then(({ data }) => {
                    console.log('viewTasks', data);
                    data.forEach(task => {
                        if(!this.inArray(task)) {
                            this.tasks.push({name: task['name'], status: task['completed'], id: task['id']});
                        }
                    });
                    console.log(this.tasks);
                });
            },
            inArray(task) {
                console.log('inArray');
                return this.tasks.some(function (element) {
                    return element.id === task.id;
                })
            },
            closeTasks() {
                this.list = true;
            },
            changeTaskStatus(id, status) {
                if(!status) {
                    status = 1;
                } else {
                    status = 0;
                }
                window.axios.put(`/task/${id}`, { status }).then(() => {
                    this.tasks.find(task => task.id === id).status = status;
                    console.log('status changed');
                });
            },
            updateTask(id, name) {
                window.axios.put(`/task/${id}`, { name }).then(() => {
                    this.tasks.find(task => task.id === id).name = name;
                    console.log('name changed');
                });
            },
            deleteTask(id) {
                window.axios.delete(`/task/${id}`).then(() => {
                    console.log('deleteTask - success', id);
                    let index = this.tasks.findIndex(task => task.id === id);
                    this.tasks.splice(index, 1);
                });
            },
            shareList(id) {
                if(this.shareName && this.share) {
                    // console.log('true', id);
                    window.axios.post('/share/create', {'shareName': this.shareName, 'listId': id}).then((data) => {
                        console.log('true', data);
                    });
                }
                this.share = true;
            },
        }
    }
</script>

<style scoped>

</style>