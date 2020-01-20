<template>
    <div class="p-2 text-red-light text-sm" v-if="hasError(index, name)">{{ error(index, name) }}</div>
</template>

<script>
    export default {
        props: ['errors', 'index', 'name'],

        methods: {
            error(index, param) {
                if (! this.hasError(index, param)) return null;
                return this.errors[this.name][0];
            },

            hasError(index, param) {
                return this.errors.hasOwnProperty(this.name);
            }
        }
    }
</script>