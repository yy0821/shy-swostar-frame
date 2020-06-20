<?php

namespace App\Http\Controllers;

use SwoStar\Database\DB;

class IndexController
{
    public function index()
    {
        $data = DB::name('record')->where('send_id = 7')->order('id DESC')->limit(5)->select();
        return var_export($data);
    }

    public function demo()
    {
        return "this http demo controller";
    }

    public function config()
    {
        return config();
    }
}