<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * 获取头像路径
     * @param $userId
     * @param string $size
     * @param string $ext
     * @return string
     */
    public static function getAvatarPath($userId, $size = 'big', $ext = 'jpg')
    {
        $avatarDir = self::getAvatarDir($userId);
        $avatarFileName = self::getAvatarFileName($userId, $size);
        return $avatarDir . '/' . $avatarFileName . '.' . $ext;
    }

    /**
     * 获取用户头像存储目录
     * @param $userId
     * @param string $rootPath
     * @return string
     */
    public static function getAvatarDir($userId, $rootPath = 'avatars')
    {
        $userId = sprintf("%09d", $userId);
        return $rootPath . '/' . substr($userId, 0, 3) . '/' . substr($userId, 3, 2) . '/' . substr($userId, 5, 2);
    }


    /**
     * 获取头像文件命名
     * @param string $size
     * @return mixed
     */
    public static function getAvatarFileName($userId, $size = 'big')
    {
        $avatarNames = [
            'small' => 'user_small_' . $userId,
            'middle' => 'user_middle_' . $userId,
            'big' => 'user_big_' . $userId,
            'origin' => 'user_origin_' . $userId
        ];
        return $avatarNames[$size];
    }

}
