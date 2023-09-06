import { createRouter, createWebHistory } from 'vue-router'

import Home from './components/admin/Home.vue'

import Categories from './components/admin/categories/Index.vue'
import Category from './components/admin/categories/Category.vue'
import CategoryMaster from './components/admin/categories/CategoryMaster.vue'

import Products from './components/admin/products/ProductsByViews.vue'
import ProductMaster from './components/admin/products/ProductMaster.vue'

import Leads from './components/admin/leads/Index.vue'

import Pages from './components/admin/pages/Index.vue'
import Page from './components/admin/pages/Edit.vue'

import Settings from './components/admin/settings/Edit.vue'

import AuditArenda from './components/admin/audit-arenda/Edit.vue'

import Videos from './components/admin/Videos/Index.vue'
import VideoMaster from './components/admin/Videos/VideoMaster.vue'

import MainBanners from './components/admin/mainbanners/Index.vue'
import MainBannerMaster from './components/admin/mainbanners/MainBannerMaster.vue'

import Cities from './components/admin/cities/Index.vue'
import CityMaster from './components/admin/cities/Master.vue'

import Firms from './components/admin/firms/Index.vue'
import FirmMaster from './components/admin/firms/Master.vue'

const routes = [
    {
        path: '/admin',
        name: 'Home',
        component: Home
    },
    {
        path: '/admin/categories',
        name: 'Categories',
        component: Categories
    },
    {
        path: '/admin/category/:id',
        name: 'Category',
        component: Category
    },
    {
        path: '/admin/category-master/:id?',
        name: 'CategoryMaster',
        component: CategoryMaster
    },
    {
        path: '/admin/products',
        name: 'Products',
        component: Products
    },
    {
        path: '/admin/product-master/:id?',
        name: 'ProductMaster',
        component: ProductMaster
    },
    {
        path: '/admin/pages',
        name: 'Pages',
        component: Pages
    },
    {
        path: '/admin/page/:id',
        name: 'Page',
        component: Page
    },
    {
        path: '/admin/settings',
        name: 'Settings',
        component: Settings
    },
    {
        path: '/admin/audit-arenda',
        name: 'AuditArenda',
        component: AuditArenda
    },
    {
        path: '/admin/leads',
        name: 'Leads',
        component: Leads
    },
    {
        path: '/admin/videos',
        name: 'Videos',
        component: Videos
    },
    {
        path: '/admin/video-master/:id?',
        name: 'VideoMaster',
        component: VideoMaster
    },
    {
        path: '/admin/mainbanners',
        name: 'MainBanners',
        component: MainBanners
    },
    {
        path: '/admin/mainbanner-master/:id?',
        name: 'MainBannerMaster',
        component: MainBannerMaster
    },
    {
        path: '/admin/cities',
        name: 'Cities',
        component: Cities
    },
    {
        path: '/admin/cities-master/:id?',
        name: 'CityMaster',
        component: CityMaster
    },
    {
        path: '/admin/firms',
        name: 'Firms',
        component: Firms
    },
    {
        path: '/admin/firm-master/:id?',
        name: 'FirmMaster',
        component: FirmMaster
    },
];

export default createRouter({
    history: createWebHistory(),
    routes
})