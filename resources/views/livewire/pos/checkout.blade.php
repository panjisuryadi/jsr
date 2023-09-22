<div>


        <div class="mt-2">
           
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

                <div class="px-3">
                <div class="form-group">
                    <label for="customer_id">Customer <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <a href="{{ route('customers.create') }}" class="btn bg-red-400">
                                <i class="text-white bi bi-person-plus"></i>
                            </a>
                        </div>
                        <select wire:model="customer_id" id="customer_id" class="select2 form-control">
                            <option value="" selected>Select Customer</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->customer_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="overflow-y-auto h-64 max-h-full md:max-h-screen">
              
                        @if($cart_items->isNotEmpty())
                        @php 
                          $jumlah = 0; 
                        @endphp
                            @foreach($cart_items as $cart_item)

                 {{-- {{dd($cart_item)}} --}}
                   <!-- component -->

                      <div class="bg-white text-white w-full max-w-md flex flex-col border-b rounded-md p-1">
                        <div class="flex items-center justify-between">
                          <div class="flex items-center space-x-4">
                            <div class="rounded-full w-4 h-4 border border-blue-500"></div>
                            <div class="text-md text-dark font-bold">
                               <div class="text-lg relative">{{ $cart_item->name }}
                                @include('livewire.includes.product-cart-modal') 
                               </div>
                           
                               <div style="font-size: 0.6rem;" class="text-gray-400">#{{ $cart_item->options->code }} </div>
                             </div>
                          </div>
                          <div class="flex items-center space-x-4">
                            <div class="text-gray-500 hover:text-gray-300 cursor-pointer">
                             <a href="#" wire:loading.class="opacity-50" wire:click.prevent="removeItem('{{ $cart_item->rowId }}')">
                             <i class="bi bi-x-circle font-xl text-danger"></i>
                                </a>
                            </div>
                          </div>
                        </div>
                        
                      </div>
 
                          @php
                             $jumlah = $jumlah +  $cart_item->qty
                          @endphp

                            @endforeach
                        @else
                          
                        <span class="text-danger">
                           Produk Belum di pilih
                        </span>
                            
                        @endif
                    
                </div>
          

  @php
    $total_with_shipping = Cart::instance($cart_instance)->total() + (float) $shipping;
    $qty = Cart::instance($cart_instance);
  @endphp

        </div>

{{-- batassss --}}


</div>
<div
    class="relative bg-white p-4 mx-auto w-full max-w-2xl">
    <div class="mx-auto flex w-full max-w-md flex-row justify-center">

       {{-- show modal kostumer --}}
         @include('livewire.includes.add-customer-modal') 
          <a class="hover:no-underline hover:text-red-400 text-gray-500 px-3 text-center items-center" href="#">
       
         <i class="hover:text-red-400 bi bi-card-list text-4xl text-gray-500"></i>
         <div class="py-0 font-semibold">Daftar</div>
        
        </a>

        <a class="hover:no-underline hover:text-red-400 text-gray-500 px-3 text-center items-center" href="#">
       <i class="hover:text-red-400 text-4xl text-gray-500 bi bi-box-arrow-down"></i>
         <div class="py-0 font-semibold">Simpan</div>
        
        </a>
                
    
        {{-- show modal manual --}}
         @include('livewire.includes.manual-modal') 
            <button wire:loading.class="text-gray-200" wire:click="resetCart" type="button" class="hover:no-underline hover:text-red-400 text-gray-500 px-3 text-center items-center" href="#">
        <i class="hover:text-red-400 text-4xl text-gray-500 bi bi-trash"></i>
         <div class="py-0 font-semibold">Hapus</div>
        
        </button>

        
        
        
    
    </div>
</div>



{{-- batassss --}}
<div class="px-3 py-3 bg-red-400 text-white flex justify-between">
    <div class="w-1/4 justify-center items-center border-r">
        <div class="items-center justify-center text-center text-white text-3xl font-semibold">
            <p>{{$jumlah ?? '0'}}</p>
        </div>
    </div>
    <div>
    <div class="text-white items-left text-left uppercase text-lg font-semibold">
        total
    </div>
    </div>
    <div>
        <span class="text-xl font-semibold">{{ format_currency($total_with_shipping) }}</span>
    </div>
    <div class="w-1/6 justify-center text-center items-center">
        <button wire:loading.attr="disabled" wire:click="proceed" type="button" class="text-white inline-flex items-center"><i class="text-4xl bi bi-chevron-right"></i></button>
        
    </div>
</div>




    {{--Checkout Modal--}}
    @include('livewire.pos.includes.checkout-modal')


</div>

