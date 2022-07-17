<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $orders = \DB::connection('mysql_old')->table('orders')->get();

        foreach ($orders as $order) {
            Order::create([
                'id' => $order->id,
                'code' => $order->code,
                'transaction_id' => $order->transaction_id,
                'first_name' => $order->first_name,
                'last_name' => $order->last_name,
                'email' => $order->email,
                'user_id' => $order->user_id,
                'ambassador_email' => $order->ambassador_email,
                'address' => $order->address,
                'city' => $order->city,
                'country' => $order->country,
                'zip' => $order->zip,
                'complete' => $order->complete,
                'created_at' => $order->created_at,
                'updated_at' => $order->updated_at,
            ]);
        }
    }
}
