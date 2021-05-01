<script>
    export default {
        data() {
            return {
                isSending: false,
                errors: {}
            }
        },

        methods: {
            sending() {
                this.isSending = ! this.isSending;
            },

            submit() {
                this.sending();
                this.send();
            }
        }
    }
</script>