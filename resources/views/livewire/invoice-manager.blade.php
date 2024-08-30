<div>
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Manage Invoices</h1>

    <!-- Formulario para agregar o editar una factura -->
    <form wire:submit.prevent="saveInvoice" class="space-y-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <select wire:model="client_id" class="input-field" required>
                <option value="">Select Client</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}">{{ $client->user->name }}</option>
                @endforeach
            </select>

            <input type="number" wire:model="total_amount" class="input-field" placeholder="Total Amount" required>
            <input type="text" wire:model="status" class="input-field" placeholder="Status" required>
        </div>
        <div class="flex justify-start mt-4">
            <button type="submit" class="cta-button">{{ $selectedInvoiceId ? 'Update Invoice' : 'Add Invoice' }}</button>
        </div>
    </form>

    <!-- Listado de facturas -->
    <div class="mt-6">
        <ul class="space-y-4">
            @foreach ($invoices as $invoice)
                <li class="bg-white dark:bg-gray-700 p-4 rounded-lg shadow flex justify-between items-center">
                    <div>
                        <p class="text-lg font-semibold">Client: {{ $invoice->client->user->name }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Total: ${{ $invoice->total_amount }} - Status: {{ $invoice->status }}</p>
                    </div>
                    <div class="flex space-x-4">
                        <button wire:click="editInvoice({{ $invoice->id }})" class="cta-button bg-yellow-500 hover:bg-yellow-600">Edit</button>
                        <button wire:click="deleteInvoice({{ $invoice->id }})" class="cta-button bg-red-500 hover:bg-red-600">Delete</button>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
