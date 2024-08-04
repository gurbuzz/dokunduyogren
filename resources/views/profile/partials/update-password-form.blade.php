<section class="container mt-5">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Şifreyi Güncelle') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Hesabınızın güvenliğini sağlamak için uzun ve rastgele bir şifre kullanın.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-3">
        @csrf
        @method('put')

        <div class="mb-3">
            <label for="update_password_current_password" class="form-label">{{ __('Mevcut Şifre') }}</label>
            <input id="update_password_current_password" name="current_password" type="password" class="form-control" autocomplete="current-password" />
            @error('current_password')
                <div class="text-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="update_password_password" class="form-label">{{ __('Yeni Şifre') }}</label>
            <input id="update_password_password" name="password" type="password" class="form-control" autocomplete="new-password" />
            @error('password')
                <div class="text-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="update_password_password_confirmation" class="form-label">{{ __('Yeni Şifreyi Onayla') }}</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password" />
            @error('password_confirmation')
                <div class="text-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary">{{ __('Kaydet') }}</button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">
                    {{ __('Kaydedildi.') }}
                </p>
            @endif
        </div>
    </form>
</section>
