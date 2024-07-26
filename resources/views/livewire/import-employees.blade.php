<div class="p-6 bg-white rounded-lg shadow-md">
    @if (session()->has('message'))
        <div class="mb-4 text-sm text-green-600">{{ session('message') }}</div>
    @endif

    @if (session()->has('error'))
        <div class="mb-4 text-sm text-red-600">{{ session('error') }}</div>
    @endif

    <form wire:submit.prevent="import" enctype="multipart/form-data">
        <div class="mb-4">
            <input type="file" wire:model="file" class="form-control" accept=".xls,.xlsx,.csv">
            @error('file') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded-md btn btn-primary">Import Employees</button>
    
    </form>
</div>
