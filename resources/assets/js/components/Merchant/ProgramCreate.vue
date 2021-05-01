<template>
    <div>
        <div class="row xfil-card">

            <div class="col border-right">
                <img src="/images/empty_state.png">
            </div>
            <div class="col d-flex flex-column flex-wrap justify-content-center align-content-center">
                <span class="program-title rounded mb-2">Lets give it a name</span>
                <div class="form-group">
                    <input v-model="program.name" required id="name" type="text" class="form-control" placeholder="eg. Super Widget 9000">
                </div>
                <button @click="save" type="submit" class="btn btn-primary"><i class="fa fa-chevron-right"></i> Continue</button>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return {
            program: {}
        }
    },
    methods:{
        save(){
            axios.post(`${process.env.MIX_APP_URL}/api/programs`, {
                "name": this.program.name
            })
            .then(response=>{
                window.location.href = `${process.env.MIX_APP_URL}/merchant/programs/${response.data.data.uuid}/edit`
            })
            .catch(function(error) {
            })
        }
    },
    mounted(){

    }
}
</script>

