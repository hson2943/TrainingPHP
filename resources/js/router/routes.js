const admin = [{
    path: '/',
    name: 'home',
    component: () =>
        import('../layouts/layout.vue'),
    children: [{
        path: "",
        name: 'all-products',
        component: () =>
            import('../pages/index.vue'),
    },
    {
        path: 'update/:id',
        name: 'product-update',
        component: () => import('../pages/update.vue'),
        meta: {
            requiresAuth: true
        }
    },
    {
        path: 'detail/:id',
        name: 'product-detail',
        component: () => import('../pages/detailPage.vue'),
        
    }
    ,
    {
        path: '/:pathMatch(.*)*',
        name: 'notFound',
        component: () =>
            import('../pages/notFound.vue')
    }
    ],

}]

export default admin;