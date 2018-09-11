<?php

namespace App\Console\Commands;

use GuzzleHttp\Client as HttpClient;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
//todo 日志 以及时间
class spiderLagouJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spider:lagou';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '爬取拉勾职位信息';

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $base_url = 'https://www.lagou.com/jobs/positionAjax.json?city=%E5%B9%BF%E5%B7%9E&needAddtionalResult=false';
        $params = [
            'first'=>true,
            'pn'=>1,
            'kd'=>'招聘'
        ];
        $response = $this->send('POST',$base_url,$params);
        $result = $this->buildResult($response);
        //
        $max = $result['totalCount']/15;
//        Log::info("SPIDER_START.=========爬取拉勾开始==========");
        var_export("SPIDER_START.=========爬取拉勾开始==========\n");
        for ($i=27;$i<$max;$i++){
            $params = [
                'first' => (1==$i)?true:false,
                'pn'=> $i,
                'kd'=> '招聘'
            ];
            $response = $this->send('POST',$base_url,$params);
            $result = $this->buildResult($response);
            if (!empty($result['result'])){
                $this->createZhaopingJob($result);
            }
            var_export("SPIDER_START.=========爬取拉勾第{$i}页结束==========\n");
            sleep(30);
        }
        Log::info("SPIDER_END=========爬取拉勾结束==========\n");
    }

    protected function createZhaopingJob($result){
        $jobItems=[];
        $now = date('Y-m-d H:i:s');
        $jobType = $result['queryAnalysisInfo']['positionName'];
        foreach ($result['result'] as $itemJob){
            $jobItems[] =[
                'type'=>1,
                'job_type'=>$jobType,
                'company_full_name'=>$itemJob['companyFullName'],
                'company_name'=>$itemJob['companyShortName'],
                'company_Id'=>$itemJob['companyId'],
                'industry_field'=>$itemJob['industryField'],
                'company_size'=>$itemJob['companySize'],
                'finance_stage'=>$itemJob['financeStage'],
                'position_name'=>$itemJob['positionName'],
                'position_advantage'=>$itemJob['positionAdvantage'],
                'position_lables'=> implode(',',$itemJob['positionLables']),
                'work_year'=>$itemJob['workYear'],
                'salary'=>$itemJob['salary'],
                'city'=>$itemJob['city'],
                'district'=>$itemJob['district'],
                'first_type'=>$itemJob['firstType'],
                'second_type'=>$itemJob['secondType'],
                'job_url'=>"https://www.lagou.com/jobs/{$itemJob['positionId']}.html",
                'created_at'=> $now,
                'updated_at'=> $now,
            ];
        }
        if ($jobItems){
            DB::connection('spider_mysql')->table('zhaoping_jobs')->insert($jobItems);
        }
    }


    protected function buildResult($response){
        $statusCode = $response->getStatusCode();
        if ($statusCode == 200) {
            $body = $response->getBody()
                ->getContents();
            Log::info('RequestSpiderLagou'.$body);
            return json_decode($body,true)['content']['positionResult'];
        }
        return false;
    }
    /*
     * 发送请求 非异步
     */
    protected function send($method='GET',$url='',$params = [])
    {
        $client = new HttpClient();
        if ($method=='POST'){
            return  $client->request($method, $url, [
                'form_params'=>$params,
                'headers' =>[
                    'Host'=>'www.lagou.com',
                    'Referer'=>'https://www.lagou.com/jobs/list_%E6%8B%9B%E8%81%98?city=%E5%B9%BF%E5%B7%9E&cl=false&fromSearch=true&labelWords=&suginput=',
                    'User-Agent'=>'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.186 Mobile Safari/537.36',
                    'X-Anit-Forge-Code'=>0,
                    'X-Anit-Forge-Token'=>'None',
                    'X-Requested-With'=>'XMLHttpRequest'
                ]
            ]);
        }else{
            return $client->request($method, $url, [
                'query' => $params,
                'headers' => [
                    'Accept' => 'application/json',
                ]
            ]);
        }

    }
}
