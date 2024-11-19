<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <!-- Update Profile Information Form -->
    <section class="mb-6">
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
                <label for="name" class="block font-medium text-gray-700 dark:text-gray-300">{{ __('Name') }}</label>
                <input id="name" type="text" wire:model.defer="name" class="input-field mt-1 block w-full" required autofocus autocomplete="name" />
                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>  

            <div>
                <label for="email" class="block font-medium text-gray-700 dark:text-gray-300">{{ __('Email') }}</label>
                <input id="email" type="email" wire:model.defer="email" class="input-field mt-1 block w-full" required autocomplete="username" />
                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                    <div class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        <p>{{ __('Your email address is unverified.') }}

                            <button wire:click.prevent="sendVerification" class="underline text-blue-500 hover:text-blue-700">{{ __('Click here to re-send the verification email.') }}</button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 font-medium text-green-600 dark:text-green-400">{{ __('A new verification link has been sent to your email address.') }}</p>
                        @endif
                    </div>
                @endif
            </div>

            <div class="flex items-center gap-4 mt-4"> <!-- Añadir más margen superior -->
                <button type="submit" class="cta-button">{{ __('Save') }}</button>

                @if (session('message'))
                    <p class="mt-2 font-medium text-green-600 dark:text-green-400">{{ session('message') }}</p>
                @endif
            </div>
        </form>
    </section>

    <!-- Update Password Form -->
    <section class="mt-10 space-y-8 mb-6">
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Update Password') }}</h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ __('Ensure your account is using a long, random password to stay secure.') }}</p>
        </header>

        <form wire:submit.prevent="updatePassword">
            <div class="mt-6">
                <label for="current_password" class="block font-medium text-gray-700 dark:text-gray-300">{{ __('Current Password') }}</label>
                <input id="current_password" type="password" wire:model.defer="current_password" class="input-field mt-1 block w-full" autocomplete="current-password" />
                @error('current_password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mt-6">
                <label for="password" class="block font-medium text-gray-700 dark:text-gray-300">{{ __('New Password') }}</label>
                <input id="password" type="password" wire:model.defer="password" class="input-field mt-1 block w-full" autocomplete="new-password" />
                @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mt-6">
                <label for="password_confirmation" class="block font-medium text-gray-700 dark:text-gray-300">{{ __('Confirm Password') }}</label>
                <input id="password_confirmation" type="password" wire:model.defer="password_confirmation" class="input-field mt-1 block w-full" autocomplete="new-password" />
                @error('password_confirmation') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="flex items-center gap-4 mt-6"> <!-- Añadir más margen superior -->
                <button type="submit" class="cta-button">{{ __('Change Password') }}</button>

                @if (session('message'))
                    <p class="mt-2 font-medium text-green-600 dark:text-green-400">{{ session('message') }}</p>
                @endif
            </div>
        </form>
    </section>
<p>

</p>
    <!-- Delete User Form -->
    <section class="mt-10 space-y-8">
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Delete Account') }}</h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ __('Once your account is deleted, all of its resources and data will be permanently deleted.') }}</p>
        </header>

        <form wire:submit.prevent="deleteUser">
            <div class="mt-6">
                <label for="password" class="block font-medium text-gray-700 dark:text-gray-300">{{ __('Password') }}</label>
                <input id="password" type="password" wire:model.defer="password" class="input-field mt-1 block w-full" placeholder="{{ __('Password') }}" />
                @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mt-8 flex justify-end"> <!-- Añadir más margen superior -->
                <button type="submit" class="cta-button bg-red-500 hover:bg-red-600 mt-6">{{ __('Delete Account') }}</button>
            </div>
        </form>
    </section>
</div>
