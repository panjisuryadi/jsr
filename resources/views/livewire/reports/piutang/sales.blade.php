<div>
    <table class="table min-w-full mb-4">
        <thead>
        <tr>
            <th wire:click="sortByColumn('id')" class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 tracking-wider">
                Tanggal
                @if ($sortColumn == 'id')
                    <i class="fa fa-fw fa-sort-{{ $sortDirection }}"></i>
                @else
                    <i class="fa fa-fw fa-sort" style="color:#DCDCDC"></i>
                @endif
            </th>
            <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 tracking-wider">
                No Penjualan Sales
               
                    <i class="fa fa-fw fa-sort" style="color:#DCDCDC"></i>
                
            </th>
            <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 tracking-wider">
                Total Berat
                
                    <i class="fa fa-fw fa-sort" style="color:#DCDCDC"></i>
            </th>
            <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 tracking-wider">
                Total Nominal
                
                    <i class="fa fa-fw fa-sort" style="color:#DCDCDC"></i>
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($penjualan_sales as $sale)
            <tr>
                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500 text-sm leading-5">{{ $sale->date }}</td>
                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500 text-sm leading-5">{{ $sale->invoice_no }}</td>
                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500 text-sm leading-5">{{ $sale->total_weight }}</td>
                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500 text-sm leading-5">${{ number_format($sale->total_nominal, 2) }}</td>
                
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $penjualan_sales ->links() }}
</div>
