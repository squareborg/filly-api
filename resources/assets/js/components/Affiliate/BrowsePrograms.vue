<template>
    <div>
        <modal height="auto" :adaptive="true" name="program-modal">
            <preview-program :program-id="previewProgramId"></preview-program>
        </modal>
        <p v-if="!programs">Loading...</p>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">Filter By</label>
            </div>
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span v-if="filterCategory">{{filterCategory.name}}</span>
                    <span v-if="!filterCategory">Category</span>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a @click="clearFilterCategory" class="dropdown-item" href="#">All</a>
                    <a @click="selectFilterCategory(pc)" v-for="pc in programCategories" class="dropdown-item" href="#">{{pc.name}}</a>
                </div>
            </div>
        </div>

        <p v-if="programs && !programs.length">No programs available, try subscribing to some Merchant program channels</p>
        <table class="table mt-4 rounded bg-white border table " v-if="programs && programs.length">
            <thead>
                <tr>
                    <th>Program Name</th>
                    <th>Merchant</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="program in programs">
                    <td>{{program.name}}</td>
                    <td>{{program.merchant.data.name}}</td>
                    <td><span v-if="program.program_category">{{program.program_category.data.name||""}}</span></td>
                    <td><a @click="show(program.uuid)" class="btn btn-secondary btn-sm" href="#">View</a> <span class="badge badge-pill badge-success" v-if="program.subscribed"> Subscribed</span></td>
                </tr>
            </tbody>
        </table>
        <pagination :per-page="perPage" :options="pageOptions" :records="serverTotal" @paginate="getResults"></pagination>

    </div>
</template>

<script>
export default {
    props: ['initPrograms', 'programCategories'],
    data(){
        return {
            programs: null,
            previewProgramId: null,
            perPage: null,
            serverTotal: 0,
            pageOptions: {
                theme: "bootstrap4"
            },
            filterCategory: null
        }
    },
    computed:{
        queryString(){
            if (this.filterCategory){
                return `&program_category_id=${this.filterCategory.id}`
            }
            else {
                return ""
            }
        }
    },
    methods: {
        clearFilterCategory(){
            this.filterCategory = null;
            this.getResults();
        },
        selectFilterCategory(category){
            this.filterCategory = category;
            this.getResults();
        },
        show (uuid) {
            this.previewProgramId = uuid;
            this.$modal.show('program-modal');
        },
        hide () {
            this.$modal.hide('hello-world');
        },
            // Our method to GET results from a Laravel endpoint
        getResults(page = 1) {
            axios.get(route('api.programs.list')+`?page=${page}${this.queryString}`)
                .then(response => {
                    this.programs = response.data.data;
                    this.serverPages = response.data.meta.pagination.total_pages;
                    this.serverTotal = response.data.meta.pagination.total;
                    this.perPage = response.data.meta.pagination.per_page;
                });
        }
    },
    created(){
        this.programs = this.$props.initPrograms;
        // axios.get(route('api.programCategories.list'))
        //     .then(response =>{
        //          this.programCategories = response.data.data;
        //     });

        // axios.get(route('api.programs.list'))
        //     .then(response => {
        //         this.programs = response.data.data;
        //         this.serverPages = response.data.meta.pagination.total_pages;
        //         this.serverTotal = response.data.meta.pagination.total;
        //         this.perPage = response.data.meta.pagination.per_page;
        //     });
    }
}
</script>
