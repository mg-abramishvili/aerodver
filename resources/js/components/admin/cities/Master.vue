<template>
    <div>
        <div class="subheader w-100 mb-3">
            <div class="row align-items-center">
                <div class="col-12">
                    <h1>
                        <router-link :to="{name: 'Cities' }">Назад</router-link>
                        <span class="text-muted me-2">/</span>

                        <div class="d-block">
                            <template v-if="$route.params.id">{{ city.name }}</template>
                            <template v-if="!$route.params.id">Новый город</template>
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
                            <div class="col-12 col-lg-6 mb-4">
                                <label class="form-label">Символьный код</label>
                                <input v-model="slug" type="text" class="form-control">
                            </div>
                        </div>
                        
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

export default {
    data() {
        return {
            city: {},

            name: '',
            name_eng: '',
            slug: '',

            views: {
                loading: true,
                saveButton: true,
            },
        }
    },
    created() {
        if(this.$route.params.id) {
            this.loadCity()
        } else {
            this.views.loading = false
        }
    },
    methods: {
        loadCity() {
            axios.get(`/_admin/city/${this.$route.params.id}`)
            .then(response => {
                this.city = response.data

                this.name = response.data.name
                this.name_eng = response.data.name_eng
                this.slug = response.data.slug

                this.views.loading = false
            })
        },
        save() {
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

            this.views.saveButton = false

            if(this.$route.params.id) {
                axios.put(`/_admin/city/${this.$route.params.id}/update`, {
                    name: this.name,
                    name_eng: this.name_eng,
                    slug: this.slug,
                })
                .then(response => {
                    this.views.saveButton = true

                    this.$router.push({ name: 'Cities' })
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
                axios.post('/_admin/cities', {
                    name: this.name,
                    name_eng: this.name_eng,
                    slug: this.slug,
                })
                .then(response => {
                    this.views.saveButton = true

                    this.$router.push({ name: 'Cities' })
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
                axios.delete(`/_admin/city/${this.city.id}/delete`)
                .then((response => {
                    this.$router.push({ name: 'Cities' })
                }))
                .catch(errors => {
                    this.views.saveButton = true
                    
                    return this.$swal({
                        text: errors.response.data,
                        icon: 'error',
                    })
                })
            }
        },
    },
    components: {
        Loader,
    }
}
</script>