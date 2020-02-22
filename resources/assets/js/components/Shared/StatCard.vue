<template>
    <div class="stat-card">
        <h3>{{title}}</h3> 
        <span class="score">{{value}}</span>       
    </div>
</template>
<script>
export default {
    props:[
        'title',
        'value',
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

