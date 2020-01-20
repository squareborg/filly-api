<script>
    import Auth from './Auth';

    const ROUTE_LOGIN = 'login';

    export default {
        extends: Auth,

        data() {
            return {
                form: {
                    email: null,
                    password: null,
                    remember: false,
                }
            }
        },

        methods: {
            send() {
                axios.post(route(ROUTE_LOGIN), this.form)
                    .then((response) => {
                        window.location.href = response.data.redirect_url;
                    })
                    .catch((error) => {
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
                    password: null,
                    remember: false,
                };

                this.errors = {};
            }
        }
    }
</script>