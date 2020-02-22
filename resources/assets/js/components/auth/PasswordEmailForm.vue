<script>
    import Auth from './Auth';

    const ROUTE_PASSWORD_EMAIL = 'password.email';

    export default {
        extends: Auth,

        data() {
            return {
                resetSent: false,
                form: {
                    email: null
                }
            }
        },

        methods: {
            send() {
                axios.post(route(ROUTE_PASSWORD_EMAIL), this.form)
                    .then(response => {
                        this.reset();
                        this.resetSent = true;
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
                    email: null,
                };

                this.errors = {};
            }
        }
    }
</script>