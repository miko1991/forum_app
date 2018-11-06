<template>
    <div class="container">
        <div class="jumbotron search-container justify-content-center" v-bind:style="{ 'background': 'url('+baseUrl + '/images/real_madrid.jpg'+')' }">
            <div style="border: 3px solid #3d4852;
                        background-color: #606f7b;
                        color: white;
                        padding: 15px;
                        border-radius: 12px;">
                <h1 class="display-4" style="margin-bottom: 0">{{ app.threadCount }} Threads for discussion</h1>
            </div>
            <div class="form-group" style="margin-top: 25px;">
                <form v-on:submit.prevent="onSubmit">
                    <input class="search-input" placeholder="Search the forums..." v-model="searchQuery" />

                </form>
            </div>


        </div>
    </div>

</template>

<script>
    export default {
        name: "category-search",
        props: ['app'],
        data() {
            return {
                searchQuery: '',
                baseUrl: BASE_URL,
            }
        },

        methods: {
            onSubmit()
            {
                let $this = this;

                this.app.$router.push({name:'search', query: { query: $this.searchQuery }});
            }
        }
    }
</script>

<style scoped>
    .search-input {
        width: 500px;
        height: 50px;
        border: 3px solid #676660;
        border-radius: 15px;
        padding-left: 20px;
        padding-right: 20px;
    }

    .search-container
    {
        display: flex;
        flex-direction: column;
        flex-flow: wrap;
    }


</style>