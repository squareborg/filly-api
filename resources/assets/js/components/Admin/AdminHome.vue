<template>
    <div>
        <div>

        </div>
    </div>
</template>

<script>
export default {
    data(){
        return {
            autoApprove: null,
            currentTab: 'users'
        }
    },
    methods:{
        setTab(tab){
            this.currentTab = tab;
        }
    },
    created(){
        Echo.channel('sales')
        .listen('ProgramSale', (e) => {
            console.log(e.sale);
        });
    }
}
</script>
