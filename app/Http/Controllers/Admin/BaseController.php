<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class BaseController extends Controller
{
    /**
     * 操作成功提示
     *
     * @param $url string
     * @param $message
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    protected function success($url, $message)
    {
        Session::flash('message', $message);
        Session::flash('message_type', 2);
        return redirect($url);
    }

    /**
     *
     * 操作失败提醒
     *
     * @param $url
     * @param $message
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    protected function error($url, $message)
    {
        Session::flash('message', $message);
        Session::flash('message_type', 1);
        return redirect($url);
    }
}
