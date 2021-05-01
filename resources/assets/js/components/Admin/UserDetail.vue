<template>
<div>
            <v-dialog/>

<div v-if="user">
    <div class="container">
    <a class="btn btn-primary pull-right" :href="'/admin/users/'+user.id+'/edit'" v-if="this.$props.readOnly">Edit</a>
    <a @click="save" class="btn btn-primary " v-if="readOnly ===false"><i class="fa fa-save"></i> Save</a>
    <a @click="deleteUser" class="btn btn-danger " v-if="readOnly ===false"><i class="fa fa-trash"></i> Delete</a>
    <div class="row">
  		<div class="col-sm-10"><h1>{{user.name}}</h1></div>
    </div>
    <div class="row">
  		<div class="col-sm-3"><!--left col-->
               
        </div><!--/col-3-->
    	<div class="col-sm-9">
            
          <div class="tab-content">
            <div class="tab-pane active" id="home">
                <hr>
                  <form ref="userform" class="form" action="##" method="post" id="registrationForm">
                      <div class="form-group">
                          <div class="col-xs-6">
                              <label for="name"><h4>Name</h4></label>
                              <input pattern=".{1,}" required  v-bind:disabled="disabled" type="text" v-model="user.name" class="form-control" name="first_name" id="first_name" placeholder="Full name" title="Full name">
                          </div>
                      </div>
                  
                      <div class="form-group">
                          
                          <div class="col-xs-6">
                              <label for="email"><h4>Email</h4></label>
                              <input required v-bind:disabled="disabled" v-model="user.email" type="email" class="form-control" name="email" id="email" placeholder="you@email.com" title="enter your email.">
                          </div>
                      </div>
                       
                      <div class="col-xs-12">
                          <h3>Roles</h3>
                        <roles-list :read-only="this.$props.readOnly" :initial="user.roles" v-on:update="roleUpdated" /> 
                      </div>
              	</form>
              
              <hr>
              
             </div>        
              </div>
          </div>
        </div>
    </div>
</div>
</div>
</template>

<script>
 
export default {
    data(){
        return{
            user: null
        }
    },
    props:{
        'userId': {
            type: Number,
            default: []
        },
        'readOnly': {
            type: Boolean,
            default: false
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
    methods: {
       roleUpdated(roles){
           this.user.roles = roles
       },
       locationUpdated(location){
           this.user.profile.data.country.id = location;
       },
       save(){
           if(this.$refs.userform.reportValidity()){
                axios.put(`${process.env.MIX_APP_URL}/api/users/${this.$props.userId}`,{
                    "name": this.user.name,
                    "email": this.user.email,
                    "roles": this.user.roles
                })
                .then(response =>{
                    this.$notify({
                    type: 'success',
                    group: 'main',
                    title: 'Saved',
                    text: 'Saved user profile'
                    });
                })
            }
       },
       deleteUser: function(){
            this.$modal.show('dialog', {
                title: 'Delete?',
                text: 'Are you sure you want to delete this user?',
                buttons: [
                    {
                        title: 'Yes delete',
                        handler: () => {
                            axios.delete(`${process.env.MIX_APP_URL}/api/users/${this.user.id}`)
                            .then(()=>{
                                window.location.href = `${process.env.MIX_APP_URL}/admin/users/`;
                            })
                        }
                    },
                    {
                        title: '',       // Button title
                        default: true,    // Will be triggered by default if 'Enter' pressed.
                        handler: () => {} // Button click handler
                    },
                    {
                    title: 'Cancel'
                    }
                ]
            })
        },
    },
    created(){
        axios.get(`${process.env.MIX_APP_URL}/api/users/${this.$props.userId}`)
        .then(response =>{
            this.user = response.data.data;
            var roles = Array();
            this.user.roles.data.forEach(role => {
                roles.push(role.id)
            });
            this.user.roles = roles;
           
        })
        
    }
}
</script>
<style scoped>
</style>

