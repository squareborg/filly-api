<script>
    import Auth from './Auth';

    const ROUTE_PASSWORD_RESET = '/password/reset';

    export default {
        extends: Auth,

        data() {
            return {
                form: {
                    token: null,
                    email: null,
                    password: null,
                    password_confirmation: null,
                }
            }
        },

        mounted() {
            this.form.token = this.$refs.token.value;
        },

        methods: {
            send() {
                axios.post(ROUTE_PASSWORD_RESET, this.form)
                    .then(response => {
                        this.reset();
                        window.location.href = response.data.redirect_url;
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
                    password: null,
                    password_confirmation: null,
                };

                this.errors = {};
            }
        }
    }
</script>