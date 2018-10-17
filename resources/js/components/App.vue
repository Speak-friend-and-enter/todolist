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
            <div class="card col-lg-4 m-2 p-0 text-center" @click="create()">
                +
            </div>
        </div>
        <!--<div>-->
            <!--<button @click="create()">Add</button>-->
        <!--</div>-->

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
                window.axios.post('/task-lists/get-lists').then(({ data }) => {
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
                console.log('del');
                window.axios.delete(`/task-lists/${id}`).then(() => {
                    let index = this.lists.findIndex(list => list.id === id);
                    this.lists.splice(index, 1);
                });
            },
            viewTask(id) {
                console.log('viewTasksParent');
                // this.$modal.show('tasks', {ttt:'aaa'});
            }
        },
        created() {
            this.read();
        }
    }
</script>

<style scoped>
    #lists {
        width: 100%;
    }
    .card {
        min-height: 160px;
        max-width: 365px;
    }
    .card:hover {
        background-color: #a1a1b4;
    }

</style>