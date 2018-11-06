<template>
    <div class="card">
        <div class="card-header">Active Threads</div>
        <div class="list-group list-group-flush">
            <router-link :to="{ name: 'thread', params: { id: thread.id } }"
                         class="list-group-item"
                         v-for="(thread, index) in app.activeThreads"
                         v-bind:key="index">
                <strong>{{ thread.title }}</strong>
                <br />
                <small>by {{ thread.latestPost.user.name }} &middot; {{ thread.latestPost.created_at | friendlyDate }}</small>
            </router-link>
        </div>
    </div>
</template>

<script>
    export default {
        name: "active-threads",
        props: ['app'],

        filters: {
            friendlyDate(value)
            {
                return moment(value).fromNow();
            }
        },
    }
</script>

<style scoped>

</style>