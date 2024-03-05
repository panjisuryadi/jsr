   <!DOCTYPE html>
   <html>
   <head>
     
       <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
       <title>Detail Excel</title>
        @include('includes.main-css')

   </head>


   <body>


<table cellpadding="5">
                <thead>
                    <tr>
                    <th style='background-color: #f952a7; color: #ffffff;'>
                        <p>
               Laporan Excel Distribusi Toko |  {{ tgl(date('Y-m-d H:i')) }}
                        </p>
                    </th>
                      
                    </tr>
                </thead>
               
            </table>
    

 @if ($dist_toko->isInProgress())
     @include ("distribusitoko::distribusitokos.cabang.cetak.excel_draft")
    @elseif ($dist_toko->isRetur())
      {{-- @livewire('distribusi-toko.cabang.retur',['dist_toko' => $dist_toko]) --}}
        @include ("distribusitoko::distribusitokos.cabang.cetak.excel_retur")
    @elseif ($dist_toko->isCompleted())
        @include ("distribusitoko::distribusitokos.cabang.cetak.excel_completed")
    @elseif ($dist_toko->isDraft())
        @include ("distribusitoko::distribusitokos.cabang.cetak.excel_draft")
    @endif


   </body>
   </html>




                          