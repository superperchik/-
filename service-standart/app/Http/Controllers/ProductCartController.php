<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCart;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductCartController extends Controller
{
    public function addProduct($product)
    {
        $api_token = str_replace('Bearer','',$_SERVER['HTTP_AUTHORIZATION']);
        $api_token = str_replace(' ','',$api_token);

        $user = User::where('api_token', $api_token)->first();

        ProductCart::updateOrCreate([
            'user_id' => $user['id'],
            'product_id' => $product,
        ]);
        //dd($user['id'], $product);
        return [
            'data' =>[
                'message' =>"продукт добавлен в корзину",
            ]
        ];
    }
    public function show()
    {
        $api_token = str_replace('Bearer','',$_SERVER['HTTP_AUTHORIZATION']);
        $api_token = str_replace(' ','',$api_token);
        $user = User::where('api_token', $api_token)->first();

        $cart = ProductCart::where('user_id', $user['id'])->get();
        foreach ($cart as $item)
        {
            $product = Product::where('id',$item['product_id'])->first();
            $productsCart = [
               'id'=>$item['id'],
               'product_id'=>$product['id'],
               'description'=>$product['description'],
                'price'=>$product['price'],
            ];
        }
        if (empty($productsCart)) return [
            'data' =>[
                'message' =>'Нет заказов'
            ]
        ];
        return [
            'data' =>[
                $productsCart
            ]
        ];
    }
    public function remove($productCart)
    {
        $api_token = str_replace('Bearer','',$_SERVER['HTTP_AUTHORIZATION']);
        $api_token = str_replace(' ','',$api_token);
        $user = User::where('api_token', $api_token)->first();
        $cart = ProductCart::where('user_id', $user['id'])->get();
        foreach ($cart as $item)
        {
            if ($item['product_id'] == $productCart )
            {
                DB::table('products_cart')->where('product_id', '=', $productCart)->delete();
                return [
                    'data' =>[
                        'message' =>"Продукт удален из корзины",
                    ]
                ];
            }
        }
        return [
            'error' =>[
                'code' =>403,
                'message' =>"Продукт не найден в корзине",
            ]
        ];



    }
}
