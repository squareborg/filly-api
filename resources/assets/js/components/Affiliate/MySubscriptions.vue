<template>
    <div>
        <p v-if="theSubscriptions && !theSubscriptions.length">You are not subscribed to any programs</p>
        <p v-if="!theSubscriptions">Loading...</p>
        <table class="table border rounded bg-white" v-if="theSubscriptions && theSubscriptions.length">
            <thead>
                <tr>
                    <th>Subscription Name</th>
                    <th>Sales</th>
                    <th>Clicks</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="subscription in theSubscriptions">
                    <td>{{subscription.program.data.name}}</td>
                    <td>{{subscription.sales}}</td>
                    <td>{{subscription.clicks}}</td>
                    <td><a class="btn btn-secondary" :href="'/affiliate/program/'+subscription.uuid">Manage</a></td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    props: ['subscriptions'],
    data(){
        return {
            theSubscriptions: null
        }
    },
    created(){
        this.theSubscriptions = this.$props.subscriptions;
    }
}
</script>
