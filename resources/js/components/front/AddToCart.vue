<template>
    <div>
        <a v-if="cart && cart.find(i => i.id == product)" href="/cart" class="btn btn-standard">В корзине</a>
        
        <button v-else @click="add()" class="btn btn-standard">Добавить в корзину</button>
    </div>
</template>

<script>
    export default {
        props: ['product'],
        data() {
            return {
                cart: [],

                views: {
                    loading: true,
                },
            };
        },
        mounted() {
            this.getCartInfo()
        },
        methods: {
            getCartInfo() {
                axios.get('/_cart_data')
                .then(response => {
                    this.cart = response.data

                    this.views.loading = false

                    this.emitter.emit('cart', response.data)
                })
            },
            add() {
                axios.post(`/add-to-cart/${this.product}`)
                .then(response => {
                    this.getCartInfo()
                })
            },
        },
    }
</script>