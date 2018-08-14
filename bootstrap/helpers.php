<?php


use Illuminate\Support\Facades\Log;

if (!function_exists('is_phone_number')) {
    /**
     * 判断是否为手机号
     *
     * @param $value
     * @return int
     */
    function is_phone_number($value)
    {
        return !!preg_match('/^1[34578]\d{9}$/', $value);
    }
}

if (!function_exists('is_email_address')) {
    /**
     * 判断是否为邮箱
     *
     * @param $value
     * @return int
     */
    function is_email_address($value)
    {
        return !!preg_match('/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD', $value);
    }
}

if (!function_exists('is_id_number')) {
    /**
     * 判断是否为身份证号
     *
     * @param $id
     * @return bool
     */
    function is_id_number($id)
    {
        $id = strtoupper($id);
        $pattern = '/(^\d{15}$)|(^\d{17}([0-9]|X)$)/';
        $arr_split = array();
        if (!preg_match($pattern, $id)) {
            return false;
        }

        if (strlen($id) === 15) {
            //检查15位
            $pattern = '/^(\d{6})+(\d{2})+(\d{2})+(\d{2})+(\d{3})$/';

            @preg_match($pattern, $id, $arr_split);
            //检查生日日期是否正确
            $dtm_birth = '19' . $arr_split[2] . '/' . $arr_split[3] . '/' . $arr_split[4];
            if (!strtotime($dtm_birth)) {
                return false;
            } else {
                return true;
            }
        } else {
            //检查18位
            $pattern = '/^(\d{6})+(\d{4})+(\d{2})+(\d{2})+(\d{3})([0-9]|X)$/';
            @preg_match($pattern, $id, $arr_split);
            $dtm_birth = $arr_split[2] . '/' . $arr_split[3] . '/' . $arr_split[4];
            if (!strtotime($dtm_birth))  //检查生日日期是否正确
            {
                return false;
            } else {
                //检验18位身份证的校验码是否正确。
                //校验位按照ISO 7064:1983.MOD 11-2的规定生成，X可以认为是数字10。
                $arr_int = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
                $arr_ch = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');
                $sign = 0;
                for ($i = 0; $i < 17; $i++) {
                    $b = (int)$id{$i};
                    $w = $arr_int[$i];
                    $sign += $b * $w;
                }
                $n = $sign % 11;
                $val_num = $arr_ch[$n];
                if ($val_num != substr($id, 17, 1)) {
                    return false;
                } else {
                    return true;
                }
            }
        }
    }
}

if (!function_exists('generate_random_string')) {
    /**
     * 生成指定长度的随机字符串
     * @param null $characters
     * @param int $length
     * @return string
     */
    function generate_random_string($characters = null, $length = 8)
    {
        if (is_null($characters)) {
            $lowercase = 'abcdefghjkmnpqrstuvwxyz';
            $uppercase = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
            $digits = '23456789';
            $characters = $lowercase . $uppercase . $digits;
        }
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}

if (!function_exists('generate_random_digits')) {
    /**
     * 生成指定长度的随机数字字符串
     *
     * @param null $digits
     * @param int $length
     * @return string
     */
    function generate_random_digits($digits = null, $length = 6)
    {
        if (is_null($digits)) {
            $digits = '0123456789';
        }

        return generate_random_string($digits, $length);
    }
}

if (!function_exists('api_response')) {
    /**
     * API Response Wrapper.
     *
     * @param $data
     * @param int $status
     * @param array $headers
     * @param int $options
     * @return \Illuminate\Http\JsonResponse
     */
    function api_response($data = [], $status = 200, array $headers = [], $options = 0)
    {
        $now = microtime(true);

        $data = [
            'data' => $data,
            'meta' => [
                'timestamp' => $now,
                'response_time' => $now - LARAVEL_START,
            ],
        ];

        return response()->json($data, $status, $headers, $options);
    }
}



if (! function_exists('unicode_encode')) {
    function unicode_encode($name)
    {
        $name = iconv('UTF-8', 'UCS-2', $name);
        $len = strlen($name);
        $str = '';
        for ($i = 0; $i < $len - 1; $i = $i + 2) {
            $c = $name[$i];
            $c2 = $name[$i + 1];

            if (ord($c) > 0) {    // 两个字节的文字
                $t1 = base_convert(ord($c), 10, 16);
                if (strlen($t1) == 1) {
                    $t1 = '0' . $t1;
                }
                $t2 = base_convert(ord($c2), 10, 16);
                if (strlen($t2) == 1) {
                    $t2 = '0' . $t2;
                }
                $str .= '\u' . $t1 . $t2;
            } else {
                $str .= $c2;
            }
        }
        Log::info('unicode_encode  '. $str);
        return $str;
    }
}

/*生成头像图片地址*/
if(! function_exists('get_user_avatar')){
    function get_user_avatar($user_id,$size='middle',$extension='jpg'){
        return route('website.image.avatar',['avatar_name'=>$user_id.'_'.$size.'.'.$extension]);
    }
}