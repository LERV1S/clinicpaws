<div>
    <h1>Manage Invoices</h1>

    <!-- Formulario para agregar o editar una factura -->
    <form wire:submit.prevent="saveInvoice">
        <select wire:model="client_id" required>
            <option value="">Select Client</option>
            @foreach($clients as $client)
                <option value="{{ $client->id }}">{{ $client->user->name }}</option>
            @endforeach
        </select>

        <input type="number" wire:model="total_amount" placeholder="Total Amount" required>
        <input type="text" wire:model="status" placeholder="Status" required>
        <button type="submit">{{ $selectedInvoiceId ? 'Update Invoice' : 'Add Invoice' }}</button>
    </form>

    <!-- Listado de facturas -->
    <ul>
        @foreach ($invoices as $invoice)
            <li>
                Client: {{ $invoice->client->user->name }} - Total: ${{ $invoice->total_amount }} - Status: {{ $invoice->status }}
                <button wire:click="editInvoice({{ $invoice->id }})">Edit</button>
                <button wire:click="deleteInvoice({{ $invoice->id }})">Delete</button>
            </li>
        @endforeach
    </ul>
</div>

