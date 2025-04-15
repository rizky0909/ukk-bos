<x-layout>
    <x-card>
        <form action="{{ route('userUpdate', $user->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="flex gap-3 p-5">
                <div class="w-1/2">
                    <label for="nama" class="block mb-2 text-sm font-medium text-gray-900">Nama</label>
                    <input type="text"
                        class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        name="name" value="{{ $user->name }}" />

                </div>
                <div class="w-1/2">
                    <label class="block mb-2 text-sm font-medium text-gray-900" for="email">Email</label>
                    <input
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-white focus:outline-none"
                        id="email" type="email" name="email" value="{{ $user->email }}">
                </div>
            </div>
            <div class="flex gap-3 p-5">
                <div class="w-1/2">
                    <label for="role" class="block mb-2 text-sm font-medium text-gray-900">Role</label>
                    <select id="role" name="role"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="staff" {{ $user->role == 'staff' ? 'selected' : '' }}>Staff</option>
                    </select>
                </div>
                <div class="w-1/2">
                    <label class="block mb-2 text-sm font-medium text-gray-900" for="password">Password</label>
                    <div class="relative">
                        <input
                            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-white focus:outline-none pr-10"
                            id="password" type="password" name="password">
                        <button type="button" onclick="togglePassword()" 
                            class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-600">
                            👁️
                        </button>
                    </div>
                </div>
            </div>
            <div class="flex flex-row-reverse">
                <div class="justify-end items-end">
                    <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4  font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 focus:outline-none focus:ring-blue-800">Simpan</button>
                </div>
            </div>
        </form>
    </x-card>
</x-layout>

<script>
    function togglePassword() {
        var input = document.getElementById("password");
        if (input.type === "password") {
            input.type = "text";
        } else {
            input.type = "password";
        }
    }
</script>


@if (session('error'))
    <script>
        Swal.fire({
            title: 'Error',
            text: '{{ session('error') }}',
            icon: "error",
            draggable: true
        });
    </script>
@endif
