<template>
    <div class="" :class="isEmpty ? '' : 'is-empty'">
        <span v-if="isLoading">Please wait...</span>
        <input type="file" ref="fileInput" style="display:none;" @change="previewImage" accept="image/*">
        <div class="image-upload__empty " v-if="!isLoading && !logo">
            <a href="#" class="" @click.prevent="openFileBrowser">Add Logo</a>
        </div>
        <div class="flex flex-col">

        <img v-if="logo" width="200px" :src="imagePreviewPath" />
        <a href="#" class="" @click.prevent="destroy" v-if="imagePreviewPath && ! isLoading && logo">
            Remove
        </a>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        props: ['initLogo', 'fallbackLogo', 'merchantUuid'],

        data() {
            return {
                logo: null,
                image: null,
                imagePreview: null,
                newImage: null,
                isLoading: false,
            }
        },

        mounted() {
            this.logo = this.initLogo;
            if(this.logo){
                this.image = this.logo;
            }
            else{
                this.image = this.fallbackLogo;
            }
        },

        computed: {
            imagePreviewPath() {
                return this.image ? this.image : this.imagePreview;
            },

            isEmpty() {
                return this.image || this.imagePreview;
            },
        },

        methods: {
            openFileBrowser() {
                this.$refs.fileInput.click();
            },

            previewImage(event) {
                const files = event.target.files;

                if (files.length === 0) {
                    return
                }

                this.newImage = files[0];

                let reader = new FileReader();

                reader.onload = (e) => {
                    this.imagePreview = e.target.result;
                    this.store();
                };

                reader.readAsDataURL(files[0]);
            },

            loading() {
                this.isLoading = ! this.isLoading;
            },

            reset() {
                this.newImage = null;
                this.$refs.fileInput.value = '';
            },

            store() {
                this.loading();
                let data = new FormData();
                data.append('logo', this.newImage ? this.newImage : '');
                axios.post(`${route('api.merchants.logo.store', this.merchantUuid)}`, data)
                    .then((response) => {
                        this.image = response.data.logo;
                        this.logo = response.data.logo;
                        this.loading();
                    })
                    .catch( error => {
                        this.$notify({
                            type: 'error',
                            group: 'main',
                            title: 'Error saving profile image',
                            text: error.response.data.errors.logo[0],
                            duration: -1
                        });
                        this.image = this.initImage;
                        this.loading();
                    })
            },

            destroy() {
                this.isLoading = ! this.isLoading;
                axios.delete(`${route('api.merchants.logo.destroy', this.merchantUuid)}`).then((response) => {
                    this.logo = null;
                    this.image = this.fallbackLogo
                    this.loading();
                    this.reset();
                })
            }
        }
    }
</script>
<style scoped>

</style>
