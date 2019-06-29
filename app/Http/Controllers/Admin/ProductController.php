<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Images;
use Auth;
use Image;
use DB;

class ProductController extends Controller
{
    
    /**
     * Create a new controller instance.    
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request )
    {
        if(Auth::check()){
            //Product::countingView($id);
            $productInstance= new Product();
            $products = $productInstance->orderProducts($request->get('order_by'));
            if($request->ajax()){
                return response()->json($products, 200);
              
            }
            
            return view('admin.products.index', compact('products'));
        }

         $images = Image::all();
         return view('image_gallery',['images'=>$images]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(),
        [
            'name' => 'required|unique:products,name',
            'price' => 'required|numeric',
            'description' => 'required',
        ]);

        // $images = array();
        // if($request->hasfile('image_url'))
        // {
        //     foreach ($request->file('image_url') as $image)
        //     {
        //         $newName=$image->getClientOriginalName();
        //         $image->move(public_path('gambar'),$newName);
        //         $images[]=$newName;
        //     }
        // }
            if($request->hasFile('image_url')){
            $file=$request->file('image_url');
            $ext = $file->getClientOriginalExtension();

            $dateTime = date('Ymd_his');
            $newName = 'image_'.$dateTime.'.'.$ext;

            $file->move(public_path(env('PATH_IMAGE')), $newName);
            }
        //fungsi store
        $product=new Product();
        $product->user_id=Auth::user()->id;
        $product->name=$request->post('name');
        $product->price=$request->post('price');
        $product->description=$request->post('description');
        $product->image_url= $newName;
        $product->save();

        return redirect('admin/products')->with('success','Produk berhasil di simpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //fungsi show berdasarkan id yang di pilih
        $products=Product::find($id);
        return view('admin.products.show',compact('products'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //fungsi edit untuk mengambil data ecommerce sesuai id yang dipilih
        $products=Product::find($id);
        return view('admin.products.edit',compact('products'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //fungsi untuk update
        // $this->validate(request(),
        // [
        //     'name'=>'required|unique:products,name',
        //     'price'=>'required|numeric',
        //     'description'=>'required',
        // ]);

        //fungsi update
        $product = Product::find($id);
        $product->name = $request->get('name');
        $product->price = $request->get('price');
        $product->description = $request->post('description');
        $product->save();

        return redirect('admin/products')->with('success','Produk berhasil di update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //fungssi delete
        $product=Product::find($id);
        $product->delete();

        return redirect('admin/products')->with('success', 'Produk berhasil di hapus');
    }

    public function viewImage($fileImage)
    {
        $filepath = storage_path(env('PATH_IMAGE').$fileImage);
        return Image::make($filePath)->response();
    }
}