<!-- resources/views/components/table.blade.php -->

<div class="overflow-x-auto">
    <table class="min-w-full bg-white border border-gray-200">
        <thead class="bg-gray-50">
            <tr>
                @foreach($headers as $header)
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        {{ $header }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @foreach($rows as $index => $row)
                <tr class="{{ $index % 2 === 0 ? 'bg-white' : 'bg-gray-50' }}">
                    @foreach($row as $cell)
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $cell }}
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>