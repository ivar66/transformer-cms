<?php

namespace App\Http\Controllers\Admin;

use App\Models\ArticleModel;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    /**
     * 管理菜单-首页
     *
     * @param Request $request
     *
     * @return $this
     */
    public function index(Request $request)
    {
        $totalUserNum = User::count();
        $totalQuestionNum = 0;
        $totalArticleNum = ArticleModel::count();
        $totalAnswerNum = 0;
        $userChart = 0;
        $questionChart = 0;
        $systemInfo = $this->getSystemInfo();
        return view("admin.index.index")->with(compact('totalUserNum', 'totalQuestionNum', 'totalArticleNum',
            'totalAnswerNum', 'userChart', 'questionChart', 'systemInfo'));
    }

    /**
     * 获取当前系统数据
     * @return mixed
     */
    private function getSystemInfo()
    {
        $systemInfo['phpVersion'] = PHP_VERSION;
        $systemInfo['runOS'] = PHP_OS;
        $systemInfo['maxUploadSize'] = ini_get('upload_max_filesize');
        $systemInfo['maxExecutionTime'] = ini_get('max_execution_time');
        $systemInfo['hostName'] = '';
        if (isset($_SERVER['SERVER_NAME'])) {
            $systemInfo['hostName'] .= $_SERVER['SERVER_NAME'] . ' / ';
        }
        if (isset($_SERVER['SERVER_ADDR'])) {
            $systemInfo['hostName'] .= $_SERVER['SERVER_ADDR'] . ' / ';
        }
        if (isset($_SERVER['SERVER_PORT'])) {
            $systemInfo['hostName'] .= $_SERVER['SERVER_PORT'];
        }
        $systemInfo['serverInfo'] = '';
        if (isset($_SERVER['SERVER_SOFTWARE'])) {
            $systemInfo['serverInfo'] = $_SERVER['SERVER_SOFTWARE'];
        }
        return $systemInfo;
    }
}
