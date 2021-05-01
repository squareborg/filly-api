<template>
<div>
    <div class="btn-group border">
    <button v-if="initApproved" type="button" class="btn btn-success">Approved</button>
    <button v-if="!initApproved && !initRejected" type="button" class="btn btn-warning">Unapproved</button>
    <button v-if="initRejected && !initApproved" type="button" class="btn btn-danger">Rejected</button>

    <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="caret"></span>
        <span class="sr-only">Toggle Dropdown</span>
    </button>
    <div class="dropdown-menu">
       <a class="dropdown-item" v-if="initApproved || initRejected" v-on:click="unapproveClicked" href="#">Unapprove</a>
        <a class="dropdown-item" v-if="!initApproved || initRejected" v-on:click="approvedClicked">Approve</a>
        <a class="dropdown-item" v-if="!initRejected"  v-on:click="rejectClicked">Reject</a>
    </div>
    </div>
    <input @keyup="reasonChanged" placeholder="Rejected Reason" v-model="rejectedReason" type="text" v-if="initRejected" >
</div>
</template>
<script>

    export default {
    data() {
      return {
          rejectedReason: null
      }
    },
    props: [
        'initApproved',
        'initRejected',
        'initRejectedReason'
    ],
    components: {
    },
    methods: {
        approvedClicked: function(){
            this.$emit('updated', 'approved')
        },
        unapproveClicked: function(){
            this.$emit('updated', 'unapproved')
        },
        rejectClicked: function(){
            this.$emit('updated', 'rejected')
        },
        reasonChanged: function(){
            this.$emit('reasonChanged', this.rejectedReason)
        }

    },
}
</script>
