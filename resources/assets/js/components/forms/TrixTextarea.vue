<template>
    <div></div>
</template>

<script>
    import Trix from 'trix';

    export default {
        props: ['value'],

        data() {
            return {
                trix: null,
                id: '',
            }
        },

        mounted() {
            // Generate a random identifier so no collisions are
            // made for multiple instances on the same page.
            this.id = _.sampleSize('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789', 5).join('');
            // Create the trix editor.
            this.trix = $(`<trix-editor input="${this.id}"></trix-editor>`);

            // Emit the input event for the v-model directive when trix changes.
            this.trix.on('trix-change', (e) => {
                this.$emit('input', e.currentTarget.innerHTML);
            });

            // Set the default value when trix initializes.
            this.trix.on('trix-initialize', (e) => {
                // Make sure we have a value first.
                if (this.value) {
                    e.currentTarget.editor.insertHTML(this.value);
                }
            });

            // Insert the new editor into the vue template.
            this.trix.insertAfter(this.$el);
        },
    }
</script>