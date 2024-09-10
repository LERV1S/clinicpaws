<div>
    <!-- Update Profile Information Form -->
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Profile Information') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __("Update your account's profile information and email address.") }}
            </p>
        </header>

        <form wire:submit.prevent="updateProfileInformation" class="mt-6 space-y-6">
            <div>
                <label for="name">{{ __('Name') }}</label>
                <input id="name" type="text" wire:model.defer="name" class="mt-1 block w-full" required autofocus autocomplete="name" />
                @error('name') <span>{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="email">{{ __('Email') }}</label>
                <input id="email" type="email" wire:model.defer="email" class="mt-1 block w-full" required autocomplete="username" />
                @error('email') <span>{{ $message }}</span> @enderror

                @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                    <div>
                        <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                            {{ __('Your email address is unverified.') }}

                            <button wire:click.prevent="sendVerification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                                {{ __('Click here to re-send the verification email.') }}
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>

            <div class="flex items-center gap-4">
                <button type="submit" class="btn-primary">{{ __('Save') }}</button>

                @if (session('message'))
                    <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                        {{ session('message') }}
                    </p>
                @endif
            </div>
        </form>
    </section>

    <!-- Update Password Form -->
    <section class="mt-6 space-y-6">
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Update Password') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Ensure your account is using a long, random password to stay secure.') }}
            </p>
        </header>

        <form wire:submit.prevent="updatePassword">
            <div>
                <label for="current_password">{{ __('Current Password') }}</label>
                <input id="current_password" type="password" wire:model.defer="current_password" class="mt-1 block w-full" autocomplete="current-password" />
                @error('current_password') <span>{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="password">{{ __('New Password') }}</label>
                <input id="password" type="password" wire:model.defer="password" class="mt-1 block w-full" autocomplete="new-password" />
                @error('password') <span>{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="password_confirmation">{{ __('Confirm Password') }}</label>
                <input id="password_confirmation" type="password" wire:model.defer="password_confirmation" class="mt-1 block w-full" autocomplete="new-password" />
                @error('password_confirmation') <span>{{ $message }}</span> @enderror
            </div>

            <div class="flex items-center gap-4">
                <button type="submit" class="btn-primary">{{ __('Change Password') }}</button>

                @if (session('message'))
                    <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                        {{ session('message') }}
                    </p>
                @endif
            </div>
        </form>
    </section>

    <!-- Delete User Form -->
    <section class="mt-6 space-y-6">
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Delete Account') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
            </p>
        </header>

        <form wire:submit.prevent="deleteUser">
            <div class="mt-6">
                <label for="password">{{ __('Password') }}</label>
                <input id="password" type="password" wire:model.defer="password" class="mt-1 block w-3/4" placeholder="{{ __('Password') }}" />
                @error('password') <span>{{ $message }}</span> @enderror
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="btn-danger">{{ __('Delete Account') }}</button>
            </div>
        </form>
    </section>
</div>
