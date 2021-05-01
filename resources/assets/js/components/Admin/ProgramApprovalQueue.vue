<template>
<div>

</modal>

    <div class="row">
        <span v-if="autoApprove !==null" class="switch mt-4 mb-4">
            <input @change="updateAutoApprove" v-model="autoApprove" type="checkbox" class="switch" id="switch-id">
            <label for="switch-id">Automatic approval</label>
        </span>
    </div>
    <div class="mt-3" v-if="!approvalQueueLoaded">
        Loading...
    </div>
        <div v-if="programsQueue && programsQueue.length" >
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Created</th>
                        <th>
                            <button @click="approveAll" class="btn btn-outline btn-sm fg-white"><i class="fa fa-check"></i> Approve All</button>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(program, index) in programsQueue" :key="program.id">
                        <td>{{program.name}}</td>
                        <td>{{program.created_at}}</td>
                        <td>
                            <a :href="'/admin/programs/'+program.id"> <button class="btn btn-primary">Manage</button></a>
                            <approval-control
                                v-on:updated="approvalUpdated(index, $event)"
                                @reasonChanged="program.rejected_reason = $event"
                                :item="program"
                                :init-approved="program.approved"
                                :init-rejected="program.rejected"
                                :init-rejected_reason="program.rejected_reason"
                                style="display:inline" >
                            </approval-control>
                            <button @click="saveProgram(program, index)" v-show="program.shouldSave===true" class="btn btn-success">Save</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <pagination :per-page="10" :options="pageOptions" :records="serverPages" @paginate="setPage" ></pagination>   

        </div>

        <div class="mt-3" v-if="approvalQueueLoaded && programsQueue && !programsQueue.length">
            <p class="font-weight-bold">The approval queue is empty</p>
        </div>
</div>

</template>

<script>
import {Pagination} from 'vue-pagination-2';
    export default {
    data() {
      return {
          programsQueue: [],
          pageOptions: {
              theme: "bootstrap3"
          },
          page: 1,
          serverPages: 1,
          modalWidth: 0,
          modalHeight: 0,
          approvalQueueLoaded: false,
          autoApprove: false
      }
    },
    components: {
        Pagination,
    },
    methods: {
        approveAll(){
            axios.post(route('api.programs.approveAll'), {})
            .then(response => {
                this.programsQueue = response.data.data;
            });
        },
        updateAutoApprove(){
            axios.put(route('api.setting.update', 'program_auto_approve'), {'value': this.autoApprove})
                .then(response =>{
                    this.autoApprove = response.data.data.value
                });
        },
        approvalUpdated: function (index, event) {
            switch(event){
                case 'unapproved':
                    this.programsQueue[index].approved = false;
                    this.programsQueue[index].rejected = false;
                    break
                case 'approved':
                    this.programsQueue[index].approved = true;
                    this.programsQueue[index].rejected = false;
                    break
                case 'rejected':
                    this.programsQueue[index].approved = false;
                    this.programsQueue[index].rejected = true;
                    break
            }
            this.programsQueue[index].shouldSave = true;
        },
        saveProgram: function (program, index) {
            axios.put(`${process.env.MIX_APP_URL}/api/programs/${program.uuid}`, {
                "approved": program.approved,
                "rejected": program.rejected,
                "rejected_reason": program.rejected_reason
            })
                .then(response => {
                    program.shouldSave = false;
                    this.programsQueue.splice(index, 1);
                });
        },
        setPage: function (page) {
            this.page = page;
        },
        },
        created(){
            axios.get(route('api.setting.show', 'program_auto_approve'))
                .then(response =>{
                    if(response.data.data.value ==="0"){
                        response.data.data.value = false;
                    }
                    if(response.data.data.value ==="1"){
                        response.data.data.value = true;
                    }
                    this.autoApprove = response.data.data.value
                });
            axios.get(`${process.env.MIX_APP_URL}/api/programs/unapproved`)
            .then(response => {
                this.serverPages = response.data.meta.pagination.count;
                response.data.data.forEach(program => {
                    program.shouldSave = false;
                });
                this.programsQueue = response.data.data;
                this.approvalQueueLoaded = true;
            });
        }
}
</script>

<style scoped>
    
</style>