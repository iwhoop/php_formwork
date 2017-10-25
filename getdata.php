<?php
/**
 * Created by PhpStorm.
 * User: yuqi
 * Date: 2017/9/18
 * Time: 17:10
 */
class Controller_GetData extends Controller_BaseController
{
    //从接口获取数据
    public static function get_obj_data( $url ) {
        $headers = array(
            'Accept'=>"application/json"
        );
        $options = "";
        $xmlStr = handle\common\UrlTool::request_get($url,$options,$headers);

        $re = substr($xmlStr->body,11,3);
        if($re == "err"){
            Controller_error::action_404();
            die;
        }
        $re = $xmlStr->body;
        $arrobj = json_decode($re,true);

        $return = $arrobj["data"];
        return $return;
    }

}
