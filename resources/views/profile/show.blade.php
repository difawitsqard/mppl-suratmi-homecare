<x-app-layout>
    <x-slot name="header">
        {{ __('Profile') }}
    </x-slot>
    <div class="row">
        <div class="col-xl-5">
            @livewire('profile.logout-other-browser-sessions-form')
        </div>

        <div class="col-xl-7">

            <div class="card">
                <div class="card-body pt-3">
                    <!-- Bordered Tabs -->
                    <ul class="nav nav-tabs nav-tabs-bordered">

                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit
                                Profile</button>
                        </li>

                        {{-- <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#2fa">2fa</button>
                        </li> --}}

                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab"
                                data-bs-target="#profile-change-password">Change Password</button>
                        </li>

                    </ul>
                    <div class="tab-content pt-2">

                        <div class="tab-pane fade profile-edit show active pt-3" id="profile-edit">

                            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                                @livewire('profile.update-profile-information-form')

                                <x-section-border />
                            @endif

                            {{-- @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                                <x-section-border />

                                <div class="mt-10 sm:mt-0">
                                    @livewire('profile.delete-user-form')
                                </div>
                            @endif --}}

                        </div>

                        {{-- <div class="tab-pane fade pt-3" id="2fa">
                            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                                <div class="mt-10 sm:mt-0">
                                    @livewire('profile.two-factor-authentication-form')
                                </div>

                                <x-section-border />
                            @endif
                        </div> --}}

                        <div class="tab-pane fade pt-3" id="profile-change-password">

                            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                                <div class="mt-10 sm:mt-0">
                                    @livewire('profile.update-password-form')
                                </div>

                                <x-section-border />
                            @endif

                        </div>

                    </div><!-- End Bordered Tabs -->

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
