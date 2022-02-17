<?php
/*
Plugin Name: 直达链接
Version: 1.0
Plugin URL: 
Description: 文章链接直达
Author: MaLaGeBe
Author URL: 
ForEmlog: pro
*/

addAction('adm_writelog_head', 'hook_zlink');
addAction('save_log', 'save_zlink');

function hook_zlink()
{
    global $zlink;
    echo "<script>$(document).ready(function(){var html='<div class=\"form-group\"><label>直达链接：</label><input type=\"text\" name=\"zlink\" id=\"zlink\" value=\"{$zlink}\" class=\"form-control\" placeholder=\"链接地址\"></div>';$('#advset').prepend(html);})</script>";
}

function save_zlink($blogid)
{
    $Log_Model = new Log_Model();
    $zlink = isset($_POST['zlink']) ? addslashes(trim($_POST['zlink'])) : '';

    $logData = array(
        'zlink' => $zlink
    );

    $Log_Model->updateLog($logData, $blogid);
}

function get_zlink($logid)
{
    $db = Database::getInstance();
    $sql = "SELECT * FROM " . DB_PREFIX . "blog WHERE gid=$logid";
    $res = $db->query($sql);
    $row = $db->fetch_array($res);
    if ($row['zlink']) {
        $zlink  = htmlspecialchars($row['zlink']);
    }
    return isset($zlink) ? $zlink : '';
}
