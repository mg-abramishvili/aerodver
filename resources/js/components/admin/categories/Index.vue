<template>
    <div>
        <div class="subheader w-100 mb-3">
            <div class="row align-items-center">
                <div class="col-12 col-md-7">
                    <h1>Каталог</h1>
                </div>
                <div class="col-12 col-lg-5 text-end">
                    <router-link :to="{name: 'ProductMaster'}" class="btn btn-primary me-2">Добавить товар</router-link>
                    <router-link :to="{name: 'CategoryMaster'}" class="btn btn-primary">Добавить категорию</router-link>
                </div>
            </div>
        </div>

        <Loader v-if="views.loading" />

        <div v-if="!views.loading" class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
            <div class="w-100">
                <div class="row">
                    <div v-for="category in categories" class="col-12 col-lg-4">
                        <div class="box mb-4">
                            <router-link :to="{name: 'Category', params: {id: category.id} }" class="d-flex align-items-center fw-bold p-4" style="height: 100px;">
                                {{ category.name }}
                            </router-link>
                        </div>
                    </div>
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
            categories: [],

            views: {
                loading: true,
            }
        }
    },
    created() {
        this.loadCategories()
    },
    methods: {
        loadCategories() {
            axios.get('/_admin/categories')
            .then(response => {
                this.categories = response.data

                this.views.loading = false
            })
        },
    },
    components: {
        Loader
    }
}
</script>