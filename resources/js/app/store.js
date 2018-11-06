const store = {
    state: {
        loading: false,
        currentForum: null,
    },
    mutations: {
        setLoading (state, value) {
            state.loading = value;
        },

        setCurrentForum(state, value)
        {
            state.currentForum = value;
        }
    }
};

export default store;