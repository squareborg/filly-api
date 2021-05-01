<template>
    <div>
        <div v-if="program" class="p-5">
            <h2>{{program.name}}</h2>
            <div class="description mt-2">
                {{program.description}}
            </div>
            <a v-if="!program.subscribed" @click="subscribe" href="#" class="btn btn-primary mt-4">Subscribe</a>
            <div class="mt-4" v-if="program.subscribed">
                <a @click="unsubscribe" href="#" class="btn btn-danger">Unsubscribe</a>
                <span class="">View in <a class="text-danger font-weight-bold" :href="'/affiliate/program/'+program.subscribed_uuid">my programs</a></span>
            </div>

        </div>

    </div>
</template>

<script>
export default {
    props: [
        'programId'
    ],
    data(){
        return {
            subscribed: false,
            program: null
        }
    },
    methods:{
        refresh(){
            axios.get(`${process.env.MIX_APP_URL}/api/programs/${this.$props.programId}`)
                .then(response => {
                    this.program = response.data.data
                });
        },
        subscribe(){
            axios.post(`${process.env.MIX_APP_URL}/api/programs/${this.$props.programId}/subscribe`)
                .then(response => {
                    this.refresh();
                });
        },
        unsubscribe(){
            axios.delete(`${process.env.MIX_APP_URL}/api/subscriptions/${this.program.subscribed_uuid}`)
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
