<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <!-- Update Profile Information Form -->
    <section class="mb-6">
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Información del Perfil') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Actualiza la información de tu perfil y la dirección de correo electrónico de tu cuenta.') }}
            </p>
        </header>

        <form wire:submit.prevent="updateProfileInformation" class="mt-6 space-y-6">
            <div>
                <label for="name" class="block font-medium text-gray-700 dark:text-gray-300">{{ __('Nombre') }}</label>
                <input id="name" type="text" wire:model.defer="name" class="input-field mt-1 block w-full" required autofocus autocomplete="name" />
                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>  

            <div>
                <label for="email" class="block font-medium text-gray-700 dark:text-gray-300">{{ __('Correo Electrónico') }}</label>
                <input id="email" type="email" wire:model.defer="email" class="input-field mt-1 block w-full" required autocomplete="username" />
                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                    <div class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        <p>{{ __('Tu dirección de correo electrónico no está verificada.') }}

                            <button wire:click.prevent="sendVerification" class="underline text-blue-500 hover:text-blue-700">{{ __('Haz clic aquí para reenviar el correo de verificación.') }}</button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 font-medium text-green-600 dark:text-green-400">{{ __('Se ha enviado un nuevo enlace de verificación a tu dirección de correo electrónico.') }}</p>
                        @endif
                    </div>
                @endif
            </div>

            <div class="flex items-center gap-4 mt-4">
                <button type="submit" class="cta-button">{{ __('Guardar') }}</button>

                @if (session('message'))
                    <p class="mt-2 font-medium text-green-600 dark:text-green-400">{{ session('message') }}</p>
                @endif
            </div>
        </form>
    </section>

    <!-- Update Password Form -->
    <section class="mt-10 space-y-8 mb-6">
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Actualizar Contraseña') }}</h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ __('Asegúrate de que tu cuenta esté usando una contraseña larga y aleatoria para mantenerla segura.') }}</p>
        </header>

        <form wire:submit.prevent="updatePassword">
            <div class="mt-6">
                <label for="current_password" class="block font-medium text-gray-700 dark:text-gray-300">{{ __('Contraseña Actual') }}</label>
                <input id="current_password" type="password" wire:model.defer="current_password" class="input-field mt-1 block w-full" autocomplete="current-password" />
                @error('current_password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mt-6">
                <label for="password" class="block font-medium text-gray-700 dark:text-gray-300">{{ __('Nueva Contraseña') }}</label>
                <input id="password" type="password" wire:model.defer="password" class="input-field mt-1 block w-full" autocomplete="new-password" />
                @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mt-6">
                <label for="password_confirmation" class="block font-medium text-gray-700 dark:text-gray-300">{{ __('Confirmar Contraseña') }}</label>
                <input id="password_confirmation" type="password" wire:model.defer="password_confirmation" class="input-field mt-1 block w-full" autocomplete="new-password" />
                @error('password_confirmation') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="flex items-center gap-4 mt-6">
                <button type="submit" class="cta-button">{{ __('Cambiar Contraseña') }}</button>

                @if (session('message'))
                    <p class="mt-2 font-medium text-green-600 dark:text-green-400">{{ session('message') }}</p>
                @endif
            </div>
        </form>
    </section>

    <!-- Delete User Form -->
    <section class="mt-10 space-y-8">
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Eliminar Cuenta') }}</h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ __('Una vez que tu cuenta sea eliminada, todos sus recursos y datos se eliminarán de forma permanente.') }}</p>
        </header>

        <form wire:submit.prevent="deleteUser">
            <div class="mt-6">
                <label for="password" class="block font-medium text-gray-700 dark:text-gray-300">{{ __('Contraseña') }}</label>
                <input id="password" type="password" wire:model.defer="password" class="input-field mt-1 block w-full" placeholder="{{ __('Contraseña') }}" />
                @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mt-8 flex justify-end">
                <button type="submit" class="cta-button bg-red-500 hover:bg-red-600 mt-6">{{ __('Eliminar Cuenta') }}</button>
            </div>
        </form>
    </section>
</div>
