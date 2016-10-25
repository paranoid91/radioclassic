<?php
/**
 * Created by PhpStorm.
 * User: vatichild
 * Date: 11/9/15
 * Time: 11:05 AM
 */

function is_articles($news,$cat,$option=''){
    global $drupal,$laravel;
    $options = array();

    if(count($news) > 0){
        while($row = $news->fetch_array()){
            $slug = $drupal->query("SELECT alias FROM url_alias WHERE `source`='node/".$row['nid']."'");
            $slug = explode('/',$slug->fetch_row()[0]);
            if(count($slug) > 1){
                $slug = $slug[1];
            }else{
                $slug = $slug[0];
            }
            if(!empty($option)){
                $new_option = str_replace('[video:','',$row['body_value']);
                $new_option = str_replace(']','',$new_option);
                $options['extra_fields'][$option] = $new_option;
                $opt = serialize($options['extra_fields']);
            }else{
                $opt = '';
            }

            $sql = "INSERT INTO is_articles
         (`user_id`,`node`,`type`,`title`,`head`,`body`,`slug`,`extra_fields`,`lang`,`status`,`created_at`,`updated_at`,`published_at`) VALUES
         (1,'".$row['nid']."',
         '".$row['type']."',
         '".mysqli_real_escape_string($laravel,$row['title'])."',
         '".mysqli_real_escape_string($laravel,$row['body_summary'])."',
         '".mysqli_real_escape_string($laravel,htmlspecialchars(stripslashes($row['body_value'])))."',
         '".mysqli_real_escape_string($laravel,$slug)."',
         '".$opt."',
         '".$row['language']."',
         '".$row['status']."',
         '".date('Y-m-d H:i:s',$row['created'])."',
         '".date('Y-m-d H:i:s',$row['changed'])."',
         '".date('Y-m-d H:i:s',$row['created'])."')";
            $laravel->query($sql);
            $laravel->query("INSERT INTO is_article_cat (article_id,cat_id) VALUES ('".$laravel->insert_id."','".$cat."')");
            echo $laravel->insert_id.'<br><br><br><br><br><br>';
        }
    }
}