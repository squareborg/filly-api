<template>
    <div>
        <modal height="auto" :adaptive="true" name="merchant-modal">
            <preview-merchant :merchant-id="previewMerchantId"></preview-merchant>
        </modal>
        <p v-if="!merchants">Loading...</p>
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
                    <a @click="selectFilterCategory(mc)" v-for="mc in merchantCategories" class="dropdown-item" href="#">{{mc.name}}</a>
                </div>
            </div>
        </div>

        <p v-if="merchants && !merchants.length">No merchants available</p>
        <table class="table table-striped mt-4 rounded bg-white shadow table-sm " v-if="merchants && merchants.length">
            <thead>
                <tr>
                    <th>Merchant Name</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="merchant in merchants">
                    <td>{{merchant.name}}</td>
                    <td><span v-if="merchant.merchant_category">{{merchant.merchant_category.data.name||""}}</span></td>
                    <td><a @click="show(merchant.uuid)" class="btn btn-secondary btn-sm" href="#">View</a> <span class="badge badge-pill badge-success" v-if="merchant.subscribed"> Subscribed</span></td>
                </tr>
            </tbody>
        </table>
        <pagination :per-page="perPage" :options="pageOptions" :records="serverTotal" @paginate="getResults"></pagination>

    </div>
</template>

<script>
export default {
    props: ['initMerchants', 'merchantCategories'],
    data(){
        return {
            merchants: null,
            previewMerchantId: null,
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
                return `&merchant_category_id=${this.filterCategory.id}`
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
            this.previewMerchantId = uuid;
            this.$modal.show('merchant-modal');
        },
        hide () {
            this.$modal.hide('hello-world');
        },
            // Our method to GET results from a Laravel endpoint
        getResults(page = 1) {
            axios.get(route('api.merchants.list')+`?page=${page}${this.queryString}`)
                .then(response => {
                    this.merchants = response.data.data;
                    this.serverPages = response.data.meta.pagination.total_pages;
                    this.serverTotal = response.data.meta.pagination.total;
                    this.perPage = response.data.meta.pagination.per_page;
                });
        }
    },
    created(){
        this.merchants = this.$props.initMerchants;
        // axios.get(route('api.merchantCategories.list'))
        //     .then(response =>{
        //          this.merchantCategories = response.data.data;
        //     });

        // axios.get(route('api.merchants.list'))
        //     .then(response => {
        //         this.merchants = response.data.data;
        //         this.serverPages = response.data.meta.pagination.total_pages;
        //         this.serverTotal = response.data.meta.pagination.total;
        //         this.perPage = response.data.meta.pagination.per_page;
        //     });
    }
}
</script>
