import './bootstrap'

import { createApp } from 'vue'
import router from './router'

import App from './components/admin/App.vue'

import VueSweetalert2 from 'vue-sweetalert2'
import 'sweetalert2/dist/sweetalert2.min.css'

import moment from 'moment'
import CKEditor from '@ckeditor/ckeditor5-vue'

const app = createApp(App)

app.config.globalProperties.$filters = {
    datetime(date) {
        return moment.utc(date).utcOffset(5).format('DD.MM.YYYY H:mm')
    },
    date(date) {
        return moment.utc(date).utcOffset(5).format('DD.MM.YYYY')
    },
}

app.use(router).use(VueSweetalert2).use(CKEditor).mount('#admin')