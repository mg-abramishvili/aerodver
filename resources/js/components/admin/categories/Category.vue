<template>
    <div>
        <div class="subheader w-100 mb-3">
            <div class="row align-items-center">
                <div class="col-12 col-md-7">
                    <h1>
                        <template v-if="category.parent_id">
                            <router-link :to="{name: 'Category', params: {id: category.parent_id} }">Назад</router-link>
                            <span class="text-muted me-2">/</span>
                        </template>
                        <template v-else>
                            <router-link :to="{name: 'Categories'}">Каталог</router-link>
                            <span class="text-muted me-2">/</span>
                        </template>

                        {{ category.name }}
                        <router-link v-if="category.id" :to="{name: 'CategoryMaster', params: {id: category.id} }" class="btn btn-sm btn-outline-secondary ms-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                            </svg>
                        </router-link>
                    </h1>
                </div>
                <div class="col-12 col-lg-5">
                    
                </div>
            </div>
        </div>

        <Loader v-if="views.loading" />

        <div v-if="!views.loading && category.children" class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
            <div class="w-100">
                <div class="row">
                    <div v-for="children in category.children" class="col-12 col-lg-4">
                        <div class="box mb-4">
                            <router-link :to="{name: 'Category', params: {id: children.id} }" class="d-flex align-items-center fw-bold p-4" style="height: 100px;">
                                {{ children.name }}
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="!views.loading" class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
            <div class="w-100">
                <div class="box mb-4">
                    <table v-if="category.products && category.products.length" class="table">
                        <tbody>
                            <tr v-for="(product, index) in category.products">
                                <td class="text-center text-muted">{{ index + 1 }}</td>
                                <td>
                                    <router-link :to="{name: 'ProductMaster', params: {id: product.id} }" class="text-decoration-none">
                                        {{ product.name }}
                                        <br><small class="text-muted">{{ product.name_eng }}</small>
                                    </router-link>
                                </td>
                                <td class="fw-bold">{{ product.price_rub }}₽ &nbsp;&nbsp;<span class="text-muted">${{ product.price_usd }}</span></td>
                            </tr>
                        </tbody>
                    </table>
                    <p v-else class="m-0 p-4">Категория пуста.</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Loader from '../Loader.vue'

export default {
    data() {
        return {
            category: {},

            views: {
                loading: true,
            }
        }
    },
    created() {
        this.loadCategory()
    },
    methods: {
        loadCategory() {
            axios.get(`/_admin/category/${this.$route.params.id}`)
            .then(response => {
                this.category = response.data

                this.views.loading = false
            })
        },
    },
    components: {
        Loader
    }
}
</script>