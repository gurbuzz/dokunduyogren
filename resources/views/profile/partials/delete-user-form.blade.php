<section class="container mt-5">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Hesabı Sil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Hesabınız silindikten sonra, tüm kaynakları ve verileri kalıcı olarak silinecektir. Hesabınızı silmeden önce, saklamak istediğiniz verileri indiriniz.') }}
        </p>
    </header>

    <button class="btn btn-danger mt-3" x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
        {{ __('Hesabı Sil') }}
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Hesabınızı silmek istediğinizden emin misiniz?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Hesabınız silindikten sonra, tüm kaynakları ve verileri kalıcı olarak silinecektir. Hesabınızı kalıcı olarak silmek istediğinizi onaylamak için lütfen şifrenizi girin.') }}
            </p>

            <div class="mt-3">
                <label for="password" class="sr-only">{{ __('Şifre') }}</label>
                <input id="password" name="password" type="password" class="form-control" placeholder="{{ __('Şifre') }}" />
                @error('password')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="mt-3 d-flex justify-content-end">
                <button type="button" class="btn btn-secondary" x-on:click="$dispatch('close')">{{ __('İptal') }}</button>
                <button type="submit" class="btn btn-danger ms-3">{{ __('Hesabı Sil') }}</button>
            </div>
        </form>
    </x-modal>
</section>
