<template>
    <div>
        <div class="subheader w-100 mb-4">
            <div class="row align-items-center">
                <div class="col-12 col-md-7">
                    <h1>Заявки</h1>
                </div>
                <div class="col-12 col-lg-5">
                    
                </div>
            </div>
        </div>

        <Loader v-if="views.loading" />

        <div v-if="!views.loading" class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
            <div class="w-100">
                <div v-if="leads.length" class="box mb-4">
                    <table class="table">
                        <tbody>
                            <tr v-for="lead in leads" :key="lead.id">
                                <td>
                                    {{ $filters.date(lead.created_at) }}
                                </td>
                                <td>
                                    {{ lead.subject }}
                                </td>
                                <td>
                                    Имя: {{ lead.name }}<br>Телефон: {{ lead.tel }}
                                </td>
                                <td>
                                    <ul v-if="lead.order">
                                        <li v-for="cartItem in lead.order">
                                            - {{ cartItem.name }} ({{ cartItem.quantity }} шт)
                                        </li>
                                    </ul>
                                </td>
                                <td>
                                    <button @click="del(lead.id)" class="btn btn-outline-danger">&times;</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <p v-else>Заявок нет.</p>
            </div>
        </div>
    </div>
</template>

<script>
import Loader from '../Loader.vue'

export default {
    data() {
        return {
            leads: [],

            views: {
                loading: true,
            }
        }
    },
    created() {
        this.loadLeads()
    },
    methods: {
        loadLeads() {
            axios.get('/_admin/leads')
            .then(response => {
                this.leads = response.data

                this.views.loading = false
            })
        },
        del(id) {
            if (confirm("Точно удалить?")) {
                axios.delete(`/_admin/lead/${id}/delete`)
                .then((response => {
                    this.loadLeads()
                }))
            }
        }
    },
    components: {
        Loader
    }
}
</script>