<template>
<div>
    <table class="table border bg-white mt-2">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Roles</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="user in users" v-bind:key="user.id">
                <td>{{user.full_name}}</td>
                <td>{{user.email}}</td>
                <td>
                    <ul id="roles-list" v-if="user.roles">
                        <li v-for="role in user.roles.data" v-bind:key="role.id">{{role.name}}</li>
                    </ul>
                </td>
                <td>
                    <a class="btn btn-default" :href="'/admin/users/'+user.id">Manage</a>
                </td>
            </tr>
        </tbody>
    </table>
    <pagination :per-page="perPage" :options="pageOptions" :records="serverTotal" @paginate="setPage" ></pagination>

</div>
</template>

<script>
import {Pagination} from 'vue-pagination-2';

export default {
    data(){
        return{
            page: 0,
            users: ['jeff'],
            pageOptions: {
              theme: "bootstrap3"
            },
            serverPages: 0,
            perPage: 0,
            serverTotal: 0
        }
    },
    components: {
        Pagination
    },
    methods: {
        setPage: function(page) {
            this.page = page;
            axios.get(`${process.env.MIX_APP_URL}/api/users?page=${this.page}`)
            .then(response =>{
                this.users = response.data.data;
                this.serverPages = response.data.meta.pagination.total_pages;
                this.serverTotal = response.data.meta.pagination.total;
                this.perPage = response.data.meta.pagination.per_page;
            })
        },
    },
    created(){
        axios.get(`${process.env.MIX_APP_URL}/api/users`)
        .then(response =>{
            this.users = response.data.data;
            this.serverPages = response.data.meta.pagination.total_pages;
            this.serverTotal = response.data.meta.pagination.total;
            this.perPage = response.data.meta.pagination.per_page;
        })

    }
}
</script>

<style scoped>
    #roles-list {
        padding: 0;
    }
    #roles-list li{
        list-style-type: none;
    }
</style>

