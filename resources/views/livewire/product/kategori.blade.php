      <div>
           @if($selectedOption == 'logam-mulia')
               @include('product::categories.form.lm')
           @elseif($selectedOption == 'mutiara')
            @include('product::categories.form.mutiara')

            @else
               @include('product::categories.form.emas')
            @endif
   </div>


                  