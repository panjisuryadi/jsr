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

<div
    class="relative bg-white px-2 py-3 mx-auto w-full max-w-2xl">
     <div class="grid grid-cols-1 md:grid-cols-5 lg:grid-cols-5 gap-1">

       {{-- show modal kostumer --}}
    <div class="text-center justify-items-center">
         @include('livewire.includes.add-customer-modal') 
    </div>
<div class="text-center justify-items-center">
    <button class="ml-2 hover:no-underline hover:text-red-400 text-gray-500  text-center items-center" href="#">
         <i class="hover:text-red-400 bi bi-card-list md:text-4xl text-4xl text-gray-500"></i>
         <div class="lg:text-sm md:text-sm text-xl py-0 font-semibold">Daftar</div>
      
        </button>   
</div>
       
 

<div class="px-1 text-center justify-items-center">
     @include('livewire.pos.simpan-modal')
</div>
    
        {{-- show modal manual --}}
<div class="px-1 text-center justify-items-center">
         @include('livewire.includes.manual-modal') 
</div>
<div class="px-1 text-center justify-items-center">
            <button wire:loading.class="text-gray-200" wire:click="resetCart" type="button" class="hover:no-underline hover:text-red-400 text-gray-500 px-3 text-center items-center" href="#">
        <i class="hover:text-red-400 text-4xl text-gray-500 bi bi-trash"></i>
         <div class="lg:text-sm md:text-sm text-xl py-0 font-semibold">Hapus</div>
        </button>
        </div>

        
        
        
    
    </div>
</div>

{{-- batassss --}}
<div class="px-3 py-3 bg-red-400 text-white flex justify-between">
    <div class="w-1/4 justify-center items-center border-r">
        <div class="items-center justify-center text-center md:text-xl text-white text-3xl font-semibold">
            <p>{{$jumlah ?? '0'}}</p>
        </div>
    </div>
    <div>
    <div class="text-white items-left text-left uppercase md:text-sm lg:text-lg font-semibold">
        total
    </div>
    </div>
    <div>
        <span class="md:text-base lg:text-xl text-xl font-semibold">{{ format_currency($total_with_shipping) }}</span>
    </div>
    <div class="w-1/6 justify-center text-center items-center">
        <button wire:loading.attr="disabled" wire:click="proceed" type="button" class="text-white inline-flex items-center"><i class="text-4xl bi bi-chevron-right"></i></button>
        
    </div>
</div>


</div>




    {{--Checkout Modal--}}
    @include('livewire.pos.includes.checkout-modal')


</div>

