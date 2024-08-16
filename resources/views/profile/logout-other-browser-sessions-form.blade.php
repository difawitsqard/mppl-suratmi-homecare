<x-action-section>
    <x-slot name="title">
        {{ __('Browser Sessions') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Manage and log out your active sessions on other browsers and devices.') }}
    </x-slot>

    <x-slot name="content">
        <x-action-message on="loggedOut">
            <div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-1"></i>
                Berhasil Logout dari Sesi Browser Lain.
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                    aria-label="Close"></button>
            </div>
        </x-action-message>
        <div class="max-w-xl text-sm text-gray-600">
            {{ __('Jika perlu, Anda dapat keluar dari semua sesi peramban Anda yang lain di semua perangkat. Beberapa sesi terakhir Anda tercantum di bawah ini; Namun, daftar ini mungkin tidak lengkap. Jika Anda merasa akun Anda telah disusupi, Anda juga harus memperbarui kata sandi Anda.') }}
        </div>

        @if (count($this->sessions) > 0)
            <!-- Other Browser Sessions -->
            <ul class="list-group mt-3">
                @foreach ($this->sessions as $session)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span class="d-flex justify-content-between align-items-center">
                            @if ($session->agent->isDesktop())
                                <i class="bi bi-laptop fs-1"></i>
                            @else
                                <i class="bi bi-phone fs-1"></i>
                            @endif
                            <span class="ms-2"><small>
                                    {{ $session->agent->platform() ? $session->agent->platform() : __('Unknown') }} -
                                    {{ $session->agent->browser() ? $session->agent->browser() : __('Unknown') }}
                                </small>
                            </span>
                        </span>
                        <span class="text-end d-block">
                            <span class="badge text-primary rounded-pill">{{ $session->ip_address }}</span>
                            </br>
                            @if ($session->is_current_device)
                                <small class="text-muted">{{ __('This device') }}</small>
                            @else
                                <small class="text-muted">{{ $session->last_active }}</small>
                            @endif
                        </span>
                    </li>
                @endforeach
            </ul>
        @endif

        <div class="flex items-center mt-3">
            <x-button wire:click="confirmLogout" wire:loading.attr="disabled" class="btn btn-danger d-block">
                {{ __('Logout dari Sesi Browser Lain') }}
            </x-button>
        </div>

        <!-- Log Out Other Devices Confirmation Modal -->
        <x-dialog-modal wire:model.live="confirmingLogout">
            <x-slot name="title">
                {{ __('Logout dari Sesi Browser Lain') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Masukkan kata sandi untuk mengonfirmasi bahwa Anda ingin keluar dari sesi peramban lain di semua perangkat.') }}

                <div class="mt-3" x-data="{}"
                    x-on:confirming-logout-other-browser-sessions.window="setTimeout(() => $refs.password.focus(), 250)">
                    <x-input type="password" class="mt-1 block w-3/4" autocomplete="current-password"
                        placeholder="{{ __('Password') }}" x-ref="password" wire:model="password"
                        wire:keydown.enter="logoutOtherBrowserSessions" class=" form-control" />

                    <x-input-error for="password" class="mt-2" />
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-button wire:click="$toggle('confirmingLogout')" wire:loading.attr="disabled"
                    class="btn btn-secondary">
                    {{ __('Batal') }}
                </x-button>

                <x-button class="ms-3" wire:click="logoutOtherBrowserSessions" wire:loading.attr="disabled"
                    class="btn btn-danger">
                    {{ __('Ya, Logout') }}
                </x-button>
            </x-slot>
        </x-dialog-modal>
    </x-slot>
</x-action-section>
