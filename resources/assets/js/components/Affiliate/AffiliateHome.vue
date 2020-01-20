<template>
    <div>
        <div>
            <div class="row">
                <stat-card title="Clicks" :value="totalClicks" />
                <stat-card title="Sales" :value="totalSales" />
            </div>
            <ul class="nav nav-pills my-3">
                <li @click="setTab('mySubscriptions')" class="nav-item">
                    <a v-bind:class="{ 'bg-brand-primary': currentTab==='mySubscriptions' }" class="nav-link" href="#">My Subscriptions</a>
                </li>
                <li @click="setTab('browsePrograms')" class="nav-item">
                    <a v-bind:class="{ 'bg-brand-primary': currentTab==='browsePrograms' }" class="nav-link" href="#">Browse Programs</a>
                </li>
                <li @click="setTab('browseMerchants')" class="nav-item">
                    <a v-bind:class="{ 'bg-brand-primary': currentTab==='browseMerchants' }" class="nav-link" href="#">Browse Merchants</a>
                </li>
            </ul>
            <div v-if="currentTab ==='mySubscriptions'">
                <div v-if="!subscriptions.length" class="rounded bg-white shadow">
                    <div  class="row mt-3 border rounded shadow xfil-card">
                    <div class="col border-right">
                    <img src="images/empty_state.png">
                    </div>
                    <div class="col d-flex flex-column flex-wrap justify-content-center align-content-center">You're not subscribed to any programs yet, try browsing our collection.<br>
                    <a href="#" @click="setTab('browsePrograms')" class="btn btn-primary mt-2"><i class="fa fa-list"></i> Browse Programs</a>
                    </div>
                    </div>
                 </div>
                    <my-subscriptions class="mt-3" v-if="subscriptions.length" :subscriptions="subscriptions"></my-subscriptions>

            </div>
            <div v-if="currentTab ==='browsePrograms'">
                <h2 class="my-3">Browse Programs</h2>
                <div class="">
                    <browse-programs :program-categories="programCategories" :init-programs="programs"></browse-programs>
                </div>
            </div>
            <div v-if="currentTab ==='browseMerchants'">
                <h2 class="my-3">Browse Merchants</h2>
                <div class="">
                    <browse-merchants :merchant-categories="programCategories" :init-merchants="merchants"></browse-merchants>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import AffiliateStats from './AffiliateStats';
export default {
    components: {
        AffiliateStats
    },
    props:[
        'totalClicks',
        'totalSales',
        'subscriptions',
        'programs',
        'programCategories',
        'merchants'
    ],
    data(){
        return {
            currentTab: 'mySubscriptions'
        }
    },
    methods:{
        setTab(tab){
            this.currentTab = tab;
        }
    }
}
</script>
