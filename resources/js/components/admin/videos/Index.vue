<template>
    <div>
        <div class="subheader w-100 mb-4">
            <div class="row align-items-center">
                <div class="col-12 col-md-7">
                    <h1>VHS</h1>
                </div>
                <div class="col-12 col-lg-5 text-end">
                    <router-link :to="{name: 'VideoMaster'}" class="btn btn-primary">Добавить видео</router-link>
                </div>
            </div>
        </div>

        <Loader v-if="views.loading" />

        <div v-if="!views.loading" class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
            <div class="w-100">
                <div v-if="videos.length" class="box mb-4">
                    <table class="table">
                        <tbody>
                            <tr v-for="video in videos" :key="video.id">
                                <td style="width: 150px;">
                                    {{ $filters.date(video.created_at) }}
                                </td>
                                <td>
                                    <router-link :to="{name: 'VideoMaster', params: {id: video.id} }" class="text-decoration-none">
                                        {{ video.name }}
                                        <br><small class="text-muted">{{ video.name_eng }}</small>
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
            videos: [],

            views: {
                loading: true,
            }
        }
    },
    created() {
        this.loadVideos()
    },
    methods: {
        loadVideos() {
            axios.get('/_admin/videos')
            .then(response => {
                this.videos = response.data

                this.views.loading = false
            })
        },
    },
    components: {
        Loader
    }
}
</script>