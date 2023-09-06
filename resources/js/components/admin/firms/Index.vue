<template>
    <div>
        <div class="subheader w-100 mb-4">
            <div class="row align-items-center">
                <div class="col-12 col-md-7">
                    <h1>Компании</h1>
                </div>
                <div class="col-12 col-lg-5 text-end">
                    <router-link :to="{name: 'FirmMaster'}" class="btn btn-primary me-2">Добавить компанию</router-link>
                </div>
            </div>
        </div>

        <Loader v-if="views.loading" />

        <div v-if="!views.loading" class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
            <div class="w-100">
                <div v-if="firms.length" class="box mb-4">
                    <table class="table">
                        <tbody>
                            <tr v-for="firm in firms" :key="firm.id">
                                <td>
                                    <router-link :to="{name: 'FirmMaster', params: {id: firm.id} }" class="text-decoration-none">
                                        {{ firm.name }}
                                    </router-link>
                                </td>
                                <td>
                                    {{  firm.city.name  }}
                                </td>
                                <td>
                                    <template v-if="firm.is_audit == true">аудит</template>
                                    <template v-if="firm.is_arenda == true">аренда</template>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <p v-else>Раздел пуст.</p>
            </div>
        </div>
    </div>
</template>

<script>
import Loader from '../Loader.vue'

export default {
    data() {
        return {
            firms: [],

            views: {
                loading: true,
            }
        }
    },
    created() {
        this.loadFirms()
    },
    methods: {
        loadFirms() {
            axios.get('/_admin/firms')
            .then(response => {
                this.firms = response.data

                this.views.loading = false
            })
        },
    },
    components: {
        Loader
    }
}
</script>