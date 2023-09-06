<template>
    <div>
        <div class="subheader w-100 mb-4">
            <div class="row align-items-center">
                <div class="col-12 col-md-7">
                    <h1>Города</h1>
                </div>
                <div class="col-12 col-lg-5 text-end">
                    <router-link :to="{name: 'CityMaster'}" class="btn btn-primary me-2">Добавить город</router-link>
                </div>
            </div>
        </div>

        <Loader v-if="views.loading" />

        <div v-if="!views.loading" class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
            <div class="w-100">
                <div v-if="cities.length" class="box mb-4">
                    <table class="table">
                        <tbody>
                            <tr v-for="city in cities" :key="city.id">
                                <td>
                                    <router-link :to="{name: 'CityMaster', params: {id: city.id} }" class="text-decoration-none">
                                        {{ city.name }}
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
            cities: [],

            views: {
                loading: true,
            }
        }
    },
    created() {
        this.loadCities()
    },
    methods: {
        loadCities() {
            axios.get('/_admin/cities')
            .then(response => {
                this.cities = response.data

                this.views.loading = false
            })
        },
    },
    components: {
        Loader
    }
}
</script>