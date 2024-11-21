<div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 text-center">Formulario de Predicción</h1>

        <!-- Mensajes de error -->
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6">
                <strong class="font-bold">Errores:</strong>
                <ul class="mt-2 ml-4 list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulario -->
        <form method="POST" action="{{ route('predict') }}" class="space-y-6">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div>
                    <label for="animal" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Animal</label>
                    <input type="text" id="animal" name="animal" class="input-field" placeholder="Ejemplo: Perro" required>
                </div>
                <div class="col-span-2">
                    <label for="symptoms" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Síntomas</label>
                    <div class="space-y-2">
                        <input type="text" name="symptoms[]" class="input-field" placeholder="Síntoma 1" required>
                        <input type="text" name="symptoms[]" class="input-field" placeholder="Síntoma 2">
                        <input type="text" name="symptoms[]" class="input-field" placeholder="Síntoma 3">
                        <input type="text" name="symptoms[]" class="input-field" placeholder="Síntoma 4">
                        <input type="text" name="symptoms[]" class="input-field" placeholder="Síntoma 5">
                    </div>
                </div>
            </div>
            <div class="flex justify-end mt-4">
                <button type="submit" class="cta-button bg-blue-600 hover:bg-blue-700 text-white">
                    Predecir
                </button>
            </div>
        </form>
    </div>
</div>