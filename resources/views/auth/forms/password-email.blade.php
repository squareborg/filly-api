<password-email-form v-cloak inline-template>
    <form class="auth" autocomplete="false" @submit.prevent="submit">
        <div class="text-center my-12">
            <img src="{{ asset('images/logo2.png') }}" class="px-6 py-6 logo mx-auto">
        </div>

        <div v-if="!resetSent">
            <p class="text-lg text-white mb-2">Reset password</p>
            <p class="text-base mb-3">{{ __('auth.reset_instructions') }}</p>
        </div>

        <div v-if="resetSent">
            <p class="text-lg text-white mb-2">Check your email</p>
            <p class="text-base mb-3">{{ __('auth.reset_sent') }}</p>
        </div>

        <div v-if="!resetSent">
            <div class="mb-1">
                <input type="email" class="auth__input" placeholder="{{ __('auth.form.email') }}" v-model="form.email" required autofocus>
                <validation :errors="errors" name="email"></validation>
            </div>

            <div class="mt-12">
                <button type="submit" class="btn btn-primary" :disabled="isSending">
                    <span v-if="!isSending">{{ __('auth.send_reset') }}</span>
                    <span v-if="isSending"><i class="fas fa-spinner fa-spin"></i></span>
                </button>
            </div>
        </div>

        <div v-if="resetSent" class="mt-12">
            <a href="{{ route('login') }}" class="btn btn-primary">OK</a>
        </div>
    </form>
</password-email-form>
