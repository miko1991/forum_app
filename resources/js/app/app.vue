<template>
    <div>
        <navbar :app="this"></navbar>
        <spinner class="bigSpinner"
                 size="massive"
                 line-fg-color="#4CAF50"
                 v-if="$store.state.loading"
                 message="Loading...">
        </spinner>
        <div v-else>
            <transition name="fade">
                <router-view :app="this" style="margin-top: 25px; margin-bottom: 50px"></router-view>
            </transition>
        </div>

    </div>
</template>

<script>
    import Navbar from "./components/navbar";
    import NProgress from 'nprogress';

    import Helper from '../utils/helper';


    export default {
        name: "app",
        components: {Navbar},
        data()
        {
            return {
                request: axios.create({
                    baseUrl: BASE_URL
                }),
                store: this.$store,
                user: null,
                postsCount: 0,
                activeThreads: null,
                threadCount: 0,
                loading: false,
                helper: Helper,
            }
        },

        mounted()
        {
            this.request.interceptors.request.use(config => {
                NProgress.start();
                return config;
            });

            this.request.interceptors.response.use(response => {
                NProgress.done();
                return response;
            });

            this.init();
        },

        methods: {
            init()
            {
                let $this = this;

                this.$store.commit('setLoading', true);

                this.request.get('auth/init').then(function (response) {
                    $this.$store.commit('setLoading', false);
                    $this.user = response.data.user;
                    $this.threadCount = response.data.threadCount;

                    $this.activeThreads = response.data.activeThreads;



                })
            },
        }
    }
</script>

<style scoped>
    .fade-enter-active {
        transition: opacity .5s;
    }
    .fade-enter /* .fade-leave-active below version 2.1.8 */ {
        opacity: 0;
    }

    .bigSpinner
    {
        margin: 25% auto auto;

    }
</style>