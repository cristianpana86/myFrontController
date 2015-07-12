<?php

namespace CPANA\myFrontController\model;

class SlugGenerator
{
    //source of this code is https://gist.github.com/anonymous/2912227
    public static function slugify($str) 
    {
        $search = array('?', '?', 's', 't', 'S', 'T', '?', '?', 'î', 'â', 'a', 'Î', 'Â', 'A', 'ë', 'Ë');
        $replace = array('s', 't', 's', 't', 's', 't', 's', 't', 'i', 'a', 'a', 'i', 'a', 'a', 'e', 'E');
        $str = str_ireplace($search, $replace, strtolower(trim($str)));
        $str = preg_replace('/[^\w\d\-\ ]/', '', $str);
        $str = str_replace(' ', '-', $str);
        return preg_replace('/\-{2,}/', '-', $str);
    }


}

?>
