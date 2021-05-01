<template>
    <div>
        <div v-if="merchant" class="p-5">
            <h2>{{merchant.name}}</h2>
            <img :src="merchant.logoImageUrl" />
            <div class="description mt-2">
                {{merchant.description}}
            </div>
            <a @click="subscribe" href="#" class="btn btn-primary mt-4">{{applyText}}</a>
            <div class="mt-4" v-if="merchant.subscribed">
                <a @click="unsubscribe" href="#" class="btn btn-danger">Unsubscribe</a>
                <span class="">View in <a class="text-danger font-weight-bold" :href="'/affiliate/merchant/'+merchant.subscribed_uuid">my merchants</a></span>
            </div>

        </div>

    </div>
</template>

<script>
export default {
    props: [
        'merchantId'
    ],
    data(){
        return {
            subscribed: false,
            merchant: null
        }
    },
    computed:{
        applyText(){
            switch(this.merchant.subscription_status){
                case 'requested':
                return 'Applied'
                case 'approved':
                return 'Subscribed'
                case 'rejected':
                return 'Applied'
                default:
                return this.merchant.auto_approve_affiliates ? 'Subscribe' : 'Apply';
            }
        },
    },
    methods:{

        refresh(){
            axios.get(`${process.env.MIX_APP_URL}/api/merchants/${this.$props.merchantId}`)
                .then(response => {
                    this.merchant = response.data.data
                });
        },
        subscribe(){
            console.log('sub');
            
            if(this.merchant.subscription_status === 'none'){
                 axios.post(`${process.env.MIX_APP_URL}/api/merchants/${this.$props.merchantId}/subscribe`)
                .then(response => {
                    this.refresh();
                });
            }

        },
        unsubscribe(){
            axios.delete(`${process.env.MIX_APP_URL}/api/subscriptions/${this.merchant.subscribed_uuid}`)
                .then(response => {
                    this.refresh();
                });
        }
    },
    created(){
        this.refresh();
    }
}
</script>
