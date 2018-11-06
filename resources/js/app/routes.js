import Categories from './pages/categories';
import Forum from './pages/forum';
import Thread from './pages/thread';
import ThreadCreate from './pages/thread.create';
import Search from './pages/search';
import Register from './pages/register';
import Login from './pages/login';

const routes = [
    { path: '/', component: Categories, name: 'categories' },

    { path: '/forum/:id', component: Forum, name: 'forum' },
    { path: '/thread/create', component: ThreadCreate, name: 'thread.create' },
    { path: '/thread/:id', component: Thread, name: 'thread' },


    { path: '/search', component: Search, name: 'search' },

    { path: '/register', component: Register, name: 'register' },
    { path: '/login', component: Login, name: 'login' },

    { path: '*', redirect: '/' }
];

export default routes;