<login-form v-cloak inline-template>
    <form class="auth" autocomplete="false" @submit.prevent="submit">
        <div class="text-center my-12">
            <img width="" src="{{ asset('images/logo2.png') }}" class="px-6 py-6 logo mx-auto">
        </div>

        <p class="text-lg text-center mb-3">Log in to your account</p>

        <div class="mb-1">
            <input type="email" class="auth__input" placeholder="{{ __('auth.form.email') }}" v-model="form.email" required autofocus>
            <validation :errors="errors" name="email"></validation>
        </div>

        <div class="mb-3">
            <input type="password" class="auth__input" placeholder="{{ __('auth.form.password') }}" v-model="form.password" required>
            <validation :errors="errors" name="password"></validation>
        </div>

        <div class="flex mx-1">
            <div class="w-1/2">
                <a class="" href="{{ route('password.request') }}">{{ __('auth.forgot_password') }}</a>
            </div>

            <div class="w-1/2 text-right auth__form-options-checkbox">
                <input id="checkbox-1" type="checkbox" name="remember" v-model="form.remember">
                <label for="checkbox-1">Remember Me</label>
            </div>
        </div>

        <div class="my-12">
            <button type="submit" class="btn btn-primary btn--submit rounded" :disabled="isSending">
                <span v-if="!isSending">{{ __('auth.login') }}</span>
                <span v-if="isSending"><i class="fas fa-spinner fa-spin"></i></span>
            </button>
        </div>
            <p class="">Don't have an account? <a href="{{ route('register') }}">{{ __('auth.register') }}</a></p>
    </form>
</login-form>
