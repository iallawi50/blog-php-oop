<?php

namespace App\Controllers;

use App\Core\Request;
use App\Models\User;
use Carbon\Carbon;

class AuthController
{


    public function register()
    {
        return view("auth/register");
    }

    public function store()
    {

        $name = trim(Request::get("name"));
        $username = trim(Request::get("username"));
        $password = Request::get("password");
        $confirmpassword = Request::get("confirmpassword");
        $send = true;
        $data = [
            "name" => $name,
            "username" => $username,
            "errors" => [],
        ];

        // Name Validate
        if (empty($name)) {
            $data["errors"]["name"] = 'حقل الاسم فارغ';
            $send = false;
        }

        // Username Validate
        if (empty($username)) {
            $data["errors"]["username"] = 'حقل اسم المستخدم فارغ';
            $send = false;
        } else if (str_contains($username, " ") || preg_match('/[\'^£$%&*()}{@#~?><>,|=+¬-]/', $username)) {
            $data["errors"]["username"] = 'يجب ان لايحتوي على مسافات او رموز';
            $send = false;
        } else if (User::find($username, "username")) {
            $data["errors"]["username"] = 'اسم المستخدم موجود بالفعل';
            $send = false;
        }


        // Password Validate

        if (empty($password)) {
            $data["errors"]["password"] = 'حقل كلمة المرور فارغ';
            $send = false;
        } else if (strlen($password) < 8) {
            $data["errors"]["password"] = 'كلمة المرور قصيرة , يجب ان تكون 8 او اطول';
            $send = false;
        } else if ($password != $confirmpassword) {
            $data["errors"]["password"] = 'كلمة المرور وتأكيد كلمة المرور غير متطابقين';
            $send = false;
        }

        if ($send) {
            User::create([
                "name" => $name,
                "username" => $username,
                "password" => sha1($password),
                "created_at" => Carbon::now()
            ]);

            $user = User::find($username, "username");
            $_SESSION['user'] = $user;

            return redirect_home();
        }


        return view("auth/register", $data);
    }

    public function login()
    {
        return view("auth/login");
    }

    public function authentication()
    {



        $username = strtolower(Request::get("username"));
        $password = Request::get("password");
        $user = User::find($username, "username", "=");
        $data = [
            "username" => $username,
        ];

        if (!empty($username) && !empty($password)) {
            $password = sha1($password);
            if ($user) {

                if ($user->username == $username && $user->password == $password) {
                    $_SESSION["user"] = $user;
                    return redirect_home();
                } else {
                    $data["errors"] = "البيانات المدخلة غير متطابقة مع سجلاتنا";
                }
            } else {
                $data["errors"] = "البيانات المدخلة غير متطابقة مع سجلاتنا";
            }
        } else {
            $data["errors"] = "لديك حقول فارغة";
        }


        return view("auth/login", $data);
    }


    public function logout()
    {
        unset($_SESSION["user"]);
        return back();
    }
}
