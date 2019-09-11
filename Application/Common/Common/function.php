<?php


/**
 * url加密 
 */

function url_base64_encode($str)
{
    $code = base64_encode($str);        
    $code = str_replace('+',"!",$code); //把所用"+"替换成"!"
    $code = str_replace('/',"*",$code); //把所用"/"替换成"*"
    $code = str_replace('=',"",$code);  //把所用"="删除掉
    return $code;
}
/**
 * url解密 
 */
function url_base64_decode($code)
{
    $code = str_replace("!",'+',$code);//把所用"+"替换成"!"
    $code = str_replace("*",'/',$code);//把所用"/"替换成"*"
    $str  = base64_decode($code);
    return $str;
}

