<div>
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div>
                @if (session()->has('message'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <div class="alert-body">
                            <span>{{ session('message') }}</span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                    </div>
                @endif

                <div class="form-group">
                    <label for="customer_id">Customer <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <a href="{{ route('customers.create') }}" class="btn bg-red-400">
                                <i class="text-white bi bi-person-plus"></i>
                            </a>
                        </div>
                        <select wire:model="customer_id" id="customer_id" class="form-control">
                            <option value="" selected>Select Customer</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->customer_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr class="text-center">
                            <th class="text-left">Produk</th>
                            <th class="w-20 text-left">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($cart_items->isNotEmpty())
                            @foreach($cart_items as $cart_item)
                                <tr>
                                    <td class="align-left">
                                      
    <div class="relative text-sm text-gray-600 mt-1">
        <div style="font-size:0.7rem;" class="py-0 text-blue-500">{{ $cart_item->options->code }} 
           

        </div>
        <div class="text-md text-gray-700 ">
            {{ $cart_item->name }}
           @include('livewire.includes.product-cart-modal') 

        </div>
        
         
     </div>

             {{--       <span class="badge badge-success">
                                        {{ $cart_item->options->code }}
                                    </span> --}}
             
                                    </td>

                                    <td class="align-middle text-center">
                                        <a href="#" wire:click.prevent="removeItem('{{ $cart_item->rowId }}')">
                                            <i class="bi bi-x-circle font-2xl text-danger"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8" class="text-center">
                        <span class="text-danger">
                            Please search & select products!
                        </span>
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>







      {{--       <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped">
                      
                            <tr class="text-primary">
                                <th>Grand Total</th>
                                @php
                                    $total_with_shipping = Cart::instance($cart_instance)->total() + (float) $shipping
                                @endphp
                                <th>
                                    (=) {{ format_currency($total_with_shipping) }}
                                </th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
 --}}



<div
    class="relative bg-white p-6 shadow-xl mx-auto w-full max-w-2xl">
    <div class="mx-auto flex w-full max-w-md flex-row justify-center">

        <a class="hover:no-underline hover:text-red-400 text-gray-500 text-center px-3 items-center" href="#">
         <i class="bi bi-person-plus text-4xl text-gray-500"></i>
         <div class="py-0 font-semibold">Customer</div>
        </a>

      
        </a>  
          <a class="hover:no-underline hover:text-red-400 text-gray-500 px-3 text-center items-center" href="#">
       
         <i class="bi bi-card-list text-4xl text-gray-500"></i>
         <div class="py-0 font-semibold">Daftar</div>
        
        </a>

     <a class="hover:no-underline hover:text-red-400 text-gray-500 px-3 text-center items-center" href="#">
       <i class="text-4xl text-gray-500 bi bi-box-arrow-down"></i>
         <div class="py-0 font-semibold">Simpan</div>
        
        </a>
                
     <a class="hover:no-underline hover:text-red-400 text-gray-500 px-3 text-center items-center" href="#">
        <i class="text-4xl text-gray-500 bi bi-pencil-square"></i>
         <div class="py-0 font-semibold">Manual</div>
        
        </a>
            <a class="hover:no-underline hover:text-red-400 text-gray-500 px-3 text-center items-center" href="#">
        <i class="text-4xl text-gray-500 bi bi-trash"></i>
         <div class="py-0 font-semibold">Hapus</div>
        
        </a>
        
        
    
    </div>
</div>


  @php
    $total_with_shipping = Cart::instance($cart_instance)->total() + (float) $shipping
  @endphp
<div class="flex bg-red-400 py-3 px-2">
  <div class="w-1/5 border-r mt-1 text-center justify-center items-center">
     <p class="text-white px-2 py-4 text-3xl font-semibold">1</p>

  </div>
  <div class="w-1/4">
     <div class="text-white uppercase px-2 py-4 mt-2 text-xl font-semibold">
     total</div>

  </div>

  <div class="w-1/2 text-center justify-center items-center">
    <button wire:loading.attr="disabled" wire:click="proceed" type="button" class="text-white py-4 px-1 rounded inline-flex items-center" {{  $total_amount == 0 ? 'disabled' : '' }}>
    <span class="text-xl font-semibold">{{ format_currency($total_with_shipping) }}</span>
    <i class="text-4xl bi bi-chevron-right"></i>
</button>




</div>
</div>





           
       {{--      <div class="form-group d-flex justify-content-center flex-wrap mb-0">
                <button wire:click="resetCart" type="button" class="btn btn-pill btn-danger mr-3"><i class="bi bi-x"></i> Reset</button>
                <button wire:loading.attr="disabled" wire:click="proceed" type="button" class="btn btn-pill btn-primary" {{  $total_amount == 0 ? 'disabled' : '' }}><i class="bi bi-check"></i> Proceed</button>
            </div> --}}
        </div>
    </div>

    {{--Checkout Modal--}}
    @include('livewire.pos.includes.checkout-modal')

</div>

