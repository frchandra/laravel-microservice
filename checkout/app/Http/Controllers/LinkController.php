<?php

namespace App\Http\Controllers;

use App\Http\Resources\LinkResource;
use App\Models\Link;
use App\Services\UserService;


class LinkController extends Controller{

    public  $userService;

    public function __construct(UserService $userService){
        $this->userService = $userService;
    }

    public function show($code){
        $link = Link::with( 'products')->where('code', $code)->first();
        $user = $this->userService->get("users/{$link->user_id}");
        $link['user'] = $user;
        return $link;
    }
}
