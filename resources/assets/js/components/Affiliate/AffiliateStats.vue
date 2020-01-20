<template>
    <div class="row my-5">
        <div class="">
            <div class="stat-card">
            <h3>Total Sales</h3> <span class="score">{{sales||0}}</span>
            </div>
        </div>
        <div class="">
            <div class="stat-card">
            <h3>Total Clicks</h3> <span class="score">{{clicks||0}}</span>
            </div>
        </div>
        <div class="">
            <div class="stat-card">
            <h3>Revenue</h3> <span class="score">£{{revenue||0}}</span>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props:[
        'clicks',
        'sales',
        'revenue'
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

