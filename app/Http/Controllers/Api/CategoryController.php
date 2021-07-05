<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends ApiController
//apiController burda kullanabilmek için extends değiştirdik
//böylece hem ApiController hem normal Controller kullanablyrz
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return response(Category::all(), 200);
        return $this->apiResponse(ResultType::Success,Category::all(), 'Kategoriler çekildi', 200);
        //burda kendi özel response tanımımızı oluşturduk ApiController içinde ve onu kullandık
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
        $category = Category::create($input);

        return response([
            'data' =>  $category,
            'message' => 'kategori eklendi'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return response($category, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $input = $request->all();
        $category->update($input);

        return response([
            'data' =>  $category,
            'message' => 'kategori güncellendi'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return response([
            'message' => 'kategori silindi'
        ], 200);
    }

    public function custom1() {
        //return Category::pluck('id');
        //pluck sadece belirli bir kolonu çekmeyi sağlar.

        return Category::pluck('id', 'name');
        // category tablosundaki id değerlerini önünde name değerleri olacak şekilde getrr
    }

    public function report1() {
        return DB::table('product_categories as pc')
            ->selectRaw('c.name, COUNT(*) as total')
            ->join('categories as c', 'c.id', '=', 'pc.category_id')
            ->join('products as p', 'p.id', '=', 'pc.product_id')
            ->groupBy('c.name')
            ->orderByRaw('COUNT(*) DESC')
            ->get();
    }
}
