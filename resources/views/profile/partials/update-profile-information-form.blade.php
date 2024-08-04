<section class="container mt-5">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profil Bilgileri') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Hesabınızın profil bilgilerini ve e-posta adresini güncelleyin.') }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-3">
        @csrf
        @method('patch')

        <div class="mb-3">
            <label for="name" class="form-label">{{ __('İsim') }}</label>
            <input id="name" name="name" type="text" class="form-control" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
            @error('name')
                <div class="text-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">{{ __('E-posta') }}</label>
            <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required autocomplete="username" />
            @error('email')
                <div class="text-danger mt-2">{{ $message }}</div>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3">
                    <p class="text-sm text-gray-800">
                        {{ __('E-posta adresiniz doğrulanmadı.') }}
                        <button form="send-verification" class="btn btn-link p-0 m-0 align-baseline">{{ __('Doğrulama e-postasını yeniden gönder.') }}</button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-success">
                            {{ __('Yeni doğrulama bağlantısı e-posta adresinize gönderildi.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary">{{ __('Kaydet') }}</button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">
                    {{ __('Kaydedildi.') }}
                </p>
            @endif
        </div>
    </form>
</section>
