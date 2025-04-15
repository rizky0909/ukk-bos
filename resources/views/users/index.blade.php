<x-layout>

    <x-card>

        <div class="flex justify-between items-center">
            <span class="text-4xl">Users</span>
            <a href="{{ route('userCreate') }}">
                <button type="button"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    Tambah Users
                </button>
            </a>
        </div>
        <br>
        <form method="GET" >
            <input type="text" name="search" placeholder="Cari..." value="" class="mb-4 px-4 py-2 border rounded w-1/3">
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Cari</button>
        </form>
        <x-table :headers="['Nama', 'Email', 'Role', 'Action']">
            @foreach ($users as $user)
                <tr
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4 text-gray-900 dark:text-white">
                        {{ $user->name }}
                    </td>
                    <td class="px-6 py-4 text-gray-900 dark:text-white">
                        {{ $user->email }}
                    </td>
                    <td class="px-6 py-4 text-gray-900 dark:text-white">
                        {{ $user->role }}
                    </td>
                    <td class="px-6 py-4 space-x-3">
                        <div class="flex gap-5">
                            <a href="{{ route('userEdit', $user->id) }}"
                                class="font-medium text-blue-300 dark:text-blue-500 hover:underline">
                                Edit
                            </a>
                            <form action="{{ route('userDelete', $user->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="font-medium text-red-600 dark:text-red-500 hover:underline">
                                    Remove
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-table>
    </x-card>
    @if (session('success'))
        <script>
            Swal.fire({
                title: 'Success',
                text: '{{ session('success') }}',
                icon: "success",
                draggable: true
            });
        </script>
    @endif
</x-layout>
