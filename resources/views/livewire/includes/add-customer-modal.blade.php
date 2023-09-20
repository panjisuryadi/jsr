<!-- Button trigger Discount Modal -->
 <a class="hover:no-underline hover:text-red-400 text-gray-500 px-3 text-center items-center"   href="#" 
    role="button" 
    data-toggle="modal" 
    data-target="#customerModal">
        <i class="bi bi-person-plus text-4xl text-gray-500"></i>
         <div class="py-0 font-semibold">Customer</div>
        
        </a>
<!-- customer Modal -->
<div wire:ignore.self class="modal fade" id="customerModal" tabindex="-1" role="dialog" aria-labelledby="manualModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id=customerModalLabel">
                    <strong>Tambah kostumer </strong>
                    
                </h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST">
                <div class="modal-body">
               ini buat modal tambah kostumer
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn text-white bg-red-400">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
