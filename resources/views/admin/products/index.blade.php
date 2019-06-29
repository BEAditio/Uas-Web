@extends('layouts.top')
  @section('content')
  
  
    <div class="container">
    <h4 class="">List Product Users</h1>
      <div class="row-mt-4">
          <div class="col-md-4 offset-md-8">
              <div class="form-group">
                  <select id="order_field" class="form-control">
                      <option value="" disabled selected>Urutkan</option>
                      <option value="best_seller">Best Seller</option>
                      <option value="terbaik">Terbaik</option>
                      <option value="termurah">Termurah</option>
                      <option value="termahal">Termahal</option>
                      <option value="terbaru">Terbaru</option>
                      <option value="banyak_lihat">banyak lihat</option>
                      
                  </select>
              </div>
          </div>
        </div>
        </div>
        <div id="product-list">
        @foreach($products as $idx => $product)
            @if($idx == 0 | $idx % 4 == 0)
            <div class="row mt-4">
              @endif

              <div class="col-md-3">
                <div class="card">
                  @if(!empty($product))
                  <img src="{{ asset('/image_files/'.$product->image_url) }}" class="card-img-top" alt="" >
                  @endif
                  <div class="card-body">
                    <h5 class="card-title">
                      <a href="{{ route('admin.products.show', ['id' => $product->id]) }}">
                        {{ $product->name }}
                      </a>

                    </h5>
                    <p class="card-text">
                     Rp. {{ number_format($product->price, 2) }}
                    </p>
                    <td>
                        
                          <form action="{{route('admin.products.destroy',$product->id)}}" method="post">
                              @csrf
                              @method('Delete')
                              <a href="{{route('admin.products.edit',$product->id)}}" class="btn btn-primary">Edit</a>
                              <button class="btn btn-warning" onclick="return confirm('Yakin Mau di Hapus ?')" type="submit">Delete</button>
                          </form>
                      </td>
                  </div>
                </div>

              </div>
              @if($idx > 0 && $idx %4 ==3)
            </div>
            @endif
          @endforeach
    </div>


<!-- Jquery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#order_field').change(function(){    
        // window.location.href='/?order_by' + $(this).val();
        $.ajax({
            type:'GET',
            url:'/admin/products',
            data:{
                order_by: $(this).val(),
            },
            dataType:'json',
            success:function(data){
                var products ='';
                $.each(data,function(idx,product){
                    if(idx == 0 || idx % 4 == 0){
                        products += '<div class="row mt-4">';
                    }
                    products += '<div class="col-md-3">'+
                    '<div class="card">'+'<img src="/image_files/'+ product.image_url+'" class="card-img-top" alt="...">'+
                    '<div class="card-body">'+
                        '<h5 class="card-title">'+
                            '<a href="/admin.products/'+product.id+'">'+
                            product.name+
                            '</a>'+
                        '</h5>'+
                        '<p class="card-text">'+
                        'Rp. '+product.price+'.00'+
                        '</p>'+
                        '<a href="/admin/products/'+product.id+'/edit" class="btn btn-primary">Edit</a>'+
                        '<a href="/admin/products/destroy/'+product.id+'" class="btn btn-warning">Delete</a>'+
                    '</div>'+
                '</div>'+
            '</div>';
            if(idx > 0 && idx % 4 == 3){
                products += '</div>';
                }
            });
        // update element
        $('#product-list').html(products);
            },
            error:function(data){
                alert('Unable to handle request');
            }
        });
    });
});
</script>
@endsection