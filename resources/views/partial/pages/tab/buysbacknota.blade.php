<div class="pt-3">

                   <table style="width: 100%;" class="table table-striped table-bordered">
                        <tr>
                            <th class="text-center">{{ label_case('No') }}</th>
                            <th class="text-center">{{ label_case('Date') }}</th>
                            <th>{{ label_case('invoice_no') }}</th>
                            <th>{{ label_case('Invoice Series') }}</th>
                            <th>{{ label_case('Cabang') }}</th>
                            <th>{{ label_case('Pic') }}</th>
                         
                        </tr>
        @php
        $buybacknota =\Modules\BuysBack\Models\BuyBackNota::latest()->paginate(10);
       @endphp

                    @forelse($buybacknota as $row)
                           <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ shortdate($row->date) }}</td>
                                <td>{{ $row->invoice }}</td>
                                <td>{{ $row->invoice_series }}</td>
                                <td>{{ @$row->cabang->name }}</td>
                                <td>{{ @$row->pic->name }}</td>
                          
                        </tr>
                        @empty
                           <tr>
                                <td colspan="6"> <p class="uppercase">Tidak ada Data</p></td>

                            </tr>
                        @endforelse

                    </table>
                     @if($buybacknota->links()->paginator->hasPages())
                    <div class="has-text-centered">
                        {{ $buybacknota->links() }}
                    </div>
                    @endif


            </div>