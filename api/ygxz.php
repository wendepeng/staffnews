<?php
defined('IN_PHPCMS') or exit('No permission resources.');
/**
 * 获取未读数目
 */
if ($_GET['op'] == 'ygxz' && $_GET['a']=='unread_count' && isset($_GET['userid'])) {
    $rep = array(
        'status'=>1,
        'msg'=>''
    );

    $userid = intval(addslashes($_GET['userid']));

    $read_db = pc_base::load_model('read_model');
    $db = pc_base::load_model('content_model');
    $cat_db = pc_base::load_model('category_model');

    $ygxz_cat = $cat_db->get_one(array('catdir'=>'ygxz'));
    if(empty($ygxz_cat)){
        echo json_encode($rep);
        exit;
    }

    $unread_count = 0;
    $db->table_name = $db->db_tablepre . 'news';
    $list = $db->select(array('status' => '99', 'catid'=>$ygxz_cat['catid']), '*', '','inputtime DESC');
    $read_list =$read_db->select(array('userid'=>$userid));
    $read_newsid_list = array_column($read_list,'newsid');
    foreach($list as $news){
        if(!in_array($news['id'],$read_newsid_list)){
            $unread_count++;
        }
    }

    $rep['status']=0;
    $rep['msg']='';
    $rep['unread_count']=$unread_count;
    echo json_encode($rep);
} else if($_GET['op']=='ygxz'&&$_GET['a']=='read'&&isset($_GET['userid'])&&isset($_GET['newsid'])){

    $userid = intval($_GET['userid']);
    $newsid = intval($_GET['newsid']);
    $read_db = pc_base::load_model('read_model');
    if($read_db->insert(array('newsid'=>$newsid,'userid'=>$userid,'createdtime'=>time()))){
        echo json_encode(array('status'=>0,'success'=>TRUE));
    }else{
        echo json_encode(array('status'=>-1,'success'=>FALSE));
    }
}