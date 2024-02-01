import App from './components/App.vue'
import AuthorList from "./components/AuthorList.vue";
import BookDetails from "./components/BookDetails.vue";
import BooksBySections from "./components/BooksBySections.vue";
import LastBooks from "./components/LastBooks.vue";
import ScrollToTopButton from "./components/ScrollToTopButton.vue";
import SectionList from "./components/SectionList.vue";
import * as VueRouter from "vue-router";
import BooksByAuthor from "./components/BooksByAuthor.vue";
import Login from "./components/Login.vue";
import Register from "./components/Register.vue";
import store from "./store/index.js";
import AdminSections from "./components/AdminSections.vue";
import AdminSectionEdit from "./components/AdminSectionEdit.vue";
import AdminAuthorUpdate from "./components/AdminAuthorUpdate.vue";
import BookContent from "./components/BookContent.vue";
import BookUpdate from "./components/BookUpdate.vue";
import CreateBook from "./components/CreateBook.vue";
import CreateAuthor from "./components/CreateAuthor.vue";
import Search from "./components/Search.vue";


export const router = VueRouter.createRouter({
    history: VueRouter.createWebHistory('laravel-vue-spa/public'),
    routes: [
        {
            path: '/',
            name: 'home',
            component: LastBooks
        },
        {
            path: '/sections',
            name: 'sections',
            component: BooksBySections
        },
        {
            path: '/authors',
            name: 'authors',
            component: AuthorList
        },
        {
            path: '/book/:id',
            name: 'book-details',
            component: BookDetails
        },
        {
            path: '/authors/:id',
            name: 'books-by-author',
            component: BooksByAuthor
        },
        {
            name: "login",
            path: "/login",
            component: Login,
        },
        {
            name: "register",
            path: "/register",
            component: Register,
        },
        {
            name: "adminSections",
            path: "/admin/sections",
            component: AdminSections,
        },
        {
            name: "adminSectionUpdate",
            path: "/admin/sections/:id",
            component: AdminSectionEdit,
        },
        {
            name: "AdminAuthorUpdate",
            path: "/admin/authors/:id",
            component: AdminAuthorUpdate,
        },
        {
            path: '/book/:id/content',
            name: 'BookContent',
            component: BookContent
        },
        {
            name: "BookUpdate",
            path: "/book/:id/edit",
            component: BookUpdate,
        },
        {
            name: "CreateBook",
            path: "/book/create",
            component: CreateBook,
        },
        {
            name: "CreateAuthor",
            path: "/admin/authors/create",
            component: CreateAuthor,
        },
        {
            name: "Search",
            path: "/search",
            component: Search,
        },
    ]
});

router.beforeEach((to, from, next) => {
    const token = localStorage.getItem('x_xsrf_token');

    if (token) {
        // Если пользователь авторизован, не пускать на страницы login и register
        if (to.name === 'login' || to.name === 'register') {
            return next({
                name: 'home'
            });
        }
    } else {
        // Если пользователь неавторизован, не пускать на страницу sections
        if (to.name === 'sections') {
            return next({
                name: 'login'
            });
        }
    }

    // В остальных случаях продолжить навигацию
    next();
});



