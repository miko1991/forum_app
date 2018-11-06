<template>
    <div>
        <spinner v-if="app.loading"></spinner>
        <div v-else-if="forum">
            <div class="container">
                <div class="jumbotron">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><router-link :to="{ name: 'categories' }">Home</router-link></li>
                            <li class="breadcrumb-item">{{ forum.title }}</li>
                        </ol>
                    </nav>

                    <h1 class="display-4">{{ forum.title }}</h1>
                </div>
            </div>


            <div class="container">
                <div class="row">
                    <div class="col-md-8">

                        <div style="margin-bottom: 60px" v-if="app.user">
                            <a href="javascript:void(0)"
                               @click="goToCreate(forum)"
                               style="display: block"
                               class="btn btn-lg btn-success float-right">

                                Create Thread
                            </a>
                        </div>


                        <div class="card" style="display: block">
                            <div class="list-group list-group-flush">
                                <router-link :to="{ name: 'thread', params: { id: thread.id }}"
                                             class="list-group-item
                                     list-group-item-action
                                     d-flex
                                     justify-content-between
                                     align-items-center"
                                             style="padding: 25px"
                                             v-for="thread in forum.threads.data"
                                             v-bind:key="thread.id">


                                    <div>
                                        <img class="image" :src="baseUrl + '/images/user.png'" />
                                        <div style="display: inline-block; vertical-align: bottom; margin-left: 10px">
                                            <h4>{{ thread.title | shortTitle }}</h4>
                                            <span>Post by: {{ thread.user.name }}</span>
                                            <br />
                                            <span>
                                                Latest reply: {{ thread.latestPost.user.name }} &middot;
                                                {{ thread.latestPost.created_at | friendlyDate }}
                                            </span>
                                        </div>

                                    </div>

                                    <div style="text-align: center">
                                        <span>{{ thread.created_at | friendlyDate }}</span>
                                        <div style="border-radius: 10px; background-color: #b5b3aa; padding: 10px; width: 125px">
                                            <span style="font-size: 18px">{{ thread.postCount - 1 }}</span>
                                            <br/>
                                            <span style="font-size: 14px; color: #606f7b;">REPLIES</span>
                                        </div>
                                    </div>

                                </router-link>
                            </div>

                            <!-- Pagination -->

                            <pagination :total-pages="lastPage"
                                        :page="currentPage"
                                        :app="app"
                                        style="margin-top: 20px"
                                        :on-click-page="clickPage">
                            </pagination>
                        </div>

                    </div>
                    <div class="col-md-4">
                        <active-threads :app="app"></active-threads>
                    </div>

                </div>

            </div>
        </div>

    </div>
</template>

<script>
    import ActiveThreads from "../components/active-threads";
    export default {
        name: "fora",
        components: {ActiveThreads},
        props: ['app'],
        data()
        {
            return {
                forumId: this.app.$route.params.id,
                forum: null,
                baseUrl: BASE_URL,
                lastPage: 0,
                currentPage: this.app.$route.query.page ? this.app.$route.query.page : 1,

            }
        },

        mounted()
        {
            let $this = this;

            this.getForum();

        },

        filters: {
            friendlyDate(value)
            {
                return moment(value).fromNow();
            },

            shortTitle(value)
            {
                return value.length > 35 ? value.substring(0, 35) + '...' : value;
            }
        },

        methods: {
            getForum()
            {
                let $this = this;

                this.app.loading = true;



                this.app.request.get('forum/'+this.forumId).then(function (response) {
                    $this.app.loading = false;

                    if (response.data.id)
                    {
                        $this.forum = response.data;
                        $this.lastPage = response.data.threads.last_page;
                    }
                })
            },

            clickPage(page)
            {
                let $this = this;


                this.app.request.get('forum/'+this.forumId+'?page='+page).then(function (response) {
                    if (response.data.id)
                    {
                        $this.forum = response.data;
                        $this.lastPage = response.data.threads.last_page;
                        $this.app.$router.replace({name: 'forum', query: { page: page }});
                    }

                });
            },

            goToCreate(forum)
            {
                this.app.store.commit('setCurrentForum', forum);
                this.app.$router.push({name: 'thread.create'});
            }

        }
    }
</script>

<style scoped>
    .image
    {
        height: 75px;
    }
</style>