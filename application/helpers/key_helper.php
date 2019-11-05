<?php

function my_keygen($namespace='',$keygen='false'){
    static $key = '';
    $uid = uniqid($namespace,true);

    $data = $namespace;
    $data .= rand();
    $data .= microtime(true).mt_rand(10000,90000);
    $data .= (isset($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : 'user_agent';
    $data .= (isset($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : 'localhost';
    $data .= (isset($_SERVER['REMOTE_PORT'])) ? $_SERVER['REMOTE_PORT'] : '8080';

    if($keygen){
        return sha1($data);
    }else{
        $hash = hash('ripemd128',$uid.$key.md5($data));
        $key = ($strips) ? substr($hash,0,8).'-'.substr($hash,8,4).'-'.substr($hash,12,4).'-'.substr($hash,16,4).'-'.substr($hash,20,12) : substr($hash,0,8).substr($hash,8,4).substr($hash,12,4).substr($hash,16,4).substr($hash,20,12);
        return $key;
    }    
}