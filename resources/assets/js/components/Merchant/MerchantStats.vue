<template>
    <div class="row">
        <div class="col-3 stat-card">
            <h3>Total Sales</h3> <span class="score">{{sales||0}}</span>
        </div>
        <div class="col-3 stat-card">
            <h3>Total Clicks</h3> <span class="score">{{clicks||0}}</span>
        </div>
        <div class="col-3 stat-card">
            <h3>Revenue</h3> <span class="score">£{{clicks||0}}</span>
        </div>
    </div>
</template>
<script>
export default {
    props:[
        'affiliates',
        'clicks',
        'sales',
    ],
    data(){
        return {
        }
    },
    methods:{
    },
    created(){
    }
}
</script>

