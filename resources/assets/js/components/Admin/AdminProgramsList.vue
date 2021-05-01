<template>
    <div>
        <table v-if="programs.length > 0" class="table border bg-white mt-2">
            <thead>
                <th>
                    Name
                </th>
                <th>
                    Actions
                </th>

            </thead>
            <tbody>
                <tr v-for="program in programs">
                    <td>{{program.name}}</td>
                    <td><a class="btn btn-secondary" :href="'/merchant/programs/'+program.uuid+'/edit'">Manage</a><button @click="deleteProgram(program.uuid)" class="btn btn-danger"><i class="fa fa-trash"></i></button> </td>
                </tr>
            </tbody>
        </table>
        <!--<pagination :per-page="perPage" :options="pageOptions" :records="serverTotal" @paginate="setPage"></pagination>-->
    </div>
</template>

<script>
import {Pagination} from 'vue-pagination-2';
import swal from 'sweetalert';
export default {
    data(){
        return{
            programs: [],
            page: 0,
            pageOptions: {
              theme: "bootstrap4"
            },
            serverPages: 0,
        }
    },
    components:{
        Pagination
    },

    created(){
        this.refresh();
    },
    methods:{
        refresh(){
            axios.get(`${process.env.MIX_APP_URL}/api/programs`)
                .then(response=>{
                    this.programs = response.data.data;
                    this.serverPages = response.data.meta.pagination.total_pages;
                    this.serverTotal = response.data.meta.pagination.total;
                    this.perPage = response.data.meta.pagination.per_page;
                });
        },
        deleteProgram(programUUID){
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this imaginary file!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        console.log(route('api.program.destroy', programUUID));
                        axios.delete(route('api.program.destroy', programUUID))
                        .then(response =>{
                            swal("Poof! Your imaginary file has been deleted!", {
                                icon: "success",
                            });
                            this.refresh();
                        })
                        .catch(error =>{
                            console.log(error);
                        });
                    }
                });

        },
        setPage: function(page) {
            this.page = page;
            axios.get(`${process.env.MIX_APP_URL}/api/programs?page=${this.page}`)
            .then(response =>{
                this.programs = response.data.data;
                this.serverPages = response.data.meta.pagination.total_pages;
                this.serverTotal = response.data.meta.pagination.total;
                this.perPage = response.data.meta.pagination.per_page;
            })
        },
    }
}
</script>
