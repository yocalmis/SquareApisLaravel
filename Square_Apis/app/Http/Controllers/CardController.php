<?php

namespace App\Http\Controllers;

use App\Card;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CardController extends Controller
{
    //

    public function index()
    {
        $res["status"] = "query failed";
        return response()->json($res);
    }

    public function card_add(Request $request)
    {

        try {

            $validator = Validator::make($request->all(), [
                'token' => 'required|max:60',
                'tel' => 'required|max:255',
                'device' => 'required|max:255',
                'user_id' => 'required|max:255',
                'card_type' => 'required|max:24',
                'card_number' => 'required|max:16',
                'card_valid_year' => 'required|max:4',
                'card_valid_month' => 'required|max:2',
                'security' => 'required|max:3',
                'name_surname' => 'required|max:255',
            ]);

            if ($validator->fails()) {$res["status"] = "Validate Error";return response()->json($res);}

            $user = User::where('key', '=', $request->token)
                ->where('status', '=', 1)
                ->where('device', '=', $request->device)
                ->where('tel', '=', $request->tel)
                ->orWhere('email', '=', $request->tel)
                ->get();

            if (count($user) > 0) {

                $card = new Card();
                $card->user_id = $request->user_id;
                $card->card_type = $request->card_type;
                $card->card_number = $request->card_number;
                $card->card_valid = $request->card_valid_year . "-" . $request->card_valid_month;
                $card->security = $request->security;
                $card->name_surname = $request->name_surname;

                $res["status"] = ($card->save() ? "ok" : "error");

            } else {
                $res["status"] = "failed";
            }

            return response()->json($res);

        } catch (Exception $e) {

            // echo 'Yakalanan olağandışılık: ',  $e->getMessage(), "\n";
            $res["status"] = $e->getMessage();
            return response()->json($res);

        }

    }

    public function card_get(Request $request)
    {

        try {

            $validator = Validator::make($request->all(), [
                'token' => 'required|max:60',
                'tel' => 'required|max:255',
                'device' => 'required|max:255',

            ]);

            if ($validator->fails()) {$res["status"] = "Validate Error";return response()->json($res);}

            $user = User::where('key', '=', $request->token)
                ->where('status', '=', 1)
                ->where('device', '=', $request->device)
                ->where('tel', '=', $request->tel)
                ->orWhere('email', '=', $request->tel)
                ->get();

            if (count($user) > 0) {
                return Card::where('user_id', '=', $user[0]->id)->get();
            } else {
                $res["status"] = "failed";

            }
            return response()->json($res);
        } catch (Exception $e) {

            // echo 'Yakalanan olağandışılık: ',  $e->getMessage(), "\n";
            $res["status"] = $e->getMessage();
            return response()->json($res);

        }

    }

}
