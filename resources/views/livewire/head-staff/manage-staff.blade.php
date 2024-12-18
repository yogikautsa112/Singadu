<div class="container p-6 mx-auto">
    <!-- Card container dengan bg-white untuk latar belakang putih -->
    <div class="p-6 mb-6 bg-white shadow-lg card">
        <!-- Flex container untuk form dan tabel -->
        <div class="flex flex-row-reverse gap-6">

            <!-- Form untuk menambah staff -->
            <div class="flex-1 p-4 bg-white shadow-md card">
                <h2 class="mb-4 text-2xl font-bold text-center">Add Staff</h2>
                <form wire:submit.prevent="addStaff">
                    <div class="mb-4 form-control">
                        <label for="name" class="label">
                            <span class="label-text">Name</span>
                        </label>
                        <input type="text" id="name" wire:model="name" class="w-full input input-bordered"
                            placeholder="Enter staff name" required>
                        @error('name')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4 form-control">
                        <label for="email" class="label">
                            <span class="label-text">Email</span>
                        </label>
                        <input type="email" id="email" wire:model="email" class="w-full input input-bordered"
                            placeholder="Enter staff email" required>
                        @error('email')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-6 form-control">
                        <label for="password" class="label">
                            <span class="label-text">Password</span>
                        </label>
                        <input type="password" id="password" wire:model="password" class="w-full input input-bordered"
                            placeholder="Enter password" required>
                        @error('password')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="w-full btn btn-primary">Add Staff</button>
                </form>
            </div>

            <!-- Tabel daftar staff -->
            <div class="flex-1 p-4 bg-white shadow-md card">
                <h2 class="mb-4 text-2xl font-bold text-center">Staff List</h2>
                <table class="table w-full table-zebra">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($staffs as $staff)
                            <tr>
                                <td>{{ $staff->name }}</td>
                                <td>{{ $staff->email }}</td>
                                <td class="flex gap-2">
                                    @if (optional($staff->response)->response_status)
                                        <button disabled class="btn btn-secondary btn-sm">Already Responded</button>
                                    @else
                                        <button wire:click="deleteStaff({{ $staff->id }})"
                                            class="btn btn-error btn-sm">Delete</button>
                                        <button wire:click="resetPassword({{ $staff->id }})"
                                            class="btn btn-warning btn-sm">Reset Password</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
