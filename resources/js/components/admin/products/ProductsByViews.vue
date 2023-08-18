<template>
    <div>
        <div class="subheader w-100 mb-4">
            <div class="row align-items-center">
                <div class="col-12 col-md-7">
                    <h1>Просмотры товаров</h1>
                </div>
                <div class="col-12 col-lg-5 text-end">
                    
                </div>
            </div>
        </div>

        <Loader v-if="views.loading" />

        <div v-if="!views.loading" class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
            <div class="w-100">
                <div v-if="products.length" class="box mb-4">
                    <table class="table">
                        <tbody>
                            <tr v-for="product in products" :key="product.id">
                                <td>
                                    {{ product.name }}
                                </td>
                                <td>
                                    {{ product.view_counter }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <p v-else>Раздел пуст.</p>
            </div>
        </div>
    </div>
</template>

<script>
import Loader from '../Loader.vue'

export default {
    data() {
        return {
            products: [],

            views: {
                loading: true,
            }
        }
    },
    created() {
        this.loadProducts()
    },
    methods: {
        loadProducts() {
            axios.get('/_admin/products')
            .then(response => {
                this.products = response.data

                this.views.loading = false
            })
        },
    },
    components: {
        Loader
    }
}
</script>