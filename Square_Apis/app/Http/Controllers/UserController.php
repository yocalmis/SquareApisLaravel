<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{
    //
    public function index()
    {
        $res["status"] = "query failed";
        return response()->json($res);
    }

    public function register_old(Request $request)
    {

        try {

            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'username' => 'required|unique:users|max:255|email:rfc,dns',
                'password' => 'required|max:255',
                'surname' => 'required|max:255',
            ]);

            if ($validator->fails()) {$res["status"] = "Validate Error";return response()->json($res);}

            $user = new User();
            $user->name = $request->name;
            $user->surname = $request->surname;
            $user->username = $request->username;
            $user->password = md5($request->password);
            $user->email = $request->username;
            $user->status = 1;
            $user->member_type = 0;
            $user->parent_id = 0;
            $user->start_date = date("Y-m-d H:i:s");
            $yil = date("Y");
            $yil = $yil + 20;
            $user->finish_date = $yil . "-" . date("m-d H:i:s");
            $res["status"] = ($user->save() ? "ok" : "error");
            return response()->json($res);

        } catch (Exception $e) {

            // echo 'Yakalanan olağandışılık: ',  $e->getMessage(), "\n";
            $res["status"] = $e->getMessage();
            return response()->json($res);

        }

    }

    public function register(Request $request)
    {

        try {

            $validator = Validator::make($request->all(), [
                'tel' => 'required|unique:users|max:14',
                'password' => 'required|max:255',
            ]);

            if ($validator->fails()) {$res["status"] = "Validate Error";return response()->json($res);}

            $token = Str::random(60);
            $user = new User();
            $user->tel = $request->tel;
            $user->password = md5($request->password);
            $user->status = 0;
            $user->member_type = 0;
            $user->parent_id = 0;
            $user->business_id = 0;
            $user->login_code = 847404; //rand(100000,999999);
            $user->start_date = date("Y-m-d H:i:s");
            $user->key = $token;
            $yil = date("Y");
            $yil = $yil + 20;
            $user->finish_date = $yil . "-" . date("m-d H:i:s");
            $res["status"] = ($user->save() ? "ok" : "error");
            $res["token"] = $token;

            //sms gönder login_code

            return response()->json($res);

        } catch (Exception $e) {

            // echo 'Yakalanan olağandışılık: ',  $e->getMessage(), "\n";
            $res["status"] = $e->getMessage();
            return response()->json($res);

        }

    }

    public function register_ok(Request $request)
    {

        try {

            $validator = Validator::make($request->all(), [
                'sms_code' => 'required|max:6',
            ]);

            if ($validator->fails()) {$res["status"] = "Validate Error";return response()->json($res);}

            $user = User::where('login_code', $request->sms_code)
                ->where('key', '=', $request->token)
                ->update(['status' => 1, 'login_code' => 1]); // ,'login_code' => 1
            $res["status"] = "ok";
            return response()->json($res);

        } catch (Exception $e) {

            // echo 'Yakalanan olağandışılık: ',  $e->getMessage(), "\n";
            $res["status"] = $e->getMessage();
            return response()->json($res);

        }

    }

    public function login(Request $request)
    {

        try {

            $validator = Validator::make($request->all(), [
                'tel' => 'required|max:14',
                'password' => 'required|max:255',
                'device' => 'required|max:255',
            ]);

            if ($validator->fails()) {$res["status"] = "Validate Error";return response()->json($res);}

            $user = User::where('password', '=', md5($request->password))
                ->where('status', '=', 1)
                ->where('tel', '=', $request->tel)
                ->orWhere('email', '=', $request->tel)
                ->get();

            if (count($user) > 0) {

                $token = Str::random(60);
                User::where('password', '=', md5($request->password))
                    ->where('status', '=', 1)
                    ->where('tel', '=', $request->tel)
                    ->orWhere('email', '=', $request->tel)
                    ->update(['key' => $token, 'device' => $request->device]);

                $res["status"] = "ok";
                $res["token"] = $token;
                $res["username"] = $user[0]->username;
                $res["name"] = $user[0]->name;
                $res["surname"] = $user[0]->surname;
                $res["tel"] = $user[0]->tel;
                $res["id"] = $user[0]->id;
                $res["member_type"] = $user[0]->member_type;
                $res["parent_id"] = $user[0]->parent_id;

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

    public function info(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'token' => 'required|max:60',
                'username' => 'required|max:255',
                'name' => 'required|max:255',
                'surname' => 'required|max:255',
                'email' => 'required|max:255',
                'tel' => 'required|max:14',
                'adress' => 'required|max:255',
                'device' => 'required|max:255',
            ]);

            if ($validator->fails()) {$res["status"] = "Validate Error";return response()->json($res);}

            $users_all = User::where('key', '!=', $request->token)
                ->where('tel', '=', $request->tel)
                ->orWhere('email', '=', $request->email)
                ->orWhere('username', '=', $request->username)
                ->get();

            if (count($users_all) > 0) {
                $res["status"] = "username_email_tel_error";
                return response()->json($res);
            }

            $user = User::where('key', '=', $request->token)
                ->where('status', '=', 1)
                ->where('device', '=', $request->device)
                ->where('tel', '=', $request->tel)
                ->orWhere('email', '=', $request->tel)
                ->update(['username' => $request->email, 'email' => $request->email
                    , 'name' => $request->name, 'surname' => $request->surname, 'adress' => $request->adress]);

            if ($user == 1) {
                $res["status"] = "ok";
            } else {
                $res["status"] = "update failed";
            }

            return response()->json($res);

        } catch (Exception $e) {

            // echo 'Yakalanan olağandışılık: ',  $e->getMessage(), "\n";
            $res["status"] = $e->getMessage();
            return response()->json($res);

        }

    }

    public function password(Request $request)
    {

        try {

            $validator = Validator::make($request->all(), [
                'token' => 'required|max:60',
                'tel' => 'required|max:255',
                'password' => 'required|max:255',
                'password_1' => 'required|max:255',
                'password_2' => 'required|max:255',
                'device' => 'required|max:255',
            ]);

            if ($validator->fails()) {$res["status"] = "Validate Error";return response()->json($res);}
            if ($request->password_1 != $request->password_2) {$res["status"] = "Password Error";return response()->json($res);}

            $user = User::where('key', '=', $request->token)
                ->where('status', '=', 1)
                ->where('device', '=', $request->device)
                ->where('password', '=', md5($request->password))
                ->where('tel', '=', $request->tel)
                ->orWhere('email', '=', $request->tel)
                ->get();

            if (count($user) > 0) {

                $user = User::where('key', '=', $request->token)
                    ->where('status', '=', 1)
                    ->where('device', '=', $request->device)
                    ->where('password', '=', md5($request->password))
                    ->where('tel', '=', $request->tel)
                    ->orWhere('email', '=', $request->tel)
                    ->update(['password' => md5($request->password_1)]);

                if ($user == 1) {
                    $res["status"] = "ok";
                } else {
                    $res["status"] = "update failed";
                }

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

    public function info_get(Request $request)
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
                $res["username"] = $user[0]->username;
                $res["name"] = $user[0]->name;
                $res["surname"] = $user[0]->surname;
                $res["tel"] = $user[0]->tel;
                $res["email"] = $user[0]->email;
                $res["adress"] = $user[0]->adress;
                $res["id"] = $user[0]->id;
                $res["member_type"] = $user[0]->member_type;
                $res["status"] = $user[0]->status;
                $res["parent_id"] = $user[0]->parent_id;
                $res["start_date"] = $user[0]->start_date;
                $res["finish_date"] = $user[0]->finish_date;

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
