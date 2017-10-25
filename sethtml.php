<?php
/**
 * Created by PhpStorm.
 * User: yuqi
 * Date: 2017/9/19
 * Time: 9:55
 */

class Controller_SetHtml extends Controller_BaseController {

    //删除缓存页面
    public static  function action_agethtml($url = 0,$id = '') {
        $file = '';
        //11:首页  22：领取补贴  33：维修保养 44:保险公司 55:关于我们  66:招贤纳士

        //1:新闻  2：小常识 3：活动 4：经销商  5:首页广告位
        if($url == 1){
            $apiport =\handle\common\CacheTools::get_value("global_config_data_api_host");
            $token = Controller_Token::action_get_token();
            $url_new = $apiport.'/common/information?page=false&access_token='.$token;
            $news_re = Controller_GetData::get_obj_data($url_new);
            $num = count($news_re);
            $num = ceil($num/12);

            $file = 'news'.DS;
            $del = 'news_';
            if(!empty($id)){
                $Details_id = 'news_details'.$id;
            }
            else {
                $Details_id = '';
            }

            //首页因为也有新闻的位置，所以也许需要删除首页
            $index_file = '';
            $index_del = 'index';

        }
        else if($url == 2){
            $apiport = \handle\common\CacheTools::get_value("global_config_data_api_host");
            $token = Controller_Token::action_get_token();
            $url_new = $apiport.'/system/news/information/common?access_token='.$token;
            $news_re = Controller_GetData::get_obj_data($url_new);
            $num = count($news_re);

            $num = ceil($num/18);
            $file = 'keep'.DS;
            $del = 'keep';

            if(!empty($id)){
                $Details_id = 'keep_car_details'.$id;
            }
            else {
                $Details_id = '';
            }

            //首页因为也有新闻的位置，所以也许需要删除首页
            $index_file = '';
            $index_del = 'index';
        }
        else if($url == 3){
            $num = 0;
            $file = '';
            $del = 'index';

            $hot_file = 'activity'.DS;
            $Details_id ='activity_details'.$id;
        }
        else if($url == 4){
            //获取到经销商的每一页缓存的页面，可售车型的数据
            $apiport = \handle\common\CacheTools::get_value("global_config_data_api_host");
            $token = Controller_Token::action_get_token();
            $agency_url = $apiport.'/car/store/sale/'.$id.'?access_token='.$token;
            $news_re = Controller_GetData::get_obj_data($agency_url);
            $num = count($news_re);
            $num = ceil($num/16);

            $file = 'agency_details'.DS;
            $del = 'agency';
            $Details_id = 'agency_details'.$id;

            //首页因为也有新闻的位置，所以也许需要删除首页
            $index_file = '';
            $index_del = 'index';

            //使用格式
            //        \Controller_SetHtml::action_agethtml(4,10005);
        }
        else if($url == 5){
            $num = 0;
            $file = '';
            $del = 'index';

            $hot_file = '';
            $Details_id = '';

        }
        else if($url == 6){
            $file = 'about_recruite.html';
        }
        $webport = realpath(DOCROOT.'../../').DS.'web'.DS.'public';

        if($num>0){
            for($i=1;$i<=$num;$i++){
                $exists = File::exists($webport.DS.$file.$del.$i.'.html');
                $news_detailsExists = File::exists($webport.DS.$file.$Details_id.$i.'.html');
                $index_exists = File::exists($webport.DS.$index_file.$index_del.'.html');
                if($exists == 1){
                    \File::delete($webport.DS.$file.$del.$i.'.html');
                }
                if($news_detailsExists == 1){
                    \File::delete($webport.DS.$file.$Details_id.$i.'.html');
                }
                if($index_exists == 1){
                    //删除首页
                    \File::delete($webport.DS.$index_file.$index_del.'.html');
                }
            }
        }
        else{
            $exists = File::exists($webport.DS.$file.$del.'.html');
            $details_exists = File::exists($webport.DS.$hot_file.$Details_id.'.html');
            if( $exists == 1 ){
                \File::delete($webport.DS.$file.$del.'.html');
            }
            if( $details_exists == 1 ){
                \File::delete($webport.DS.$hot_file.$Details_id.'.html');
            }
        }
    }

}