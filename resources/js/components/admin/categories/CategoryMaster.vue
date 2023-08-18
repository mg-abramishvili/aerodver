<template>
    <div>
        <div class="subheader w-100 mb-3">
            <div class="row align-items-center">
                <div class="col-12">
                    <h1>
                        <template v-if="category.id">
                            <router-link :to="{name: 'Category', params: {id: category.id} }">Назад</router-link>
                            <span class="text-muted me-2">/</span>
                        </template>

                        <div class="d-block">
                            <template v-if="$route.params.id">{{ category.name }}</template>
                            <template v-if="!$route.params.id">Новая категория</template>
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
                            <div class="col-12 mb-4">
                                <label class="form-label">Символьный код (slug) <span @click="slugify(name)" class="link-primary">сгенерировать</span></label>
                                <input v-model="slug" type="text" class="form-control">
                            </div>
                            <div class="col-12 mb-4">
                                <label class="form-label">Описание</label>
                                <ckeditor :editor="editor" v-model="description" :config="editorConfig"></ckeditor>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label class="form-label">Родительская категория</label>
                                <select v-model="selected.parent" class="form-select">
                                    <template v-if="$route.params.id" v-for="cat in categories">
                                        <option v-if="cat.id != $route.params.id" :value="cat.id">{{ cat.name }}</option>
                                    </template>

                                    <template v-else v-for="cat in categories">
                                        <option :value="cat.id">{{ cat.name }}</option>
                                    </template>
                                </select>
                            </div>
                            <div class="col-12 col-lg-2">
                                <label class="form-label">Сортировка</label>
                                <input v-model="order" type="number" min="0" class="form-control">
                            </div>
                        </div>
                        
                    </div>
                </div>

                <div class="mb-3">
                    <div class="box mb-4 p-4">
                        <label class="form-label">Картинка</label>
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
            category: {},

            categories: [],

            name: '',
            name_eng: '',
            slug: '',
            description: '',
            order: 0,
            image: '',

            selected: {
                parent: '',
            },

            filepond_image: [],
            filepond_image_edit: [],

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
        this.loadCategories()

        if(this.$route.params.id) {
            this.loadCategory()
        } else {
            this.views.loading = false
        }
    },
    methods: {
        loadCategories() {
            axios.get('/_admin/categories')
            .then(response => {
                this.categories = response.data
            })
        },
        loadCategory() {
            axios.get(`/_admin/category/${this.$route.params.id}`)
            .then(response => {
                this.category = response.data

                this.name = response.data.name
                this.name_eng = response.data.name_eng
                this.slug = response.data.slug
                this.description = response.data.description
                this.order = response.data.order
                this.selected.parent = response.data.parent_id

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
            if(!this.slug) {
                return this.$swal({
                    text: 'Укажите символьный код',
                    icon: 'error',
                })
            }
            if(!this.image) {
                return this.$swal({
                    text: 'Укажите картинку',
                    icon: 'error',
                })
            }
            if(!this.order) {
                return this.$swal({
                    text: 'Укажите сортировку',
                    icon: 'error',
                })
            }

            this.views.saveButton = false

            if(this.$route.params.id) {
                axios.put(`/_admin/category/${this.$route.params.id}/update`, {
                    name: this.name,
                    name_eng: this.name_eng,
                    slug: this.slug,
                    description: this.description,
                    image: this.image,
                    order: this.order,
                    parent_id: this.selected.parent,
                })
                .then(response => {
                    if(response.data == 'slug error') {
                        return this.$swal({
                            text: 'Такой символьный код уже занят другой категорией',
                            icon: 'error',
                        })
                    }

                    this.views.saveButton = true

                    this.$router.push({ name: 'Category', params: {id: this.category.id} })
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
                axios.post('/_admin/categories', {
                    name: this.name,
                    name_eng: this.name_eng,
                    slug: this.slug,
                    description: this.description,
                    image: this.image,
                    order: this.order,
                    parent_id: this.selected.parent,
                })
                .then(response => {
                    if(response.data == 'slug error') {
                        return this.$swal({
                            text: 'Такой символьный код уже занят другой категорией',
                            icon: 'error',
                        })
                    }
                    
                    this.views.saveButton = true

                    this.$router.push({ name: 'Category', params: {id: response.data} })
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
        slugify(str) {
            var ru = {
                'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd', 
                'е': 'e', 'ё': 'e', 'ж': 'zh', 'з': 'z', 'и': 'i', 
                'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n', 'о': 'o', 
                'п': 'p', 'р': 'r', 'с': 's', 'т': 't', 'у': 'u', 
                'ф': 'f', 'х': 'kh', 'ц': 'ts', 'ч': 'ch', 'ш': 'sh', 
                'щ': 'shch', 'ы': 'y', 'э': 'e', 'ю': 'yu', 'я': 'ya'
            }, n_str = [];
            
            str = str.replace(/[ъь!|/|_\\'"<>/№;%:?*()@#$^&*+=,~.]+/g, '').replace(/й/g, 'i');

            for ( var i = 0; i < str.length; ++i ) {
                n_str.push(
                        ru[str[i]]
                    || ru[str[i].toLowerCase()] == undefined && str[i]
                    || ru[str[i].toLowerCase()]
                );
            }
            
            this.slug = n_str.join('').replace(/\s+/g, '-')
        },
    },
    components: {
        Loader,
        FilePond,
    }
}
</script>