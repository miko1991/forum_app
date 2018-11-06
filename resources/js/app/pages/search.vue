<template>
    <div>
        <div class="container">
            <div class="jumbotron">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><router-link :to="{ name: 'categories' }">Home</router-link></li>
                        <li class="breadcrumb-item">Search</li>
                    </ol>
                </nav>

                <h1 class="display-4">Search</h1>


                <div class="form-group">
                    <form v-on:submit.prevent="onSubmit">
                        <input class="search-input" placeholder="Search the forums..." v-model="searchModel" />

                    </form>
                </div>
            </div>
        </div>

        <spinner v-if="app.loading"></spinner>
        <div v-else>
            <div class="container" v-if="lastPage > 1">
                <!-- Pagination -->

                <pagination :total-pages="lastPage"
                            :page="currentPage"
                            :app="app"
                            style="margin-top: 20px"
                            :on-click-page="clickPage">
                </pagination>
            </div>


            <div class="container">
                <div class="card" style="display: block" v-if="gotResults">
                    <!-- Search Results -->

                    <div class="list-group list-group-flush">
                        <router-link :to="{ name: 'thread', params: { id: thread.id }}"
                                     class="list-group-item
                                     list-group-item-action
                                     d-flex
                                     justify-content-between
                                     align-items-center"
                                     style="padding: 25px"
                                     v-for="(thread, index) in threads"
                                     v-bind:key="index">


                            <div>
                                <img class="image" :src="baseUrl + '/images/user.png'" />
                                <div style="display: inline-block; vertical-align: bottom; margin-left: 10px">
                                    <h4>{{ thread.title }}</h4>
                                    <span>Post by: {{ thread.user.name }}</span>
                                    <br />
                                    <span>Latest reply: {{ thread.latestPost.user.name }}</span>
                                </div>

                            </div>

                            <div style="text-align: center">
                                <span>{{ thread.created_at | friendlyDate }}</span>
                                <div style="border-radius: 10px; background-color: #b5b3aa; padding: 10px; width: 125px">
                                    <span style="font-size: 18px">{{ thread.replies }}</span>
                                    <br/>
                                    <span style="font-size: 14px; color: #606f7b;">REPLIES</span>
                                </div>
                            </div>

                        </router-link>
                    </div>

                </div>
                <div v-else role="alert" class="alert alert-info" style="margin-bottom: 0;">
                    No results.
                </div>
            </div>

        </div>



    </div>

</template>

<script>
    export default {
        name: "search",
        props: ['app'],
        data()
        {
            return {
                searchQuery: this.search ? this.search : this.app.$route.query.query,
                searchModel: '',
                threads: [],
                baseUrl: BASE_URL,
                currentPage: this.app.$route.query.page ? this.app.$route.query.page : 1,
                lastPage: 0,
                gotResults: null,
            }
        },
        mounted()
        {
            this.search();
        },
        filters: {
            friendlyDate(value)
            {
                return moment(value).fromNow();
            }
        },

        methods: {
            search(page)
            {
                this.threads = 0;
                this.lastPage = 0;

                if (page)
                {
                    this.currentPage = page;
                }

                let $this = this;

                this.app.loading = true;

                this.app.request.get('thread/search/'+this.app.$route.query.query+'?page='+this.currentPage).then(function (response) {
                    $this.app.loading = false;

                    if (response.data.data.length)
                    {
                        $this.threads = response.data.data;
                        $this.lastPage = response.data.last_page;
                        $this.app.$pagination.currentPage = 1;
                        $this.gotResults = true;
                    }
                    else
                    {
                        $this.gotResults = false;
                    }
                })
            },

            clickPage(page)
            {
                let $this = this;


                this.app.request.get('thread/search/'+this.app.$route.query.query+'?page='+page).then(function (response) {
                    if (response.data.data.length)
                    {
                        $this.threads = response.data.data;
                        $this.lastPage = response.data.last_page;
                        $this.app.$router.replace({name: 'search', query: { query: $this.app.$route.query.query, page: page }});
                    }

                });
            },

            onSubmit()
            {
                this.app.$router.replace({name:'search', query: { query: this.searchModel, page: 1 }});
                this.search(1);
            }
        }
    }
</script>

<style scoped>
    .image
    {
        height: 75px;
    }

    .search-input {
        width: 500px;
        height: 50px;
        border: 3px solid #676660;
        border-radius: 15px;
        padding-left: 20px;
        padding-right: 20px;
    }
</style>