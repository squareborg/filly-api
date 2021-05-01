<template>
    <div>
        <div v-if="!availableRoles">
            Loading ...
        </div>
        <div v-if="availableRoles">
            <div v-bind:key="availableRole.id" v-for="availableRole in availableRoles">
                <input v-bind:disabled="disabled" @change="updated()" :value="availableRole.id" v-model="selectedRoles" type="checkbox" />
                <label>{{availableRole.name}}</label>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                availableRoles: null,
                selectedRoles: []
            }
        },
        props:{
            'initial': {
                type: Array,
                default: function(){
                    return Array();
                }
            },
            'readOnly': {
                type: Boolean,
                default: false
            }
        },
        methods: {
            updated: function(){
                this.$emit('update', this.selectedRoles)
            }
        },
        computed: {
            disabled: function(){
                if (this.$props.readOnly){
                    return "disabled"
                }
                return null
            }
        },
        created() {
            this.$props.initial.forEach(element => {
                this.selectedRoles.push(element);
            });
            axios.get(`${process.env.MIX_APP_URL}/api/roles`)
            .then(response => {
                this.availableRoles = response.data.data
            })
        }
    }
</script>
