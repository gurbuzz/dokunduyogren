<section class="container mt-5">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Hesabı Sil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Hesabınız silindikten sonra, tüm kaynakları ve verileri kalıcı olarak silinecektir. Hesabınızı silmeden önce, saklamak istediğiniz verileri indiriniz.') }}
        </p>
    </header>

    <button class="btn btn-danger mt-3" data-toggle="modal" data-target="#confirmDeletionModal">
        {{ __('Hesabı Sil') }}
    </button>

    <!-- Modal -->
    <div class="modal fade" id="confirmDeletionModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeletionModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmDeletionModalLabel">{{ __('Hesabınızı silmek istediğinizden emin misiniz?') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="mt-1 text-sm text-gray-600">
                            {{ __('Hesabınız silindikten sonra, tüm kaynakları ve verileri kalıcı olarak silinecektir. Hesabınızı kalıcı olarak silmek istediğinizi onaylamak için lütfen şifrenizi girin.') }}
                        </p>
                        <div class="form-group">
                            <label for="password" class="sr-only">{{ __('Şifre') }}</label>
                            <input id="password" name="password" type="password" class="form-control" placeholder="{{ __('Şifre') }}" required />
                            @error('password')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('İptal') }}</button>
                        <button type="submit" class="btn btn-danger">{{ __('Hesabı Sil') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
