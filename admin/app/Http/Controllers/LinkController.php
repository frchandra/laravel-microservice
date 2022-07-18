<?php

namespace App\Http\Controllers;

use App\Http\Resources\LinkResource;
use App\Jobs\LinkCreated;
use App\Models\Link;
use App\Models\LinkProduct;
//use App\Services\UserService;
//use Illuminate\Http\Request;
//use Illuminate\Support\Str;
//use Services\UserService;

class LinkController extends Controller{

//    public  $userService;
//
//    public function __construct(UserService $userService){
//        $this->userService = $userService;
//    }

    public function index($id){
        $links = Link::with('orders')->where('user_id', $id)->get();
        return LinkResource::collection($links);
    }

//    public function store(Request $request){
//        $user = $this->userService->get('user');
//        $link = Link::create([
//            'user_id' => $user['id'],
//            'code' => Str::random(6)
//        ]);
//
//        $linkProducts = [];
//
//        foreach ($request->input('products') as $product_id) {
//            $linkProduct = LinkProduct::create([
//                'link_id' => $link->id,
//                'product_id' => $product_id
//            ]);
//            $linkProducts[] = $linkProduct->toArray();
//        }
//
//        $array = $link->toArray();
//        $array['link_product'] = $linkProducts;
//        LinkCreated::dispatch($array)->onQueue('checkout_topic');
//
//        return $link;
//    }

//    public function show($code){ //already moved to another ms
//        $link = Link::with( 'products')->where('code', $code)->first();
//        $user = $this->userService->get("users/{$link->user_id}");
//        $link['user'] = $user;
//        return $link;
//    }
}
