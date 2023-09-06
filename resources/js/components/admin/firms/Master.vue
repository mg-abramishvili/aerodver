<template>
    <div>
        <div class="subheader w-100 mb-3">
            <div class="row align-items-center">
                <div class="col-12">
                    <h1>
                        <router-link :to="{name: 'Firms' }">Назад</router-link>
                        <span class="text-muted me-2">/</span>

                        <div class="d-block">
                            <template v-if="$route.params.id">{{ firm.name }}</template>
                            <template v-if="!$route.params.id">Новая компания</template>
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
                            <div class="col-12 col-lg-4 mb-4">
                                <label class="form-label">Название (RUS)</label>
                                <input v-model="name" type="text" class="form-control">
                            </div>
                            <div class="col-12 col-lg-4 mb-4">
                                <label class="form-label">Название (ENG)</label>
                                <input v-model="name_eng" type="text" class="form-control">
                            </div>
                            <div class="col-12 col-lg-4 mb-4">
                                <label class="form-label">Город</label>
                                <select v-model="selected.city" class="form-select">
                                    <option v-for="city in cities" :value="city.id">{{ city.name }}</option>
                                </select>
                            </div>
                            <div class="col-12 col-lg-4 mb-4">
                                <label class="form-label">Адрес</label>
                                <input v-model="address" type="text" class="form-control">
                            </div>
                            <div class="col-12 col-lg-4 mb-4">
                                <label class="form-label">Телефон</label>
                                <input v-model="tel" type="text" class="form-control">
                            </div>
                            <div class="col-12 col-lg-4 mb-4">
                                <label class="form-label">WhatsApp</label>
                                <input v-model="whatsapp" type="text" class="form-control">
                            </div>
                            <div class="col-12 col-lg-4 mb-4">
                                <label class="form-label">Цена (от)</label>
                                <input v-model="price" type="number" class="form-control">
                            </div>
                            <div class="col-12 col-lg-8 mb-4">
                                <label class="form-label">Услуги</label>
                                <div class="form-check form-check-inline">
                                    <input v-model="is_audit" class="form-check-input" type="checkbox" value="audit" id="audit">
                                    <label class="form-check-label" for="audit">
                                        аудит
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input v-model="is_arenda" class="form-check-input" type="checkbox" value="arenda" id="arenda">
                                    <label class="form-check-label" for="arenda">
                                        аренда
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="box mb-4 p-4">
                        <div class="form-check">
                            <input type="radio" id="w1" v-model="watermark" value="w1" class="form-check-input">
                            <label for="w1" class="form-check-label">Водяной знак (сильнее)</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" id="w2" v-model="watermark" value="w2" class="form-check-input">
                            <label for="w2" class="form-check-label">Водяной знак (слабее)</label>
                        </div>
                        <p class="text-muted mb-4"><small>При изменении водяного знака, все фотки придется загружать заново!</small></p>

                        <label class="form-label">Фотки</label>
                        <file-pond
                            name="firm_gallery[]"
                            ref="firm_gallery"
                            label-idle="Выбрать картинки..."
                            v-bind:allow-multiple="true"
                            v-bind:allow-reorder="true"
                            accepted-file-types="image/jpeg, image/png"
                            :server="server"
                            v-bind:files="filepond_firm_gallery_edit"
                        />
                    </div>
                </div>

                <div class="mb-3">
                    <div class="box mb-4 p-4">
                        <label class="form-label">Описание</label>
                        <ckeditor :editor="editor" v-model="description" :config="editorConfig"></ckeditor>
                    </div>
                </div>

                <button @click="save()" :disabled="!views.saveButton" class="btn btn-primary mb-4">Сохранить</button>
                <button @click="del()" :disabled="!views.saveButton" class="btn btn-outline-danger ms-2 mb-4">Удалить</button>
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
            firm: {},

            name: '',
            name_eng: '',
            address: '',
            tel: '',
            whatsapp: '',
            price: 0,
            firm_gallery: '',

            is_audit: false,
            is_arenda: false,

            cities: [],

            selected: {
                city: '',
            },

            filepond_firm_gallery: [],
            filepond_firm_gallery_edit: [],

            watermark: 'w1',

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
                    formData.append('watermark', this.watermark);
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
        this.loadCities()

        if(this.$route.params.id) {
            this.loadFirm()
        } else {
            this.views.loading = false
        }
    },
    methods: {
        loadCities() {
            axios.get('/_admin/cities')
            .then(response => {
                this.cities = response.data
            })
        },
        loadFirm() {
            axios.get(`/_admin/firm/${this.$route.params.id}`)
            .then(response => {
                this.firm = response.data
                
                this.selected.city = response.data.city_id

                this.name = response.data.name
                this.name_eng = response.data.name_eng
                this.address = response.data.address
                this.tel = response.data.tel
                this.whatsapp = response.data.whatsapp
                this.price = response.data.price
                this.description = response.data.description
                this.description2 = response.data.description2
                
                if(response.data.is_audit == 1) {
                    this.is_audit = true
                }
                if(response.data.is_arenda == 1) {
                    this.is_arenda = true
                }

                if(response.data.gallery) {
                    this.filepond_firm_gallery_edit = response.data.gallery.map(function(element){
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
            if(document.getElementsByName("firm_gallery[]")) {
                this.firm_gallery = []
                document.getElementsByName("firm_gallery[]").forEach((i) => {
                    if(i.value) {
                        this.firm_gallery.push(i.value)
                    }
                })
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
            if(!this.selected.city) {
                return this.$swal({
                    text: 'Укажите город',
                    icon: 'error',
                })
            }
            if(!this.address) {
                return this.$swal({
                    text: 'Укажите адрес',
                    icon: 'error',
                })
            }
            if(!this.tel) {
                return this.$swal({
                    text: 'Укажите телефон',
                    icon: 'error',
                })
            }

            this.views.saveButton = false

            if(this.$route.params.id) {
                axios.put(`/_admin/firm/${this.$route.params.id}/update`, {
                    city_id: this.selected.city,
                    name: this.name,
                    name_eng: this.name_eng,
                    address: this.address,
                    tel: this.tel,
                    whatsapp: this.whatsapp,
                    price: this.price,
                    description: this.description,
                    gallery: this.firm_gallery,
                    is_audit: this.is_audit,
                    is_arenda: this.is_arenda,
                })
                .then(response => {
                    this.views.saveButton = true

                    this.$router.push({ name: 'Firms' })
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
                axios.post('/_admin/firms', {
                    city_id: this.selected.city,
                    name: this.name,
                    name_eng: this.name_eng,
                    address: this.address,
                    tel: this.tel,
                    whatsapp: this.whatsapp,
                    price: this.price,
                    description: this.description,
                    gallery: this.firm_gallery,
                    is_audit: this.is_audit,
                    is_arenda: this.is_arenda,
                })
                .then(response => {
                    this.views.saveButton = true

                    this.$router.push({ name: 'Firms' })
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
            if (confirm("Точно удалить?")) {
                axios.delete(`/_admin/firm/${this.firm.id}/delete`)
                .then((response => {
                    this.$router.push({ name: 'Firms' })
                }))
            }
        },
    },
    components: {
        Loader,
        FilePond,
    }
}
</script>