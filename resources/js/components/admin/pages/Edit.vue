<template>
    <div>
        <div class="subheader w-100">
            <div class="row align-items-center">
                <div class="col-12 col-md-6">
                    <h1>{{ page.name }}</h1>
                </div>
            </div>
        </div>

        <Loader v-if="views.loading" />

        <div v-if="!views.loading" class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
            <div class="w-100">
                <div class="box px-4 py-4 mb-4">
                    <div class="mb-4">
                        <label class="form-label">Название</label>
                        <input v-model="name" type="text" class="form-control" disabled>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Контент</label>
                        <ckeditor :editor="editor" v-model="content" :config="editorConfig"></ckeditor>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Фотки</label>
                        <file-pond
                            name="gallery[]"
                            ref="gallery"
                            label-idle="Выбрать картинки..."
                            v-bind:allow-multiple="true"
                            v-bind:allow-reorder="true"
                            accepted-file-types="image/jpeg, image/png"
                            :server="server"
                            v-bind:files="filepond_gallery_edit"
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
            page: {},

            name: '',
            content: '',

            filepond_gallery: [],
            filepond_gallery_edit: [],

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
                    formData.append('watermark', 'w1');
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
        this.loadPage()
    },
    methods: {
        loadPage() {
            axios.get(`/_admin/page/${this.$route.params.id}`)
            .then(response => {
                this.page = response.data

                this.name = response.data.name
                this.content = response.data.content

                if(response.data.gallery) {
                    this.filepond_gallery_edit = response.data.gallery.map(function(element){
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
            if(document.getElementsByName("gallery[]")) {
                this.gallery = []
                document.getElementsByName("gallery[]").forEach((i) => {
                    if(i.value) {
                        this.gallery.push(i.value)
                    }
                })
            }

            if(!this.name) {
                return this.$swal({
                    text: 'Укажите name',
                    icon: 'error',
                })
            }
            if(!this.content) {
                return this.$swal({
                    text: 'Укажите content',
                    icon: 'error',
                })
            }

            this.views.saveButton = false

            axios.put(`/_admin/page/${this.$route.params.id}/update`, {
                name: this.name,
                content: this.content,
                gallery: this.gallery,
            })
            .then(response => {
                this.views.saveButton = true

                this.$router.push({ name: 'Pages' })
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