<?php

namespace App\Console\Commands;

use GuzzleHttp\Client as HttpClient;
use Illuminate\Console\Command;

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
        $base_url = 'https://www.lagou.com/jobs/positionAjax.json?city=%E5%8C%97%E4%BA%AC&needAddtionalResult=false';
        $params = [
            'first'=>true,
            'pn'=>2,
            'kd'=>'PHP'
        ];
        $response = $this->send('POST',$base_url,$params);
        $statusCode = $response->getStatusCode();
        if ($statusCode == 200) {
            $body = $response->getBody()
                ->getContents();

            $result = json_decode($body);
        dd($result);
        }
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
                    'Referer'=>'https://www.lagou.com/jobs/list_Java?city=%E5%85%A8%E5%9B%BD&cl=false&fromSearch=true&labelWords=&suginput=',
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
