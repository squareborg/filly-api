<template>
    <div>
        <div v-if="program" >
            <div class="row">
                <stat-card title="Affiliates" :value="program.affiliates_count" />
                <stat-card title="Clicks" :value="program.clicks" />
                <stat-card title="Sales" :value="program.sales.data.length" />
            </div>
            <ul class="nav nav-pills my-3">
                <li class="nav-item">
                    <a @click="setTab('edit')" class="nav-link" v-bind:class="{ 'bg-brand-primary': currentTab==='edit'}" href="#">Edit</a>
                </li>
                <li class="nav-item">
                    <a @click="setTab('sales')" class="nav-link" v-bind:class="{ 'bg-brand-primary': currentTab==='sales'}" href="#">Sales</a>
                </li>
                <li class="nav-item">
                    <a @click="setTab('woocom')" class="nav-link" v-bind:class="{ 'bg-brand-primary': currentTab==='woocom'}" href="#">Woo Commerce</a>
                </li>
            </ul>

            <form v-if="currentTab === 'edit'" class="p-4 bg-white rounded shadow" v-on:submit.prevent action="/merchant/programs/store" method="post">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="name">Program Name</label>
                            <input v-model="program.name" required id="name" type="text" class="form-control" placeholder="Program Name">
                        </div>
                    </div>
                    <div class="col text-right">
                            <label for="name">Approval</label>
                            <div v-if="!admin">
                                <span class="badge badge-warning p-2" v-if="!program.approved && !program.rejected">
                                    Awaiting approval
                                </span>
                                <span class="badge badge-success p-2" v-if="program.approved">
                                    Approved
                                </span>
                                <span class="badge badge-danger p-2" v-if="program.rejected">
                                    Rejected {{program.rejected_reason}}
                                </span>
                            </div>
                            <div v-else>
                                <approval-control
                                v-on:updated="approvalUpdated"
                                @reasonChanged="program.rejected_reason = $event"
                                :item="program"
                                :init-approved="program.approved"
                                :init-rejected="program.rejected"
                                :init-rejected_reason="program.rejected_reason"
                                style="display:inline" >
                            </approval-control>

                            </div>
                    </div>
                </div>

                <program-catergories-list class="mt-4" v-if="!program.program_category_id" @selected="updateSelectedProgramCategory"></program-catergories-list>
                <div class="mt-4" v-if="program.program_category">
                    <b>Category:</b> {{program.program_category.data.name}} <a href="#" @click.prevent="program.program_category_id = null" class="small"><em>Change</em></a>
                </div>

                <div class="form-group mt-5">
                    <label for="name">Link to product</label>
                    <input v-model="program.link" required id="link" type="text" class="form-control" placeholder="eg. http://myshop.com/product/1">
                </div>
                <div class="form-group">
                    <label>Product description</label>
                    <textarea v-model="program.description" class="form-control" rows="3"></textarea>
                 </div>
                <h4 class="mt-4">Program Images</h4>
                <program-media-upload @newUpload="refresh" :program-uuid="programUuid"></program-media-upload>
                <table v-if="program.media.data.length > 0" class="table table-striped">
                    <thead>
                    <tr><th>Media</th><th>Action</th></tr>
                    </thead>
                    <tbody>
                    <tr v-for="media in this.program.media.data">
                        <td><img height="50" :src="media.filepath" /></td><td><button @click="deleteMedia(media.uuid)" class="btn btn-danger">Delete</button></td>
                    </tr>
                    </tbody>
                </table>
                <label class="mt-2"><b>Affiliate Reward</b></label>
                <p>Award an affiliate a percentage of the total sale </p>
                <div class="input-group mb-3 mt-2">
                <input pattern="[0-9][0-9]?[0-9]?" size="3" maxlength="3" v-model="program.program_reward" type="text"  class="border p3 text-center" aria-label="Amount (to the nearest dollar)">
                <div class="input-group-append">
                    <span class="input-group-text">.00 %</span>
                </div>
                </div>
                <button @click="save" type="submit" class="btn btn-primary mt-8">Save</button>
            </form>
        </div>
        <div v-if="!program">
            Loading...
        </div>
        <div v-if="currentTab === 'sales'" class="rounded bg-white p-6 mt-3 shadow">
            <h3>Sales</h3>

            <div v-if="program.sales.data.length">
            <table class="table table-striped mt-6">
                <thead>
                    <tr>
                        <th>Your Order ID</th><th>Order Date</th><th>Our reference</th>
                    </tr>
                </thead>
                <tbody>
                <tr v-for="sale in program.sales.data">
                    <td>{{sale.order_id}}</td>
                    <td>{{sale.created_at}}</td>
                    <td>{{sale.uuid}}</td>
                </tr>
                </tbody>
            </table>
        </div>

        <div v-if="!program.sales.data.length">
            No sales just yet.
        </div>
        </div>
        <div v-if="currentTab === 'woocom'">
            To link this program to a Woocommerce site add your program id to the product data attributes.
            <ul>
                <li>Download and install our <a href="/xfil-wc.zip">Woo Commerce plugin</a></li>
                <li>On the corresponding product in your shop, create a non visible custom product attribute. <br> <b>name: </b><pre>xfil</pre> <b>value: </b><pre>{{program.uuid}}</pre></li>
            </ul>
        </div>
    </div>

</template>
<script>
    import ProgramCatergoriesList from '../Programs/ProgramCatergoriesList';
export default {
    props:[
        'programUuid',
        'name',
        'admin'
    ],
    components:{
        ProgramCatergoriesList
    },
    data(){
        return {
            program: null,
            selectedCategory: "",
            currentTab: 'edit',
        }
    },
    methods:{
        approvalUpdated: function (event) {
            switch(event){
                case 'unapproved':
                    this.program.approved = false;
                    this.program.rejected = false;
                    break
                case 'approved':
                    this.program.approved = true;
                    this.program.rejected = false;
                    break
                case 'rejected':
                    this.program.approved = false;
                    this.program.rejected = true;
                    break
            }
        }, 

        setTab(tab){
            this.currentTab = tab;
        },
        updateSelectedProgramCategory(category){
            this.program.program_category_id = category.id;
            this.program.program_category.data = category;
            this.selectedCategory = category;
        },
        deleteMedia(mediaUuid){
            axios.delete(route('api.programs.media.delete',{ program: this.programUuid, programMedia: mediaUuid}))
            .then(()=>{
                this.refresh();
            })
            .catch((error)=>{
            })
        },
        refresh(){
            axios.get(`${process.env.MIX_APP_URL}/api/programs/${this.$props.programUuid}`)
                .then(response => {
                    this.program = response.data.data
            });
        },
        save(){
            axios.put(`${process.env.MIX_APP_URL}/api/programs/${this.program.uuid}`, this.program)
            .then(respone=>{
                this.program = respone.data.data;
                this.$notify({
                    type: 'success',
                    group: 'main',
                    title: 'Saved Program',
                    text: "Saved Program",
                });
            })
        }
    },
    created(){
        this.refresh();
    }
}
</script>

