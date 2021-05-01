<password-reset-form v-cloak inline-template>
    <form class="auth" autocomplete="false" @submit.prevent="submit">
        <input type="hidden" ref="token" name="token" value="{{ $token }}">

        <div class="text-center my-12">
            <img src="{{ asset('images/logo2.png') }}" class="px-6 py-6 logo mx-auto">
        </div>

        <div class="mb-1">
            <input type="email" class="auth__input" placeholder="{{ __('auth.form.email') }}" v-model="form.email" required autofocus>
            <validation :errors="errors" name="email"></validation>
        </div>

        <div class="mb-1">
            <input type="password" class="auth__input" placeholder="{{ __('auth.form.new_password') }}" v-model="form.password" required>
            <validation :errors="errors" name="password"></validation>
        </div>

        <div class="mb-1">
            <input type="password" class="auth__input" placeholder="{{ __('auth.form.password_confirmation') }}" v-model="form.password_confirmation" required>
            <validation :errors="errors" name="password_confirmation"></validation>
        </div>

        <div class="mt-12">
            <button type="submit" class="btn btn-primary" :disabled="isSending">
                <span v-if="!isSending">{{ __('auth.reset') }}</span>
                <span v-if="isSending"><i class="fas fa-spinner fa-spin"></i></span>
            </button>
        </div>
    </form>
</password-reset-form>
