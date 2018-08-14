<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class AccountController extends Controller
{
    //
    public function login(Request $request, Guard $auth)
    {
        /*登录表单处理*/
        if ($request->isMethod('post')) {

            $request->flashOnly('email');
            /*表单数据校验*/
            $this->validate($request, [
                'email' => 'required|email', 'password' => 'required|min:6',
                'captcha' => 'required|captcha'
            ]);

            /*只接收email和password的值*/
            $credentials = [
                'email' => $request->input('email'),
                'password' => $request->input('password')
            ];

            /*根据邮箱地址和密码进行认证*/
            if ($auth->attempt($credentials)) {
                Session::put("admin.login", true);
                /*认证成功后跳转到首页*/
                return redirect()->to(route('admin.index.index'));
            }


            /*登录失败后跳转到首页，并提示错误信息*/
            return redirect(route('admin.account.login'))
                ->withInput($request->only('email'))
                ->withErrors([
                    'password' => '用户名或密码错误，请核实！',
                ]);

        }
        return view("admin.account.login");
    }

    /**
     * 用户登出
     */
    public function logout()
    {
        Session::forget('admin.login');
        return redirect()->guest(route('admin.account.login'));

    }
}
