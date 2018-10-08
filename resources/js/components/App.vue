<template>

    <div id="lists">
        <div class="heading">
            <h1>Lists</h1>
        </div>
        <div class="row">
            <task-lists-component
                    v-for="list in lists"
                    v-bind="list"
                    :key="list.id"
                    @update="update"
                    @delete="del"
            ></task-lists-component>
        </div>
        <div>
            <button @click="create()">Add</button>
        </div>
    </div>

</template>
<script>
    function List({ id, name}) {
        this.id = id;
        this.name = name;
    }

    import TaskList from './TaskList.vue';

    export default {
        name: "App",
        data() {
            return {
                lists: [],
            }
        },
        methods: {
            create() {
                window.axios.get('/task-lists/create').then(({ data }) => {
                    this.lists.push(new List(data));
                });
            },
            read() {
                window.axios.post('/task-lists/get-tasks').then(({ data }) => {
                    console.log(data);
                    data.forEach(list => {
                        this.lists.push(new List(list));
                    });
                });
            },
            update(id, name) {
                window.axios.put(`/task-lists/${id}`, { name }).then(() => {
                    this.lists.find(list => list.id === id).name = name;
                });
            },
            del(id) {
                window.axios.delete(`/task-lists/${id}`).then(() => {
                    let index = this.lists.findIndex(list => list.id === id);
                    this.lists.splice(index, 1);
                });
            }
        },
        created() {
            this.read();
        }
    }
</script>

<style scoped>

</style>