<template>
    <div>
        <div class="subheader w-100 mb-4">
            <div class="row align-items-center">
                <div class="col-12 col-md-7">
                    <h1>Тексты в баннере</h1>
                </div>
                <div class="col-12 col-lg-5 text-end">
                    
                </div>
            </div>
        </div>

        <Loader v-if="views.loading" />

        <div v-if="!views.loading" class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
            <div class="w-100">
                <div v-if="mainbanners.length" class="box mb-4">
                    <table class="table">
                        <tbody>
                            <tr v-for="mainbanner in mainbanners" :key="mainbanner.id">
                                <td>
                                    <router-link :to="{name: 'MainBannerMaster', params: {id: mainbanner.id} }" class="text-decoration-none">
                                        {{ mainbanner.title }}
                                        <br><small class="text-muted">{{ mainbanner.subtitle }}</small>
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
            mainbanners: [],

            views: {
                loading: true,
            }
        }
    },
    created() {
        this.loadMainBanners()
    },
    methods: {
        loadMainBanners() {
            axios.get('/_admin/mainbanners')
            .then(response => {
                this.mainbanners = response.data

                this.views.loading = false
            })
        },
    },
    components: {
        Loader
    }
}
</script>