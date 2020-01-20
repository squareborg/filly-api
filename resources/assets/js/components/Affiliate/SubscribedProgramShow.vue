<template>
    <div>

        <div v-if="subscription">
            <h2 class="my-3">{{subscription.program.data.name}}</h2>
            <div class="row">
                <stat-card title="Clicks" :value="subscription.clicks" />
                <stat-card title="Sales" :value="subscription.sales" />
                <stat-card title="Revenue" :value="`£${subscription.revenue}`" />
            </div>
            <div class="row">
                <div class="rounded bg-white p-2 border mt-6">
                    <p class="mt-3">You can use the below affiliate links and images on your own site to promote this program</p>
                    <subscribed-program-links class="mt-4" :subscription-uuid="subscription.uuid" :program-uuid="subscription.program.data.uuid"></subscribed-program-links>
                </div>
                <div class="col-md-6">
                <h4 class="my-4">Danger Zone</h4>
                    <div class="rounded bg-white p-4 border">
                        <a @click="destroySubscription" href="#" class="btn btn-danger text-white"><b><i class="fa fa-trash"></i> Unsubscribe from program</b></a>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="!subscription">
            Loading...
        </div>
    </div>
</template>
<script>
    import swal from 'sweetalert';
    import AffiliateStats from "./AffiliateStats";
export default {
    components: {AffiliateStats},
    props:[
        'programUuid',
        'name'
    ],
    data(){
        return {
            subscription: null
        }
    },
    methods:{
        refresh(){
            axios.get(`${process.env.MIX_APP_URL}/api/subscriptions/${this.$props.programUuid}`)
                .then(response => {
                    this.subscription = response.data.data
                });
        },
        save(){
            axios.put(`${process.env.MIX_APP_URL}/api/subscriptions/${this.program.uuid}`, this.program)
            .then(respone=>{
                this.subscription = respone.data.data
            })
        },
        destroySubscription() {
            console.log("in destroy")
            swal({
                title: "Are you sure?",
                text: `You will not be able to recover this subscription`,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) this.sendDestroySubscriptionRequest();
            });
        },
        sendDestroySubscriptionRequest(){
            console.log("in send destroy")

            axios.delete(route(`api.subscriptions.destroy`, this.subscription.uuid))
                .then(response => {
                    window.location.href = route('affiliate.home');
                })
                .catch(error => {
                    console.log(error);
                })
        }

    },
    created(){
        this.refresh();
    }
}
</script>

