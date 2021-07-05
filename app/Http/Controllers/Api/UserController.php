<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Product;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $offset = $request->offset ? $request->offset : 0;
        $limit = $request->limit ? $request->limit : 10;
        $qb = User::query();
        if($request->has('q'))
            $qb->where('name', 'like', '%' . $request->query('q') . '%');

        if($request->has('sortBy'))
            $qb->orderBy($request->query('sortBy'), $request->query('sort', 'DESC'));


        $data = $qb->offset($offset)->limit($limit)->get();

        $data->each(function ($item) {
           $item->setAppends(['full_name']);
        });
        //burda veri tabanında olmayan full_name kolonunu oluştrdk
        //$data->each->setAppends(['full_name']); böylede kullanılabilir

        return response($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        /*$validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'name' => 'required|string|max:100',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->apiResponse(ResultType::Error, $validator->errors(), 'doğrulama hatası', 422);
        }*/
        //ayrı bir request dosyası oluştrmadan kontrol yapmak için

        $input = $request->validated();
        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => bcrypt($input['password'])
        ]);

        return response([
            'data' =>  $user,
            'message' => 'kullanıcı eklendi'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $product = Product::findOrFail($id);
            return response($product, 200);
        }
        catch (ModelNotFoundException $exception) {
            return $this->apiResponse(ResultType::Error, null, 'Kullanıcı bulunamadı', 404);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $input = $request->all();
        $user->update([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => bcrypt($input['password'])
        ]);

        return response([
            'data' =>  $user,
            'message' => 'Kullanıcı güncellendi'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response([
            'message' => 'Kullanıcı silindi'
        ], 200);
    }

    public function custom1() {
        //$user2 = User::find(2);
        //UserResource::withoutWrapping();
        //withoutWrapping ile dönen verileri data değişkeni içerisinde dönmekten kurtarıyrz.

        //return new UserResource($user2);
        //oluşturduğumuz UserResource kullanarak bazı kolanları çektik sadece bunu tek bir kayıt için yaptık
        //dönüşte verileri data altında dönüyor

        //$users = User::all();
        //return UserResource::collection($users);
        //birden fazla veri çekerken bu şekilde kullanyrz

        //$users = User::all();
        //return UserResource::collection($users)->additional([
        //'meta' => [
        //              'total_users' => $users->count(),
        //              'custom' => 'value'
        //          ]]);
        // resource çektiğimiz veriler data içinde dönüyor. biz data değikenine ek olarak
        // meta diye kendimizin oluşturduğu bir dizi değeride döndürdük

        $users = User::all();
        return new UserCollection($users);
        // resources altındaki UserCollection kullanarak dönen veride normlade veiler data değişkeni altında dönüyordu
        // biz ona istediğimiz başka değişkenler ekledik meta bilgisi gibi
    }
}
