<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //

    public function index()
    {
        $res["status"] = "query failed";
        return response()->json($res);
    }

    public function categories_get(Request $request)
    {

        try {

            return response()->json(Category::all());
        } catch (Exception $e) {

            // echo 'Yakalanan olağandışılık: ',  $e->getMessage(), "\n";
            $res["status"] = $e->getMessage();
            return response()->json($res);

        }

    }

}
