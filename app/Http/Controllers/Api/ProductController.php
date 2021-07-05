<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductWithCategoriesResource;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
     */
    public function index(Request $request)
    {
        //return Product::all();
        //return response(Product::all(), 200);
        //return response()->json(Product::all(), 200);

        $offset = $request->offset ? $request->offset : 0;
       $limit = $request->limit ? $request->limit : 10;


        $qb = Product::query()->with('categories');
        //with ile eager loading ile productların kategorisini çektik
        // query ile product tablosunda bir sorgu yapacağımızı söylüyrz
        if($request->has('q'))
            $qb->where('name', 'like', '%' . $request->query('q') . '%');
//q isminde değişkenle bir kelime yollayıp name e göre arattık

        if($request->has('sortBy'))
            $qb->orderBy($request->query('sortBy'), $request->query('sort', 'DESC'));
        // sortBy ve sort değişkenlerini yollayarak sırlama yaptrdk



           // return response()->json(Product::offset($offset)->limit($limit)->get(), 200);
        //offset ve limit ile veritabanından belirli aralıktaki veriyi çekebltrz

        $data = $qb->offset($offset)->limit($limit)->get();

        $data = $data->makeHidden('slug');
        //slug kolonunu gizledim

        return response($data, 200);


        //return response()->json(Product::paginate(10), 200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $product = Product::create($input);

        return response([
           'data' =>  $product,
            'message' => 'ürün eklendi'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)//Model binding kullanıldı kendi gönderilen idye göre otomatik  buluyor
    {
        //return $product;
        return response($product, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $input = $request->all();
        $product->update($input);

        return response([
            'data' =>  $product,
            'message' => 'ürün güncellendi'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response([
            'message' => 'ürün silindi'
        ], 200);
    }

    public function custom1() {
        //return Product::select('id', 'name')->orderBy('created_at', 'desc')->take(10)->get();
        return Product::selectRaw('id as product_id, name as product_name')->orderBy('created_at', 'desc')->take(10)->get();

    }

    public function custom2() {
        $products = Product::orderBy('created_at', 'desc')->take(10)->get();

        $mapped = $products->map(function ($product) {
            return [
              '_id' => $product['id'],
               'product_name' => $product['name'],
               'product_price' => $product['price'] * 1.03
            ];
        });
        //sadece istediğimiz kolonları çektik

        return $mapped->all();
    }

    public function custom3() {
        $products = Product::paginate(10);

        return ProductResource::collection($products);
        //ProductResource kullanarak Product tablosundan sadece istediğimiz  verileri çektik
        //ayrıca sayfalandırma yaptık
    }

    public function listwithcategories() {
        //$products = Product::paginate(10);
        $products = Product::with('categories')->paginate(10);


        return ProductWithCategoriesResource::collection($products);
        //ürünlerin ait olduğu kategorilerle beraber çektik veriyi

    }
}
