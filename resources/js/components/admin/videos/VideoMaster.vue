<template>
    <div>
        <div class="subheader w-100 mb-3">
            <div class="row align-items-center">
                <div class="col-12">
                    <h1>
                        <router-link :to="{name: 'Videos' }">Назад</router-link>
                        <span class="text-muted me-2">/</span>

                        <div class="d-block">
                            <template v-if="$route.params.id">{{ video.name }}</template>
                            <template v-if="!$route.params.id">Новое видео</template>
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
                                <label class="form-label">Название (RUS)</label>
                                <input v-model="name" type="text" class="form-control">
                            </div>
                            <div class="col-12 col-lg-6 mb-4">
                                <label class="form-label">Название (ENG)</label>
                                <input v-model="name_eng" type="text" class="form-control">
                            </div>
                        </div>
                        
                    </div>
                </div>

                <div class="mb-3">
                    <div class="box mb-4 p-4">
                        <label class="form-label">Описание</label>
                        <ckeditor :editor="editor" v-model="description" :config="editorConfig"></ckeditor>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="box mb-4 p-4">
                        <label class="form-label">Описание (ENG)</label>
                        <ckeditor :editor="editor" v-model="description_eng" :config="editorConfig"></ckeditor>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="box mb-4 p-4">
                        <label class="form-label">Видео-файл</label>
                        <file-pond
                            name="video"
                            ref="video"
                            label-idle="Выбрать файл..."
                            v-bind:allow-multiple="false"
                            v-bind:allow-reorder="false"
                            accepted-file-types="video/mp4"
                            :server="server"
                            v-bind:files="filepond_video_edit"
                        />
                    </div>
                </div>

                <div class="mb-3">
                    <div class="box mb-4 p-4">
                        <label class="form-label">Картинка-обложка</label>
                        <file-pond
                            name="image"
                            ref="image"
                            label-idle="Выбрать картинку..."
                            v-bind:allow-multiple="false"
                            v-bind:allow-reorder="false"
                            accepted-file-types="image/jpeg, image/png"
                            :server="server"
                            v-bind:files="filepond_image_edit"
                        />
                    </div>
                </div>

                <button @click="save()" :disabled="!views.saveButton" class="btn btn-primary mb-4">Сохранить</button>
                <button @click="del()" class="btn btn-outline-danger mb-4 ms-1">Удалить видео</button>
            </div>
        </div>
    </div>
</template>

<script>
import Loader from '../Loader.vue'
import ClassicEditor from '@ckeditor/ckeditor5-build-classic'

import vueFilePond from "vue-filepond"
import "filepond/dist/filepond.min.css"
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css"
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type"
import FilePondPluginImagePreview from "filepond-plugin-image-preview"

const FilePond = vueFilePond(FilePondPluginFileValidateType, FilePondPluginImagePreview)

export default {
    data() {
        return {
            video: {},

            name: '',
            name_eng: '',
            description: '',
            description_eng: '',
            video: '',
            image: '',

            filepond_image: [],
            filepond_image_edit: [],

            filepond_video: [],
            filepond_video_edit: [],

            views: {
                loading: true,
                saveButton: true,
            },

            editor: ClassicEditor,
            editorData: '',
            editorConfig: {
                toolbar: [ 'heading', 'bold', '|', 'bulletedList', 'numberedList', '|', 'insertTable', '|', 'undo', 'redo' ],
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Тег P' },
                    ]
                },
            },

            server: {
                remove(filename, load) {
                    load('1');
                },
                process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                    const formData = new FormData();
                    formData.append(fieldName, file, file.name);
                    const request = new XMLHttpRequest();
                    request.open('POST', '/_admin/file/upload');
                    request.upload.onprogress = (e) => {
                        progress(e.lengthComputable, e.loaded, e.total);
                    };
                    request.onload = function() {
                        if (request.status >= 200 && request.status < 300) {
                            load(request.responseText);
                        }
                        else {
                            error('oh no');
                        }
                    };
                    request.send(formData);
                    return {
                        abort: () => {
                            request.abort();
                            abort();
                        }
                    };
                },
                revert: (filename, load) => {
                    load(filename)
                },
                load: (source, load, error, progress, abort, headers) => {
                    var myRequest = new Request(source);
                    fetch(myRequest).then(function(response) {
                        response.blob().then(function(myBlob) {
                            load(myBlob)
                        });
                    });
                },
            },
        }
    },
    created() {
        if(this.$route.params.id) {
            this.loadVideo()
        } else {
            this.views.loading = false
        }
    },
    methods: {
        loadVideo() {
            axios.get(`/_admin/video/${this.$route.params.id}`)
            .then(response => {
                this.video = response.data

                this.name = response.data.name
                this.name_eng = response.data.name_eng
                this.description = response.data.description
                this.description_eng = response.data.description_eng

                if(response.data.video) {
                    this.filepond_video_edit = [
                        {
                            source: response.data.video,
                            options: {
                                type: 'local',
                            }
                        }
                    ]
                }

                if(response.data.image) {
                    this.filepond_image_edit = [
                        {
                            source: response.data.image,
                            options: {
                                type: 'local',
                            }
                        }
                    ]
                }

                this.views.loading = false
            })
        },
        save() {
            if(document.getElementsByName("video")[0]) {
                this.video = document.getElementsByName("video")[0].value
            }

            if(document.getElementsByName("image")[0]) {
                this.image = document.getElementsByName("image")[0].value
            }

            if(!this.name) {
                return this.$swal({
                    text: 'Укажите название',
                    icon: 'error',
                })
            }
            if(!this.name_eng) {
                return this.$swal({
                    text: 'Укажите название на английском',
                    icon: 'error',
                })
            }
            if(!this.video) {
                return this.$swal({
                    text: 'Загрузите видео-файл',
                    icon: 'error',
                })
            }

            if(!this.image) {
                return this.$swal({
                    text: 'Загрузите картинку-обложку',
                    icon: 'error',
                })
            }

            this.views.saveButton = false

            if(this.$route.params.id) {
                axios.put(`/_admin/video/${this.$route.params.id}/update`, {
                    name: this.name,
                    name_eng: this.name_eng,
                    description: this.description,
                    description_eng: this.description_eng,
                    video: this.video,
                    image: this.image,
                })
                .then(response => {
                    this.views.saveButton = true

                    this.$router.push({ name: 'Videos' })
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
                axios.post('/_admin/videos', {
                    name: this.name,
                    name_eng: this.name_eng,
                    description: this.description,
                    description_eng: this.description_eng,
                    video: this.video,
                    image: this.image,
                })
                .then(response => {
                    this.views.saveButton = true

                    this.$router.push({ name: 'Videos' })
                })
                .catch(errors => {
                    this.views.saveButton = true
                    
                    return this.$swal({
                        text: 'Ошибка',
                        icon: 'error',
                    })
                })
            }
        },
        del() {
            axios.delete(`/_admin/video/${this.$route.params.id}/delete`)
            .then(response => {
                this.$router.push({ name: 'Videos' })
            })
            .catch(errors => {
                this.views.saveButton = true
                
                return this.$swal({
                    text: 'Ошибка',
                    icon: 'error',
                })
            })
        }
    },
    components: {
        Loader,
        FilePond,
    }
}
</script>