<template>
    <div>
        <div class="subheader w-100 mb-3">
            <div class="row align-items-center">
                <div class="col-12">
                    <h1>
                        <router-link :to="{name: 'MainBanners' }">Назад</router-link>
                        <span class="text-muted me-2">/</span>

                        <div class="d-block">
                            <template v-if="$route.params.id">{{ mainbanner.name }}</template>
                            <template v-if="!$route.params.id">Новый текст в баннер</template>
                        </div>
                    </h1>
                </div>
            </div>
        </div>

        <Loader v-if="views.loading" />

        <div v-if="!views.loading" class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
            <div class="w-100">
                <div class="mb-3">
                    <div class="box mb-4 p-4">
                        <div class="row">
                            <div class="col-12 col-lg-6 mb-4">
                                <label class="form-label">Заголовок (RUS)</label>
                                <input v-model="title" type="text" class="form-control">
                            </div>
                            <div class="col-12 col-lg-6 mb-4">
                                <label class="form-label">Подзаголовок (RUS)</label>
                                <input v-model="subtitle" type="text" class="form-control">
                            </div>
                            <div class="col-12 col-lg-6 mb-4">
                                <label class="form-label">Заголовок (RUS)</label>
                                <input v-model="title_eng" type="text" class="form-control">
                            </div>
                            <div class="col-12 col-lg-6 mb-4">
                                <label class="form-label">Подзаголовок (ENG)</label>
                                <input v-model="subtitle_eng" type="text" class="form-control">
                            </div>
                        </div>
                        
                    </div>
                </div>

                <button @click="save()" :disabled="!views.saveButton" class="btn btn-primary mb-4">Сохранить</button>
            </div>
        </div>
    </div>
</template>

<script>
import Loader from '../Loader.vue'

import vueFilePond from "vue-filepond"
import "filepond/dist/filepond.min.css"
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css"
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type"
import FilePondPluginImagePreview from "filepond-plugin-image-preview"

const FilePond = vueFilePond(FilePondPluginFileValidateType, FilePondPluginImagePreview)

export default {
    data() {
        return {
            mainbanner: {},

            title: '',
            title_eng: '',
            subtitle: '',
            subtitle_eng: '',

            views: {
                loading: true,
                saveButton: true,
            },
        }
    },
    created() {
        if(this.$route.params.id) {
            this.loadMainBanner()
        } else {
            this.views.loading = false
        }
    },
    methods: {
        loadMainBanner() {
            axios.get(`/_admin/mainbanner/${this.$route.params.id}`)
            .then(response => {
                this.mainbanner = response.data

                this.title = response.data.title
                this.title_eng = response.data.title_eng
                this.subtitle = response.data.subtitle
                this.subtitle_eng = response.data.subtitle_eng

                this.views.loading = false
            })
        },
        save() {
            if(!this.title) {
                return this.$swal({
                    text: 'Укажите заголовок',
                    icon: 'error',
                })
            }
            if(!this.title_eng) {
                return this.$swal({
                    text: 'Укажите заголовок на английском',
                    icon: 'error',
                })
            }

            this.views.saveButton = false

            if(this.$route.params.id) {
                axios.put(`/_admin/mainbanner/${this.$route.params.id}/update`, {
                    title: this.title,
                    title_eng: this.title_eng,
                    subtitle: this.subtitle,
                    subtitle_eng: this.subtitle_eng,
                })
                .then(response => {
                    this.views.saveButton = true

                    this.$router.push({ name: 'MainBanners' })
                })
                .catch(errors => {
                    this.views.saveButton = true
                    
                    return this.$swal({
                        text: 'Ошибка',
                        icon: 'error',
                    })
                })
            }

            if(!this.$route.params.id) {
                axios.post('/_admin/mainbanners', {
                    title: this.title,
                    title_eng: this.title_eng,
                    subtitle: this.subtitle,
                    subtitle_eng: this.subtitle_eng,
                })
                .then(response => {
                    this.views.saveButton = true

                    this.$router.push({ name: 'MainBanners' })
                })
                .catch(errors => {
                    this.views.saveButton = true
                    
                    return this.$swal({
                        text: 'Ошибка',
                        icon: 'error',
                    })
                })
            }

            
        }
    },
    components: {
        Loader,
        FilePond,
    }
}
</script>