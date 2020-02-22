<template>
<div>
    <div class="flex flex-row">
        <div class="mr-2">
            Auto Approve new affiliates
        </div> 
        <div>
            <label class="switch"><input @change="updateAutoApprove"  type="checkbox" name=""  v-model="merchant.auto_approve_affiliates"> <span class="slider round"></span></label>

        </div>
    </div>
    
<div v-if="queue.length">
        <modal height="auto" :adaptive="true" name="affiliate-modal">
            <approve-affiliate  @responded="responded" @closeModel="closeModel" :init-affiliate="previewAffiliate"></approve-affiliate>
        </modal>
        <p class="mb-2" v-if="queue.length">You have {{queue.length}} affiliates awaiting your approval</p>
        <ul>
            <li v-for="affiliate in queue">{{affiliate.affiliate.data.full_name}} <a @click="show(affiliate)" href="#">view</a></li>
        </ul>
    </div>
    <div v-if="queue && !queue.length">
        No affiliates to approve right now.
    </div>
</div>

</template>
<script>

import axios from 'axios';
import ApproveAffiliate from './ApproveAffiliate';
export default {
    props:['merchant'],

    data(){
        return {
            queue: [],
            previewAffiliate: null,
            autoApprove: false
        }
    },
    components: {
        ApproveAffiliate
    },
    mounted(){
        axios.get(route('api.merchants.affiliates.approvalqueue'))
        .then(response => {
            this.queue = response.data.data
        })
    },
    methods: {
        responded(affiliate){
            let index = this.queue.findIndex(item =>{
                return item.uuid === affiliate.uuid;
            })
            this.queue.splice(index, 1);
        },
        show (affiliate) {
            this.previewAffiliate = affiliate;
            this.$modal.show('affiliate-modal');
        },
        closeModel(){
            this.$modal.hide('affiliate-modal');
        },
        updateAutoApprove(event){
            axios.put(route('api.merchants.update', this.merchant.uuid ), {
                auto_approve_affiliates: this.merchant.auto_approve_affiliates
            })
            .then(response => {
                
            })
            console.log(event.target.value);
            console.log(this.autoApprove);
        }
    }
}
</script>

