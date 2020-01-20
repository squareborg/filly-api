<template>
    <div>
        <div v-if="subscription" class="p-5">
            <h2 class="mb-3">An Affiliate would like to subscribe to your program channel</h2>
            <p>Approving them will allow them start publishing your programs and generating sales.</p>
            <table class="table mt-2">
                <tr><td>Name</td><td>{{subscription.affiliate.data.full_name}}</td></tr>
                <tr><td>Joined</td><td>May 2016</td></tr>
            </table>
            <approval-control
            @approved="subscription.approved = true; subscription.rejected"
            @unapproved="subscription.approved = false; subscription.rejected = false"
            @rejected="subscription.rejected = true; subscription.approved = false"
            @reasonChanged="reasonChanged"
            :init-approved="subscription.approved"
            :init-rejected="subscription.rejected"
            :init-rejected-reason="subscription.rejected_reason"
            class="mt-2">
            </approval-control>
            <img :src="subscription.logoImageUrl" />
            <div class="description mt-2">
                {{subscription.description}}
            </div>
            <div>
                <a class="btn btn-primary" href="#" @click="save">{{saveButtonText}}</a>
                <a class="btn btn-secondary" href="#" @click="closeModel">Cancel</a>
            </div>
        </div>
    </div>
</template>

<script>

import ApprovalControl from '../../components/Admin/ApprovalControl';

export default {
    props: [
        'initAffiliate'
    ],
    components:{
        ApprovalControl
    },
    data(){
        return {
            subscribed: false,
            subscription: null,
            inFlight: false,
        }
    },
    computed:{
        saveButtonText(){
            if (this.inFlight){
                return 'Please wait..'
            }
            return 'Save'
        }
    },
    methods:{

        save(){
            this.inFlight = true;
            axios.put(route('api.merchant.subscriptions.update', this.subscription.uuid),this.subscription)
            .then(response => {
                this.$emit('responded', this.subscription);
                this.$emit('closeModel');
            })
            .catch(error => {
                console.error(error);
            })
            .finally(()=>{
                this.inFlight = false;
            })
        },
        unsubscribe(){
            axios.delete(`${process.env.MIX_APP_URL}/api/subscriptions/${this.affiliate.subscribed_uuid}`)
                .then(response => {
                    this.refresh();
                });
        },
        reasonChanged(reason){
            this.affiliate.rejected_reason = reason;
        },

        closeModel(){
            this.$emit('closeModel');
        },

    },
    created(){
        this.subscription = this.initAffiliate;
    }
}
</script>
