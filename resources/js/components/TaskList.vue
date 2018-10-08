<template>

    <div class="card">
        <div class="card-header">{{ name }}</div>
        <div class="card-body">
            tasks.
            <button @click="del">Delete</button>
        </div>
    </div>

</template>

<script>
    export default {
        name: "TaskLists",
        methods: {
            update(val) {
                this.$emit('update', this.id, val.target.selectedOptions[0].value);
            },
            del() {
                this.$emit('delete', this.id);
            }
        }
    }
</script>

<style scoped>

</style>