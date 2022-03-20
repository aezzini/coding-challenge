import productList from './components/product/List.vue';
import productHandle from './components/product/Handle.vue';
import categoryList from './components/category/List.vue';
import categoryHandle from './components/category/Handle.vue';

export const routes = [
    {
        name: 'productList',
        path: '/',
        component: productList
    },
    {
        name: 'productHandle',
        path: '/product/handle',
        component: productHandle
    },
    {
        name: 'categoryList',
        path: '/category/list',
        component: categoryList
    },
    {
        name: 'categoryHandle',
        path: '/category/handle',
        component: categoryHandle
    }
];