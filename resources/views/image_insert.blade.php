@extends('layouts.top')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12"><h3>Insert Image</h3></div>
        <div class="col-md-12">
            <form action="{{route('image_save')}}" method="POST" enctype="multipart/form-data">
            csrf
            </form>
        </div>
    </div>
</div>