import './bootstrap'

import { createApp } from 'vue'
import mitt from 'mitt'

import Lead from './components/front/Lead.vue'
import AddToCart from './components/front/AddToCart.vue'
import MiniCart from './components/front/MiniCart.vue'
import Cart from './components/front/Cart.vue'

const emitter = mitt()

const app = createApp({})

app.component('create-lead', Lead)
app.component('add-to-cart', AddToCart)
app.component('minicart', MiniCart)
app.component('cart', Cart)

app.config.globalProperties.emitter = emitter
app.mount('#front')