<?php


//function hook_galicloud_title(){
//
//}

function hook_galicloud_title_alter(&$build, $title){

    $build['#prefix'] = '<h1>$title</h1>';

}
