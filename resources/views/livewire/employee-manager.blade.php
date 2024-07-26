{{-- <div>
    {{-- Do your work, then step back. -- }}
    <div class="p-6 mt-8 bg-white border rounded-md shadow-md">
    <input wire:model="name" type="text" placeholder="Task Name" class="w-full p-2 mb-4 border">
    
    @if($employeeId)
        <button wire:click="update" class="px-4 py-2 text-white bg-blue-500">Update</button>
    @else
        <button wire:click="create" class="px-4 py-2 text-white bg-green-500">Create</button>
    @endif

    <ul class="mt-6">
        @foreach($employees as $employee)
            <li class="flex items-center justify-between py-2 border-b">
                {{ $employee->name }}
                <div class="space-x-2">
                    <button wire:click="edit({{ $employee->id }})" class="px-2 py-1 text-white bg-blue-500">Edit</button>
                    <button wire:click="delete({{ $employee->id }})" class="px-2 py-1 text-white bg-red-500">Delete</button>
                </div>
            </li>
        @endforeach
    </ul>
</div>
</div>


<div> --}}
<div x-data="{ confirmingDelete: false}" class="m-3">
    @if($employees->isEmpty())
        <div class="p-4 mr-10 text-center bg-red-300">No employees found</div>
    @endif
    <div class="row-auto">
    <button wire:click="showEmployeeForm" class="px-4 py-2 text-white bg-blue-500 rounded-md">Add New Employee</button>
    </div>

    @if($showForm)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-50">
            <div class="w-full max-w-lg p-6 bg-white rounded-lg shadow-lg">
                <h2 class="mb-4 text-lg font-bold">{{ $isEditing ? 'Edit' : 'Add' }} Employee</h2>
                <form wire:submit.prevent="submit">
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700">Name:</label>
                        <input type="text" id="name" wire:model.defer="name" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                        @error('name') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700">Email:</label>
                        <input type="email" id="email" wire:model.defer="email" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                        @error('email') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-4">
                        <label for="contactNo" class="block text-gray-700">Contact No:</label>
                        <input type="text" id="contactNo" wire:model.defer="contactNo" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                        @error('contactNo') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-4">
                        <label for="dob" class="block text-gray-700">Date of Birth:</label>
                        <input type="date" id="dob" wire:model.defer="dob" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                        @error('dob') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                    </div>
                     <div class="mb-4 read-only:">
                        <label for="registerNo" class="block text-gray-700">Registered No:</label>
                        <input type="text" readonly id="registerNo" wire:model.defer="registerNo" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                        @error('registerNo') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                    </div>
                     <div class="mb-4">
                        <label for="address" class="block text-gray-700">Address:</label>
                        <textarea type="text" id="address" wire:model.defer="address" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm"></textarea>
                        @error('address') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded-md">{{ $isEditing ? 'Update' : 'Add' }}</button>
                    <button type="button" wire:click="$set('showForm', false)" class="px-4 py-2 ml-2 text-white bg-gray-500 rounded-md">Cancel</button>
                </form>
            </div>
        </div>
    @endif
    <div class="grid grid-cols-1 gap-4 mt-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
    <div class="relative">
        <input type="text" placeholder="Search..." wire:model.defer='search' class="block w-full rounded border-gray-250" />
        </div>
        <div class="relative">
        <button wire:click="searchEmployees" class="px-4 py-2 text-white bg-blue-500 rounded-md">Search</button>
        <button wire:click="clearSearchEmployees" class="px-4 py-2 text-white bg-blue-500 rounded-md">Clear</button>
        </div>
       
    </div>
    <div class="grid grid-cols-1 gap-4 mt-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
        @foreach($employees as $employee)
            @php
                // Create a DateTime object from the passed date string
                $date = new DateTime($employee->dob);

                // Format the date to 'dd-mm-yyyy'
                $new_formate = $date->format('d-m-Y');
            @endphp
            <div class="relative p-4 bg-green-500 rounded-md">
                <h3 class="font-bold text-white">{{ $employee->name }}</h3>
                <p class="text-white">Reg NO: {{$employee->register_no}}</p>
                <p class="text-white">DOB: {{$new_formate}}</p>
                <p class="text-white">Mobile: {{$employee->contact_no}}</p>
                <p class="text-white">Address: {{ $employee->address }}</p>
                <div class="absolute flex space-x-2 top-2 right-2">
                    <button wire:click="showEmployeeForm({{ $employee->id }})" class="px-2 py-1 text-white bg-yellow-500 rounded-md">Edit</button>
                    <button @click="confirmingDelete = true; $wire.confirmDelete({{ $employee->id }})" class="px-2 py-1 text-white bg-red-500 rounded-md">Delete</button>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Confirmation Dialog -->
    <div x-show="confirmingDelete"  x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-50">
        <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-lg">
            <h2 class="mb-4 text-lg font-bold">Are you sure?</h2>
            <p class="mb-4">This action cannot be undone. Do you want to proceed with deleting this employee?</p>
            <div class="flex justify-end space-x-4">
                <button @click="confirmingDelete = false" class="px-4 py-2 text-white bg-gray-500 rounded-md">Cancel</button>
                <button wire:click="delete" @click="confirmingDelete = false" class="px-4 py-2 text-white bg-red-500 rounded-md">Delete</button>
            </div>
        </div>
    </div>
</div>
