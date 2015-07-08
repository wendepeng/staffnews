<?php
defined('IN_PHPCMS') or exit('No permission resources.');
/**
 * 点击我已阅读
 */
if ($_GET['op'] == 'read' && isset($_GET['userid']) && isset($_GET['newsid']) && isset($_GET['pc_hash'])) {
    //检查hash值
    $session_storage = 'session_' . pc_base::load_config('system', 'session_storage');
    pc_base::load_sys_class($session_storage);
    check_hash();

    $db = pc_base::load_model('read_model');
    $userid = intval(addslashes($_GET['userid']));
    $newsid = intval(addslashes($_GET['newsid']));
    $now = time();

    if ($db->insert(array('userid' => $userid, 'newsid' => $newsid, 'createdtime' => $now))) {
        echo json_encode(array(
            'success' => TRUE,
        ));
    } else {
        echo json_encode(array(
            'success' => FALSE,
        ));
    }
} else {
    header('HTTP/1.1 404 Not Found');
    header('Location: /404.html');
    die();
}