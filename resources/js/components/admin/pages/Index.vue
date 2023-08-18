<template>
    <div>
        <div class="subheader w-100 mb-4">
            <div class="row align-items-center">
                <div class="col-12 col-md-7">
                    <h1>Страницы</h1>
                </div>
                <div class="col-12 col-lg-5 text-end">
                    
                </div>
            </div>
        </div>

        <Loader v-if="views.loading" />

        <div v-if="!views.loading" class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
            <div class="w-100">
                <div v-if="pages.length" class="box mb-4">
                    <table class="table">
                        <tbody>
                            <tr v-for="page in pages" :key="page.id">
                                <td>
                                    <router-link :to="{name: 'Page', params: {id: page.id} }" class="text-decoration-none">
                                        {{ page.name }}
                                    </router-link>
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
            pages: [],

            views: {
                loading: true,
            }
        }
    },
    created() {
        this.loadPages()
    },
    methods: {
        loadPages() {
            axios.get('/_admin/pages')
            .then(response => {
                this.pages = response.data

                this.views.loading = false
            })
        },
    },
    components: {
        Loader
    }
}
</script>