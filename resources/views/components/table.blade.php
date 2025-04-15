<table id="myTable" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 mt-10 ">
    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            @foreach ($headers as $header)
                <th scope="col" class="px-6 py-3">
                    {{ $header }}
                </th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
            <td class="px-6 py-4">
                {{ $slot }}
            </td>
        </tr>
    </tbody>
</table>
