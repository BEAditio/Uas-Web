@extends('layouts.top')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <h2>Edit Product</h2>
            <br/>
            @if(count($errors))
                <div class="form-group">
                    <div clas="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
            <br/>

            <form action="{{ route('admin.products.update',$products->id) }}" method="POST">
                {{ csrf_field() }}
                @method('PATCH')
                <div class="form-group">
                    <label>Nama Produk</label>
                    <input type="text" name="name" class="form-control" placeholder="Nama Produk" value="{{$products->name}}">
                </div>
                <div class="form-group">
                    <label>Harga</label>
                    <input type="number" name="price" class="form-control" placeholder="Harga" value="{{$products->price}}">
                </div>
                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea id="ckview" name="description" class="form-control" rows="3" placeholder="Deskripsi">{{$products->description}}</textarea>
                </div>
                <div class="form-group">
					<label>Image</label>
					<input type="file" name="image_url" class="form-control" value="{{$products->image_url}}">
				</div>
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-primary">Back</a>
            </form>        
        </div>
    </div>
</div>
@endsection

<script src="{{url('plugins/tinymce/jquery.tinymce.min.js')}}"></script>
<script src="{{url('plugins/tinymce/tinymce.min.js')}}"></script>
<script>tinymce.init({ selector: '#ckview' });</script>