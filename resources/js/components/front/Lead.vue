<template>
    <div class="lead-form">
        <div v-if="views.error" class="alert alert-danger">
            <small v-for="error in errors" class="d-block">
                {{ error }}
            </small>
        </div>

        <div v-if="views.success" class="alert alert-success">
            Заявка успешно отправлена!
        </div>

        <div class="row">
            <div class="col-12 mb-4">
                <label class="fw-bold">Имя</label>
                <input v-model="name" type="text" class="form-control" placeholder="Как вас зовут">
            </div>
            <div class="col-12 mb-4">
                <label class="fw-bold">Телефон</label>
                <input v-model="tel" type="text" class="form-control" placeholder="Ваш номер телефона">
            </div>
        </div>
        <div class="form-check mb-4">
            <input v-model="policy" class="form-check-input" type="checkbox" :id="'check_'">
            <label class="form-check-label" :for="'check_'">
                Согласен с обработкой персональных данных
                <a href="/policy" target="_blank">(!)</a>
            </label>
        </div>
        <button @click="save()" class="btn btn-primary">Оформить</button>
    </div>
</template>

<script>
export default {
    data() {
        return {
            name: '',
            tel: '',
            policy: false,
            errors: [],
            views: {
                success: false,
                error: false,
            }
        }
    },
    methods: {
        save() {
            this.views.error = false

            this.errors = []

            if(!this.name) {
                this.errors.push('Укажите имя')
            }
            if(!this.tel) {
                this.errors.push('Укажите телефон')
            }
            if(!this.policy) {
                this.errors.push('Нужно согласиться с обработкой персональных данных')
            }
            if(this.errors.length > 0) {
                this.views.error = true
                return
            }
            
            axios.post('/_leads', {
                name: this.name,
                tel: this.tel,
            })
            .then(response => {
                this.name = ''
                this.tel = ''
                this.policy = false
    
                this.views.success = true
    
                setTimeout(() => {
                    this.views.success = false
                }, 3000)
            })
        }
    }
}
</script>