<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ProductRequest;


class ProductController extends Controller
{
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index() {
    return Product::all();
  }

  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function store(ProductRequest $request) {
    /*$validator = Validator::make($request->all(), [
      'name' => 'required|string',
      'price' => 'required|numeric'
    ]);
    if ($validator->fails()) {
      return $validator->errors();
    } else {
      $product = Product::create($request->only('name', 'price'));
      return $product;
    }*/
    $product = Product::create($request->only('name', 'price'));
      return $product; 
  }

  /**
  * Display the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function show(Product $product) {
    return $product;
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request,Product $product) {
        $validator = Validator::make($request->all(), [
      'name' => 'nullable|string',
      'price' => 'nullable|numeric'
    ]);
    if($validator->fails()){
      return $validator->errors();
    }else{
    $product->update($request->only('name', 'price'));
    return $product;
    }
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function destroy(Product $product) {
    return $product->delete();
  }
}