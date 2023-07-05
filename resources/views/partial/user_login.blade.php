<div class="w-full overflow-hidden rounded-lg shadow-xs">
    <div class="w-full overflow-x-auto">
        <table class="w-full whitespace-no-wrap">
             <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                @foreach($userlogin as $row)

             {{--    {{ $row }} --}}
                <tr class="text-gray-700 dark:text-gray-400">

                    <td class="px-1 py-2 text-xs">
                        <div>
                            <div class="font-semibold">{{ $row->name }}</div>
                            <div class="text-xs text-gray-600">{{ $row->os }} ,{{ $row->browser }}</div>
                            <div class="text-xs text-gray-600">{{ $row->ip }}</div>
                           <div class="text-sm text-gray-600"> {{ @$data["location"]['cityName'] }}</div>
                            <div class="text-xs text-gray-600"> {{ tgl($row->created_at)}}</div>
                            <div class="text-xs text-blue-600">
                                {{ \Carbon\Carbon::parse($row->created_at)->diffForHumans() }}
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>