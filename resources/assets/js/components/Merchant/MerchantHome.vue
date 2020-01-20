<template>
    <div>
        <div class="row" v-if="merchantPrograms.length">
            <stat-card title="Clicks" :value="totalClicks" />
            <stat-card title="Sales" :value="totalSales" />
        </div>
        <ul class="nav nav-pills my-3">
                <li @click="setTab('dashboard')" class="nav-item">
                    <a v-bind:class="{ 'bg-brand-primary': currentTab==='dashboard' }" class="nav-link" href="#">Merchant Dashboard</a>
                </li>
                <li @click="setTab('profile')" class="nav-item">
                    <a v-bind:class="{ 'bg-brand-primary': currentTab==='profile' }" class="nav-link" href="#">Merchant Profile</a>
                </li>
                <li @click="setTab('affiliates')" class="nav-item">
                    <a v-bind:class="{ 'bg-brand-primary': currentTab==='affiliates' }" class="nav-link" href="#">Affiliate Approvals</a>
                </li>
            </ul>
        <div v-if="currentTab ==='profile'">
            <merchant-edit :init-merchant="merchant"></merchant-edit>
        </div>
        <div v-if="!merchantPrograms.length && currentTab==='dashboard'" class="row xfil-card">
            <div class="col border-right">
                <img src="images/empty_state.png">
            </div>
            <div class="col d-flex flex-column flex-wrap justify-content-center align-content-center">You have not created any programs.<br>
                <a href="/merchant/programs/create" class="btn btn-primary mt-2"><i class="fa fa-plus"></i>New Program</a>
                <a href="/merchant/link/woocommerce" style="background-color: #96588a;" class="btn btn-danger mt-1"><i class="fa fa-shopping-cart"></i> Link <b>Woo</b>commerce</a>

            </div>
        </div>
        <div v-if="currentTab === 'affiliates'">
            <affiliate-approval-queue :merchant="merchant" :affiliates="affiliates"></affiliate-approval-queue>
        </div>
        <div v-if="currentTab === 'dashboard'">
 <div v-if="merchantPrograms.length">
        <a href="/merchant/programs/create" class="btn btn-primary my-3"><i class="fa fa-plus "></i> New Program</a>
        <programs-list  :programs="merchantPrograms"></programs-list>

        </div>
        </div>
       
            </div>
</template>

<script>
    import AffiliateApprovalQueue from './AffiliateApprovalQueue';
    export default {
    components:{
        AffiliateApprovalQueue
    },
    props: ['totalClicks', 'totalSales', 'merchantPrograms', 'merchant'],
    data(){
        return {
            currentTab: "dashboard"
        }
    },
    methods:{
        setTab(tab){
            this.currentTab = tab;
        }
    }
}
</script>
