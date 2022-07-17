<?php

namespace Database\Seeders;

use App\Models\Link;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $links = \DB::connection('mysql_old')->table('links')->get();

        foreach ($links as $link) {
            Link::create([
                'id' => $link->id,
                'code' => $link->code,
                'user_id' => $link->user_id,
                'created_at' => $link->created_at,
                'updated_at' => $link->updated_at,
            ]);
        }
    }
}
