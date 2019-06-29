@extends('layouts.top')

@section('content')
<div class="container">
    <br><br>
    <div class="row">

        <div class="col-md-3">
            <img src="{{ asset('image_files/'.$product['image_url']) }}" alt="..." class="img-thumbnail">
        </div>
        
        <div class="col-md-9">
            <h3>
                {{ $product->name }}
            </h3>
            <h5>
               Rp. {{ number_format($product->price) }}
            </h5>

            <!-- count -->
            view :
            {{$product->view}}
            <br>
            <!-- rating -->
            @for($i = 1; $i<=5; $i++)
                @if($i <= $rating)
                <span class="fa fa-star checked"></span>
                @else
                <span class="fa fa-star"></span>
                @endif
            @endfor
            
            <div class="mt-2">
                <a href="https:://www.facebook.com/sharer/sharer.php?u={{ route('products.show', ['id' => $product['id']]) }}" class="social-button" target="_blank">
                    <span class="fa fa-facebook"></span> 
                </a> 
                <a href="https:://www.twitter.com/intent/tweet?text=my share text&amp;url={{ route('products.show', ['id' => $product['id']]) }}" class="social-button" target="_blank">
                    <span class="fa fa-twitter"></span> 
                </a> 
                <a href="https:://www.linkedin.com/shareArticle?mini=true&amp;url={{ route('products.show', ['id' => $product['id']]) }}&amp;title=my share text&amp;summary=dit is de linedin summary" class="social-button" target="_blank">
                    <span class="fa fa-linkedin"></span> 
                </a> 
                <a href="https:://www.wa.me/?text={{ route('products.show', ['id' => $product['id']]) }}" class="social-button" target="_blank">
                    <span class="fa fa-whatsapp"></span> 
                </a>
            </div>

            <div class="mt-4">
                <a href="{{ route('carts.add', ['id' => $product['id']]) }}" class="btn btn-primary"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Beli</a>
            </div>
            
            <div class="mt-4">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a href="#description" class="nav-link active" role="tab" data-toggle="tab">Informasi Produk</a>
                    </li>
                    <li class="nav-item">
                        <a href="#rate" class="nav-link" role="tab" data-toggle="tab">Review Produk</a>
                    </li>
                    <li class="nav-item">
                        <a href="#review" class="nav-link" role="tab" data-toggle="tab">Ulasan</a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content mt-2">
                    <div class="tab-pane fade in active show" id="description" role="tabpanel">
                        {!! $product->description !!}
                    </div>
                    <div class="tab-pane fade" role="tabpanel" id="rate">
                        <form id="form_review" action="{{ route('products.store', ['id' => $product->id]) }}" method="POST">
                        @csrf
                            <div class="form-group">
                                <input type="hidden" name="product_id" value="{{ $product->id }}" id="product_id">
                                <label><strong>Rating Produk</strong></label><br>
                                <!-- rating radio -->
                                <input type="radio" name="rating" value="1">1 <br> 
                                <input type="radio" name="rating" value="2">2 <br>
                                <input type="radio" name="rating" value="3">3 <br>
                                <input type="radio" name="rating" value="4">4 <br>
                                <input type="radio" name="rating" value="5">5 <br>
                                <div class="form-group">
                                    <label>Deskripsi</label>
                                    <textarea name="description" class="form-control" rows="3" placeholder="Deskripsi" id="ckview"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                        <br><br>
                    </div>
                    <div class="tab-pane fade" role="tabpanel" id="review"><br>
                        @foreach($reviews as $review)
                        <div class="row blockquote review-item"><br>
                            <div class="col-md-3 text-center">
                            <img class="rounded-circle reviewer" src="http://standaloneinstaller.com/upload/avatar.png">
                            <div class="caption">
                                <small>by <a href="#">{{$review->user->name}}</a></small>
                            </div>

                            </div>
                            <div class="col-md-9">
                            <h5>Review Produk</h5>
                            <div class="ratebox text-center" data-id="0" data-rating="5"></div>
                            <p class="review-text">{!! $review->description !!}
                                <small class="review-date">{{date('d-m-Y', strtotime($review->created_at))}}</small>
                            </div>                          
                        </div>  
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


<script src="{{ url('plugins\tinymce\jquery.tinymce.min.js') }}"></script>
<script src="{{ url('plugins\tinymce\tinymce.min.js') }}"></script>
<style>
.checked {
  color: orange;
}
</style>
<!-- tinymce js -->
<script>
tinymce.init({ selector:'#ckview' });
</script>

 <script type="text/javascript">
    $('#form_review').on('submit', function(e) {
       e.preventDefault(); 
       var productId = $('#product_id').val();
       var desc = tinyMCE.activeEditor.getContent();
       var rating = $('input[name="rating"]:checked').val();
       $.ajax({
           type: "GET",
            data: {id:productId, description:desc, rating:rating},
            url: "{{route('ajax.products.review')}}",
            success: function(html) {
                $("#review").html(html);
            }
       });
   });
  </script>
  @endsection