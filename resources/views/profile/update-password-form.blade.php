<x-form-section submit="updatePassword">
    <x-slot name="title">
        {{ __('Update Password') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Ensure your account is using a long, random password to stay secure.') }}
    </x-slot>

    <x-slot name="form">
        <x-action-message on="saved">
            <div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-1"></i>
                Kata sandi berhasil diubah.
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </x-action-message>

        <div class="row mb-3">
            <x-label for="current_password" class="col-md-4 col-lg-3 col-form-label"
                value="{{ __('Current Password') }}" />
            <div class="col-md-8 col-lg-9">
                <x-input id="current_password" type="password" class="form-control" wire:model="state.current_password"
                    autocomplete="current-password" />
                <x-input-error for="current_password" class="mt-1" />
            </div>
        </div>

        <div class="row mb-3">
            <x-label for="password" class="col-md-4 col-lg-3 col-form-label" value="{{ __('New Password') }}" />
            <div class="col-md-8 col-lg-9">
                <x-input id="password" type="password" class="form-control" wire:model="state.password"
                    autocomplete="new-password" />
                <x-input-error for="password" class="mt-1" />
            </div>
        </div>

        <div class="row mb-3">
            <x-label for="password_confirmation" class="col-md-4 col-lg-3 col-form-label"
                value="{{ __('Confirm Password') }}" />
            <div class="col-md-8 col-lg-9">
                <x-input id="password_confirmation" type="password" class="form-control"
                    wire:model="state.password_confirmation" autocomplete="new-password" />
                <x-input-error for="password_confirmation" class="mt-1" />
            </div>
        </div>
    </x-slot>

    <x-slot name="actions">
        <div class="d-flex justify-content-between align-items-center">
            <x-button class="btn btn-primary">
                {{ __('Ubah Password') }}
            </x-button>
        </div>
    </x-slot>
</x-form-section>
