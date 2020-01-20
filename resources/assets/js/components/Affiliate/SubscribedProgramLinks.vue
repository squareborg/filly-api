<template>
    <div>
            <table class="table table-striped">
                 <td>Link only</td>
                 <td>
                        <button class="btn btn-primary"
                            v-clipboard:copy="getLink(subscriptionUuid)"
                            v-clipboard:success="onCopy"
                            v-clipboard:error="onError">
                        Copy html
                        </button>
                    </td>
                <tr v-for="item in media">
                    <td><img height="50" :src="item.filepath" /></td>
                    <td>
                        <button class="btn btn-primary"
                            v-clipboard:copy="getImageLink(subscriptionUuid, item.filepath)"
                            v-clipboard:success="onCopy"
                            v-clipboard:error="onError">
                        Copy html
                        </button>
                    </td>
                </tr>
            </table>
    </div>
</template>
<script>
export default {
    props:[
        'subscriptionUuid',
        'programUuid',
    ],
    data(){
        return {
            media: null
        }
    },
    methods:{
        refresh(){
            axios.get(`${process.env.MIX_APP_URL}/api/programs/${this.$props.programUuid}/media`)
                .then(response => {
                    this.media = response.data.data
                });
        },
        save(){
            axios.put(`${process.env.MIX_APP_URL}/api/subscriptions/${this.program.uuid}`, this.program)
            .then(respone=>{
                this.subscription = respone.data.data
            })
        },
        onCopy: function (e) {
            //alert('You just copied: ' + e.text)
            this.$notify({
                        type: 'success',
                        group: 'main',
                        title: 'Copied to clipboard',
                        text: "Copied to clipboard",
                    });
        },
        onError: function (e) {
        alert('Failed to copy texts')
        },
        getImageLink(subscriptionUuid, img){
            return `<a href="http://xfil-network.test/in/${subscriptionUuid}"><img src="${img}" /></a>`
        },
        getLink(subscriptionUuid){
            return `<a href="http://xfil-network.test/in/${subscriptionUuid}">link</a>`
        }
    },
    created(){
        this.refresh();
    }
}
</script>

