<template>

    <div class="card">
        <div class="card-header">
            <label>
                <input v-model="name">
            </label>
            <button class="btn-info" @click="updateListName">Update</button>
            <button class="btn-danger" @click="deleteList">Delete</button>
        </div>
        <div class="card-body">
            tasks.
        </div>
    </div>

</template>

<script>
    export default {
        name: "TaskList",
        props: ['id', 'name', 'tasks'],
        methods: {
            updateListName() {
                this.$emit('update', this.id, this.name);
            },
            deleteList() {
                this.$emit('delete', this.id);
            }
        }
    }
</script>

<style scoped>

</style>