<template>
    <div>
        <div class="subheader w-100">
            <div class="row align-items-center">
                <div class="col-12 col-md-6">
                    <h1>Настройки Аудита и Аренды</h1>
                </div>
            </div>
        </div>

        <Loader v-if="views.loading" />

        <div v-if="!views.loading" class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
            <div class="w-100">
                <div class="box px-4 py-4 mb-4">
                    <div class="mb-4">
                        <label class="form-label">Текст для Аудита</label>
                        <ckeditor :editor="editor" v-model="energoaudit_text" :config="editorConfig"></ckeditor>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Картинка-иконка для Аудита</label>
                        <file-pond
                            name="energoaudit_icon"
                            ref="energoaudit_icon"
                            label-idle="Выбрать файл..."
                            v-bind:allow-multiple="false"
                            v-bind:allow-reorder="false"
                            accepted-file-types="image/jpeg, image/png"
                            :server="server"
                            v-bind:files="filepond_energoaudit_icon_edit"
                        />
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Фотки для Аудита</label>
                        <file-pond
                            name="energoaudit_gallery[]"
                            ref="energoaudit_gallery"
                            label-idle="Выбрать картинки..."
                            v-bind:allow-multiple="true"
                            v-bind:allow-reorder="true"
                            accepted-file-types="image/jpeg, image/png"
                            :server="server"
                            v-bind:files="filepond_energoaudit_gallery_edit"
                        />
                    </div>
                    
                    <button @click="save()" :disabled="!views.saveButton" class="btn btn-primary">Сохранить</button>
                </div>

                <div class="box px-4 py-4 mb-4">
                    <div class="mb-4">
                        <label class="form-label">Текст для Аренды</label>
                        <ckeditor :editor="editor" v-model="energoarenda_text" :config="editorConfig"></ckeditor>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Картинка-иконка для Аренды</label>
                        <file-pond
                            name="energoarenda_icon"
                            ref="energoarenda_icon"
                            label-idle="Выбрать файл..."
                            v-bind:allow-multiple="false"
                            v-bind:allow-reorder="false"
                            accepted-file-types="image/jpeg, image/png"
                            :server="server"
                            v-bind:files="filepond_energoarenda_icon_edit"
                        />
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Фотки для Аренды</label>
                        <file-pond
                            name="energoarenda_gallery[]"
                            ref="energoarenda_gallery"
                            label-idle="Выбрать картинки..."
                            v-bind:allow-multiple="true"
                            v-bind:allow-reorder="true"
                            accepted-file-types="image/jpeg, image/png"
                            :server="server"
                            v-bind:files="filepond_energoarenda_gallery_edit"
                        />
                    </div>
                    
                    <button @click="save()" :disabled="!views.saveButton" class="btn btn-primary">Сохранить</button>
                </div>
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
            energoaudit_text: '',
            energoaudit_gallery: '',
            energoaudit_icon: '',
            energoarenda_text: '',
            energoarenda_gallery: '',
            energoarenda_icon: '',

            filepond_energoaudit_gallery: [],
            filepond_energoaudit_gallery_edit: [],
            filepond_energoaudit_icon: [],
            filepond_energoaudit_icon_edit: [],

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
        this.loadSettings()
    },
    methods: {
        loadSettings() {
            axios.get('/_admin/settings')
            .then(response => {
                this.energoaudit_text = response.data.energoaudit_text
                this.energoarenda_text = response.data.energoarenda_text

                if(response.data.energoaudit_icon) {
                    this.filepond_energoaudit_icon_edit = [
                        {
                            source: response.data.energoaudit_icon,
                            options: {
                                type: 'local',
                            }
                        }
                    ]
                }

                if(response.data.energoaudit_gallery) {
                    this.filepond_energoaudit_gallery_edit = response.data.energoaudit_gallery.map(function(element){
                        {
                            return {
                                source: element,
                                options: {
                                    type: 'local',
                                }
                            } 
                        }
                    })
                }

                if(response.data.energoarenda_icon) {
                    this.filepond_energoarenda_icon_edit = [
                        {
                            source: response.data.energoarenda_icon,
                            options: {
                                type: 'local',
                            }
                        }
                    ]
                }

                if(response.data.energoarenda_gallery) {
                    this.filepond_energoarenda_gallery_edit = response.data.energoarenda_gallery.map(function(element){
                        {
                            return {
                                source: element,
                                options: {
                                    type: 'local',
                                }
                            } 
                        }
                    })
                }

                this.views.loading = false
            })
        },
        save() {
            if(document.getElementsByName("energoaudit_icon")[0]) {
                this.energoaudit_icon = document.getElementsByName("energoaudit_icon")[0].value
            }

            if(document.getElementsByName("energoarenda_icon")[0]) {
                this.energoarenda_icon = document.getElementsByName("energoarenda_icon")[0].value
            }

            if(document.getElementsByName("energoaudit_gallery[]")) {
                this.energoaudit_gallery = []
                document.getElementsByName("energoaudit_gallery[]").forEach((i) => {
                    if(i.value) {
                        this.energoaudit_gallery.push(i.value)
                    }
                })
            }

            if(document.getElementsByName("energoarenda_gallery[]")) {
                this.energoarenda_gallery = []
                document.getElementsByName("energoarenda_gallery[]").forEach((i) => {
                    if(i.value) {
                        this.energoarenda_gallery.push(i.value)
                    }
                })
            }

            if(!this.energoaudit_text) {
                return this.$swal({
                    text: 'Укажите текст энергоаудита',
                    icon: 'error',
                })
            }
            if(!this.energoaudit_icon) {
                return this.$swal({
                    text: 'Укажите иконку энергоаудита',
                    icon: 'error',
                })
            }
            if(!this.energoaudit_gallery) {
                return this.$swal({
                    text: 'Загрузите картинки энергоаудита',
                    icon: 'error',
                })
            }
            if(!this.energoarenda_text) {
                return this.$swal({
                    text: 'Укажите текст энергоаренды',
                    icon: 'error',
                })
            }
            if(!this.energoarenda_icon) {
                return this.$swal({
                    text: 'Укажите иконку энергоаренды',
                    icon: 'error',
                })
            }
            if(!this.energoarenda_gallery) {
                return this.$swal({
                    text: 'Загрузите картинки энергоаренды',
                    icon: 'error',
                })
            }

            this.views.saveButton = false

            axios.post('/_admin/settings-aa', {
                energoaudit_text: this.energoaudit_text,
                energoaudit_gallery: this.energoaudit_gallery,
                energoaudit_icon: this.energoaudit_icon,
                energoarenda_text: this.energoarenda_text,
                energoarenda_gallery: this.energoarenda_gallery,
                energoarenda_icon: this.energoarenda_icon,
            })
            .then(response => {
                this.views.saveButton = true

                this.$router.push({ name: 'Leads' })
            })
            .catch(errors => {
                this.views.saveButton = true
                
                return this.$swal({
                    text: 'Ошибка',
                    icon: 'error',
                })
            })
        },
    },
    components: {
        Loader,
        FilePond,
    }
}
</script>