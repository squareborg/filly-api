<template>
    <div>
            <form v-if="!registered" class="auth" autocomplete="false" @submit.prevent="submit">

                <div class="text-center my-12">
                    <img src="images/logo2.png" class="px-6 py-6 logo mx-auto">
                </div>

                <p class="text-lg text-center mb-3">Sign up with email</p>

                <div class="mb-1">
                    <input type="email" class="auth__input" placeholder="Email Address" v-model="form.email" required autofocus>
                    <validation :errors="errors" name="email"></validation>
                </div>

                <div class="mb-1">
                    <input type="text" class="auth__input" placeholder="First Name" v-model="form.first_name" required>
                    <validation :errors="errors" name="first_name"></validation>
                </div>

                <div class="mb-1">
                    <input type="text" class="auth__input" placeholder="Last Name" v-model="form.last_name" required>
                    <validation :errors="errors" name="last_name"></validation>
                </div>

                <div class="mb-1">
                    <input type="password" class="auth__input" placeholder="Password" v-model="form.password" required>
                    <validation :errors="errors" name="password"></validation>
                </div>

                <div class="my-12">
                    <button type="submit" class="btn btn-primary btn--submit rounded" :disabled="isSending">
                        <span v-if="!isSending">Register</span>
                        <span v-if="isSending"><i class="fas fa-spinner fa-spin"></i></span>
                    </button>
                </div>

                <p class="">Already have an account? <a :href="route('login')">login</a></p>
            </form>
            <div v-if="registered">
                 <div class="text-center my-12">
                    <img src="images/logo2.png" class="px-6 py-6 logo mx-auto">
                </div>
                <div class="p-3">
                    Registration was successful please check your email for an activation link.
                </div>

            </div>
    </div>

</template>

<script>
    import Auth from './Auth';

    const ROUTE_REGISTER = 'register';

    export default {
        extends: Auth,

        data() {
            return {
                registered: false,
                form: {
                    first_name: null,
                    last_name: null,
                    email: null,
                    password: null,
                    password_confirmation: null,
                }
            }
        },

        methods: {
            send() {
                axios.post(route(ROUTE_REGISTER), this.form)
                    .then(response => {
                        console.log("registerd");
                        this.registered = true;

                    })
                    .catch(error => {
                        if (error.response.data.errors) {
                            return this.errors = error.response.data.errors;
                        }
                    })
                    .finally(() => {
                        this.sending();
                    })
            },

            reset() {
                this.form = {
                    first_name: null,
                    last_name: null,
                    email: null,
                    password: null,
                    password_confirmation: null,
                };

                this.errors = {};
            }
        }
    }
</script>
