<?php
/*
 * Copyright © 2017 EaseScript All rights reserved.
 * Released under the MIT license
 * https://github.com/51breeze/EaseScript
 * @author Jun Ye <664371281@qq.com>
 */
///<references from='RegExp' />
/**
 * @name indexOf
 * @bind target
 */
function es_string_index_of($target,$value){
    $index = mb_strpos($target, $value);
    return $index === false ? -1 : $index;
}

/**
 * @name lastIndexOf
 * @bind target
 */
function es_string_last_index_of($target,$value){
    $index = mb_strrpos($target, $value);
    return $index === false ? -1 : $index;
}

/**
 * @name substring
 * @bind target
 */
function es_string_substring($target,$start=0, $end=null){
    $len = mb_strlen($target);
    if( $end === null ){
        $end = mb_strlen($target);
    }
    $start = is_numeric( $start ) ? min($len,max($start,0)) : 0;
    $end = is_numeric( $end ) ? min($len,max($end,0)) : 0;
    if($start > $end){
        return mb_substr($target, $end, $start);
    }
    return mb_substr($target,$start, $end);
}

/**
 * @name slice
 * @bind target
 */
function es_string_slice($target, $start=0, $end=null){
    $len = mb_strlen($target);
    if( $end === null ){
        $end =  $len;
    }
    if( $end < 0 ){
        $end = $len + $end;
    }
    if( $start < 0 ){
        $start = $len + $start;
    }
    $start = max( min($start,$len), 0);
    $end = max( min($end,$len), 0);
    return mb_substr($target, $start, $end-$start);
}

/**
 * @name normalize
 * @bind target
 */
function es_string_normalize($target){
    return preg_replace_callback('/\\\\u([0-9a-f]{4})/i', function($matches) {
        if(function_exists("mb_convert_encoding")) {
            return mb_convert_encoding(pack("H*", $matches[1]), "UTF-8", "UCS-2BE");
        }else{
            return iconv('UCS-2', 'UTF-8', pack('H4', $matches[1]));
        }
    },$target);
}

/**
 * @name replace
 * @bind target
 */
function es_string_replace($target,$search,$replacement=''){
    if( $search instanceof RegExp ){
        return $search->replace($target, $replacement);
    }else {
        $index = mb_strpos($target,$search);
        if( $index === false )return $target;
        $left = mb_substr($target, 0, $index);
        $right = mb_substr($target, $index+mb_strlen($search) );
        if( $replacement instanceof \Closure ){
            return $left . $replacement( $search, $index, $target ) . $right;
        }
        return $left . $replacement . $right;
    }
}

/**
 * @name replaceAll
 * @bind target
 */
function es_string_replace_all($target,$search,$replacement=''){
    if( $search instanceof RegExp ){
        return $search->replaceAll($target, $replacement);
    }else if($replacement instanceof \Closure) {
        $regExp = new RegExp( $search );
        return $regExp->replaceAll($target, $replacement);
    }else{
        return str_replace($search, $replacement, $target);
    }
}

/**
 * @name match
 * @bind target
 */
function es_string_match($target,$regexp){
    if( $regexp instanceof RegExp ){
        return $regexp->match( $target );
    }else{
        return (new RegExp( $regexp ))->match( $target );
    }
}

/**
 * @name matchAll
 * @bind target
 */
function es_string_match_all($target,$regexp){
    if( $regexp instanceof RegExp ){
        return $regexp->matchAll( $target );
    }else{
        return (new RegExp( $regexp ))->matchAll( $target );
    }
}

/**
 * @name search
 * @bind target
 */
function es_string_search($target,$search){
    if( $search instanceof RegExp ){
        return $search->search( $target );
    }else{
        return (new RegExp( $search ))->search($target);
    }
}

/**
 * @name charAt
 * @bind target
 */
function es_string_char_at($target,$index){
    return mb_substr($target,$index,1);
}

/**
 * @name charCodeAt
 * @bind target
 */
function es_string_char_code_at($target,$index){
    return mb_ord(mb_substr($target,$index,1),'UTF-8');
}

/**
 * @name includes
 * @bind target
 */
function es_string_includes($target,$value){
    return strpos($target,$value) !== false;
}

/**
 * @name localeCompare
 * @bind target
 */
function es_string_locale_compare($target,$value){
    return strcmp($target,$value);
}

/**
 * @name concat
 * @bind target
 */
function es_string_concat($target,...$args){
    array_unshift($args, $target);
    return implode("", $args);
}

function es_string_from_char_code( ...$codes ){
    $chars = '';
    foreach( $codes as $code){
        $chars .= chr( $code );
    }
    return $chars;
}

function es_string_from_code_point(...$args){
    throw new Error('String.fromCodePoint is not supported');
}

function es_string_raw(...$args){
    throw new Error('String.raw is not supported');
}

function es_string_starts_with($target,$value,$position=0){
    $res = es_string_substring($target, $position, mb_strlen($value));
    return $value === $res;
}

function es_string_ends_with($target,$value,$position=-1){
    $index = mb_strrpos($target, $value);
    if($index === false)return false;
    if($position>=0){
        return $index === $position;
    }
    return mb_substr($target, $index) === $value;
}

function es_string_repeat($target,$value){
    return str_repeat($target, $value);
}