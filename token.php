<?php
/**
 * Created by PhpStorm.
 * User: yuqi
 * Date: 2017/9/18
 * Time: 16:54
 */

class Controller_Token extends Controller_BaseController{

    //token值获取
    public static function  action_get_token() {
        try
        {
            $content = Cache::get('token');
            return $content;
        }
        catch (\CacheNotFoundException $e)
        {
            $apiport = \handle\common\CacheTools::get_value("global_config_data_api_host");
            $url=$apiport.'/ucenter/auth/guest';
            $params="";
            $headers=array(
                'Accept'=>"application/json"
            );

            $re=handle\common\UrlTool::request_post($url,$headers,$params);
            $token_re=$re->body;
            $token_string=substr($token_re,111,44);
            Cache::set('token',$token_string, 900);
            return $token_string;
        }
    }

}