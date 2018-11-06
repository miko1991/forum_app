import pagination from '../components/pagination';

const Pagination = {
    install (Vue, options) {
        Vue.component(pagination.name, pagination)

        // Object containing Tour objects (see VTour.vue) where the tour name is used as key
        Vue.prototype.$pagination = {}
    }
}

export default Pagination