<x-form-section submit="updateProfileInformation">
    <x-slot name="form">
        <div class="row mb-3">
            <x-action-message on="saved">
                <div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show"
                    role="alert">
                    <i class="bi bi-check-circle me-1"></i>
                    Proifl berhasil diperbarui.
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                </div>
            </x-action-message>

            <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Foto Profil</label>
            <div class="col-md-8 col-lg-9 mb-3">
                <!-- Profile Photo -->
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div x-data="{ photoName: null, photoPreview: null }" class="col-12 col-md-6">
                        <!-- Profile Photo File Input -->
                        <input type="file" id="photo" class="d-none" wire:model="photo" x-ref="photo"
                            x-on:change="
                            photoName = $refs.photo.files[0].name;
                            const reader = new FileReader();
                            reader.onload = (e) => {
                                photoPreview = e.target.result;
                            };
                            reader.readAsDataURL($refs.photo.files[0]);" />

                        <!-- Current Profile Photo -->
                        <div class="mt-2" x-show="! photoPreview">
                            <img src="{{ $this->user->profile_photo_url }}"
                                style="width: 180px; height: 180px; object-fit: cover;" alt="{{ $this->user->name }}"
                                class="rounded shadow-sm">
                        </div>

                        <!-- New Profile Photo Preview -->
                        <div class="mt-2" x-show="photoPreview">
                            <img :src="photoPreview" class="rounded shadow-sm"
                                style="width: 180px; height: 180px; object-fit: cover;">
                        </div>

                        <button class="btn btn-primary btn-sm mt-2 me-1" type="button"
                            x-on:click.prevent="$refs.photo.click()">
                            <i class="bi bi-upload"></i> Unggah
                        </button>

                        @if ($this->user->profile_photo_path)
                            <button type="button" class="btn btn-danger btn-sm mt-2" wire:click="deleteProfilePhoto">
                                <i class="bi bi-x"></i> Hapus
                            </button>
                        @endif

                        <x-input-error for="photo" class="mt-2" />
                    </div>
                @endif
            </div>
        </div>


        <!-- Name -->

        <div class="row mb-3">
            <label for="name" class="col-md-4 col-lg-3 col-form-label">{{ __('Nama Lengkap') }}</label>
            <div class="col-md-8 col-lg-9">
                <x-input id="name" type="text" class="form-control" wire:model="state.name" required
                    autocomplete="name" />
                <x-input-error for="name" class="mt-2" />
            </div>
        </div>

        <!-- Role -->
        <div class="row mb-3">
            <label for="role" class="col-md-4 col-lg-3 col-form-label">{{ __('Role') }}</label>
            <div class="col-md-8 col-lg-9">
                <x-input id="role" type="text" class="form-control" value="{{ auth()->user()->roles->first()->name }}" readonly disabled/>
            </div>
        </div>

        <!-- Email -->
        <div class="row mb-3">
            <label for="email" class="col-md-4 col-lg-3 col-form-label">{{ __('Email') }}</label>
            <div class="col-md-8 col-lg-9">
                <x-input id="email" type="email" class="form-control" wire:model="state.email" required
                    autocomplete="username" />
                <x-input-error for="email" class="mt-2" />
            </div>
            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) &&
                    !$this->user->hasVerifiedEmail())
                <p class="text-sm mt-2">
                    {{ __('Your email address is unverified.') }}

                    <button type="button"
                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        wire:click.prevent="sendEmailVerification">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>

                @if ($this->verificationLinkSent)
                    <p class="mt-2 font-medium text-sm text-green-600">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </p>
                @endif
            @endif
        </div>

        <div class="row mb-3">
            <label for="phone_number" class="col-md-4 col-lg-3 col-form-label">{{ __('Nomor Hp') }}</label>
            <div class="col-md-8 col-lg-9">
                <x-input id="phone_number" type="text" class="form-control" wire:model="state.phone_number" required
                    autocomplete="phone_number" />
                <x-input-error for="phone_number" class="mt-2" />
            </div>
        </div>

        <div class="row mb-3">
            <label for="address" class="col-md-4 col-lg-3 col-form-label">{{ __('Alamat') }}</label>
            <div class="col-md-8 col-lg-9">
                <textarea id="address" type="text" class="form-control" wire:model="state.address" required autocomplete="address"
                    rows="3"></textarea>


                <x-input-error for="address" class="mt-2" />
            </div>
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-button wire:loading.attr="disabled" wire:target="photo" class="btn btn-primary">
            {{ __('Simpan') }}
        </x-button>
    </x-slot>
</x-form-section>
