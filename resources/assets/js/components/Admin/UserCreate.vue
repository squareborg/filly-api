<template>
<div>
            <v-dialog/>

<div>
    <div class="container">
    <a @click="save" class="btn btn-primary "><i class="fa fa-save"></i> Save</a>
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
                              <label for="name"><h4>First Name</h4></label>
                              <input pattern=".{1,}" required type="text" v-model="user.first_name" class="form-control" name="first_name" id="first_name" placeholder="First name" title="Full name">
                          </div>
                      </div>
                      <div class="form-group">
                          <div class="col-xs-6">
                              <label for="name"><h4>Last Name</h4></label>
                              <input required type="text" v-model="user.last_name" class="form-control" name="first_name" id="first_name" placeholder="Last name" title="Full name">
                          </div>
                      </div>
                      <div class="form-group">
                          <div class="col-xs-6">
                              <label for="name"><h4>Password</h4></label>
                              <input pattern=".{8,}" required  type="password" v-model="user.password" class="form-control" name="password" id="password" title="password">
                          </div>
                      </div>
                      <div class="form-group">

                          <div class="col-xs-6">
                              <label for="email"><h4>Email</h4></label>
                              <input required v-model="user.email" type="email" class="form-control" name="email" id="email" placeholder="you@email.com" title="enter your email.">
                          </div>
                      </div>

                      <div class="col-xs-12">
                          <h3>Roles</h3>
                        <roles-list :read-only="false" v-on:update="roleUpdated" />
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
            user: {
                name: null
            }
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
                axios.post(`${process.env.MIX_APP_URL}/api/users`,{
                    "first_name": this.user.first_name,
                    "last_name": this.user.last_name,
                    "password": this.user.password,
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
                    window.location.href = `/admin/users/${response.data.data.id}`;
                })
            }
       },
    },
    created(){

    }
}
</script>
<style scoped>
</style>

