<template>
    <div>
        <h3 class="mb-3">Select a category</h3>
        <transition name="fade">
            <div v-if="programCategories.length > 0"  class="bg-grey-lightest p-3 rounded border">
            <span @click="selectCategory(pc)" v-for="pc in programCategories" class="program-category p-2 m-1">{{pc.name}}</span>
            </div>
        </transition>
        </div>
</template>
<script>
    export default {
        data(){
            return {
                programCategories: []
            }
        },
        created(){
            axios.get(route('api.programCategories.list'))
                .then(response => {
                    this.programCategories = response.data.data;
                });
        },
        methods: {
            selectCategory(category){
                this.$emit('selected', category);
            }
        }
    }
</script>

<style scoped>
    .program-category{
        border: 1px dashed;
        display: inline-block;
        cursor: pointer;
    }
    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s;
    }
    .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
        opacity: 0;
    }
</style>