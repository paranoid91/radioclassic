<?php
@include('functions.php');

//NOW PLAYING FEED http://10.10.86.234/DJProAPI/web/views/OnairPlaylistDetailed.php?OUTPUTMETHOD=xml


$drupal = mysqli_connect("localhost","root","root","radioclassic_old") or die("can`t connect drupal data");
$laravel = mysqli_connect("localhost","root","root","radioclassic_1") or die("can`t connect laravel data");
/* change character set to utf8 */
$laravel->set_charset("utf8");
if (!mysqli_set_charset($drupal, "utf8")) {
    printf("Error loading character set utf8: %s\n", mysqli_error($drupal));
    exit();
} else {
    printf("Current character set: %s\n", mysqli_character_set_name($drupal));
}
/**
 * INSERT news - node,title,head,body,lang,status,created_at,updated_at
 */

if(isset($_GET['news']) == 1){
    $news = $drupal->query("SELECT a.nid,a.type,a.language,a.title,a.status,a.created,a.changed,b.body_value,b.body_summary FROM node as a LEFT JOIN field_data_body as b ON b.entity_id=a.nid WHERE a.type='news' ");
    is_articles($news,74);
}

/**
 * INSERT Pages - node,title,head,body,lang,status,created_at,updated_at
 */
if(isset($_GET['page']) == 1){
    $page = $drupal->query("SELECT a.nid,a.type,a.language,a.title,a.status,a.created,a.changed,b.body_value,b.body_summary FROM node as a LEFT JOIN field_data_body as b ON b.entity_id=a.nid WHERE a.type='page' ");
    is_articles($page,1);
}

/**
 * INSERT Program_info - node,title,head,body,lang,status,created_at,updated_at
 */
if(isset($_GET['program_info']) == 1){
    $page = $drupal->query("SELECT a.nid,a.type,a.language,a.title,a.status,a.created,a.changed,b.body_value,b.body_summary FROM node as a LEFT JOIN field_data_body as b ON b.entity_id=a.nid WHERE a.type='program_info' ");
    is_articles($page,75);
}

/**
 * INSERT COMPETITION webform - node,title,head,body,lang,status,created_at,updated_at
 */
if(isset($_GET['webform']) == 1){
    $page = $drupal->query("SELECT a.nid,a.type,a.language,a.title,a.status,a.created,a.changed,b.body_value,b.body_summary FROM node as a LEFT JOIN field_data_body as b ON b.entity_id=a.nid WHERE a.type='webform' ");
    is_articles($page,76);
}

/**
 * INSERT Youtube - node,title,head,body,lang,status,created_at,updated_at
 */
if(isset($_GET['youtube']) == 1){
    $page = $drupal->query("SELECT a.nid,a.type,a.language,a.title,a.status,a.created,a.changed,b.body_value,b.body_summary FROM node as a LEFT JOIN field_data_body as b ON b.entity_id=a.nid WHERE a.type='youtube' ");
    is_articles($page,77,'youtube');
}

/**
 * INSERT free_event - node,title,head,body,lang,status,created_at,updated_at
 */
if(isset($_GET['free_event']) == 1){
    $page = $drupal->query("SELECT a.nid,a.type,a.language,a.title,a.status,a.created,a.changed,b.body_value,b.body_summary FROM node as a LEFT JOIN field_data_body as b ON b.entity_id=a.nid WHERE a.type='free_event' ");
    is_articles($page,78);
}

/**
 * INSERT premium_event - node,title,head,body,lang,status,created_at,updated_at
 */
if(isset($_GET['premium_event']) == 1){
    $page = $drupal->query("SELECT a.nid,a.type,a.language,a.title,a.status,a.created,a.changed,b.body_value,b.body_summary FROM node as a LEFT JOIN field_data_body as b ON b.entity_id=a.nid WHERE a.type='premium_event' ");
    is_articles($page,79);
}

/**
 * INSERT feed_item - node,title,head,body,lang,status,created_at,updated_at
 */
if(isset($_GET['feed_item']) == 1){
    $page = $drupal->query("SELECT a.nid,a.type,a.language,a.title,a.status,a.created,a.changed,b.field_feed_item_description_value as body_value,b.field_feed_item_description_summary as body_summary
    FROM
    node as a LEFT JOIN field_data_field_feed_item_description as b ON b.entity_id=a.nid
    WHERE a.type='feed_item' ");
    is_articles($page,80);
}

/**
 * INSERT competition Images
 */

if(isset($_GET['competition_image']) == 1){
    $images = $drupal->query("SELECT a.entity_id,b.filename FROM field_data_field_competition_image as a
                    LEFT JOIN file_managed as b ON b.fid = a.field_competition_image_fid
                   ");
    while($row = $images->fetch_array()){
        $article_id = $laravel->query("SELECT id FROM is_articles WHERE node='".$row['entity_id']."'");
        $article_id = $article_id->fetch_row()[0];
        $laravel->query("INSERT INTO is_images (img,article_id) VALUES ('".$row['filename']."','".$article_id ."')");
        $laravel->query("INSERT INTO is_article_image (article_id,image_id) VALUES ('".$article_id ."','".$laravel->insert_id."')");
        echo $article_id .'<br>';
    }
}

/**
 * INSERT competition Images
 */

if(isset($_GET['front_image']) == 1){
    $images = $laravel->query("SELECT article_id,img FROM is_images WHERE img != '' ");
    while($row = $images->fetch_array()){
        $laravel->query("UPDATE is_articles SET img='".$row['img']."' WHERE id='".$row['article_id']."'");
        echo $row['article_id'] .'<br>';
    }
}

/**
 * INSERT competition date
 */

if(isset($_GET['competition_date']) == 1){
    $date = $drupal->query("SELECT entity_id,field_competition_date_value as published_at,field_competition_date_value2 as finished_at FROM field_data_field_competition_date WHERE 1");
    while($row = $date->fetch_array()){
        $laravel->query("UPDATE is_articles SET published_at='".$row['published_at']."',finished_at='".$row['finished_at']."' WHERE node='".$row['entity_id']."'");
    }
}

/**
 * INSERT event competition fields
 */

if(isset($_GET['event_fields']) == 1){
    $events = $drupal->query("SELECT a.nid,b.field_event_competition_url,c.field_event_contact_value,d.field_event_dates_value,d.field_event_dates_value2,
                              e.field_event_location_tid,f.field_event_organizer_value,g.field_event_ticket_url,h.field_fevent_web_url,i.field_fevent_image_fid,j.field_event_category_tid FROM node as a
                              LEFT JOIN field_data_field_event_competition as b ON b.entity_id=a.nid
                              LEFT JOIN field_data_field_event_contact as c ON c.entity_id=a.nid
                              LEFT JOIN field_data_field_event_dates as d ON d.entity_id=a.nid
                              LEFT JOIN field_data_field_event_location as e ON e.entity_id=a.nid
                              LEFT JOIN field_data_field_event_organizer as f ON f.entity_id=a.nid
                              LEFT JOIN field_data_field_event_ticket as g ON g.entity_id=a.nid
                              LEFT JOIN field_data_field_fevent_web as h ON h.entity_id=a.nid
                              LEFT JOIN field_data_field_fevent_image as i ON i.entity_id=a.nid
                              LEFT JOIN field_data_field_event_category as j ON j.entity_id=a.nid
                              WHERE a.type='free_event' or a.type='premium_event' ");
    $extras = array();
    $tags_array = array();
    while($row = $events->fetch_array()){
         //location name
         $location_name = $drupal->query("SELECT name FROM taxonomy_term_data WHERE tid='".$row['field_event_location_tid']."'");
         //event tags
         $tags = $drupal->query("SELECT b.name FROM field_data_field_event_tags as a LEFT JOIN taxonomy_term_data as b ON b.tid=a.field_event_tags_tid WHERE a.entity_id='".$row['nid']."'");
         while($trow = $tags->fetch_array()){
            $tags_array[$row['nid']][] = $trow['name'];
         }
         foreach($tags_array as $key=>$item){
           //$laravel->query("UPDATE is_articles SET meta_key='".join(', ',array_unique($item))."' WHERE node='".$key."'");
             //echo $key.'---'.join(', ',array_unique($item)).'<br>';
         }

         //end tags
         $extras['extra_fields']['competition_url'] = $row['field_event_competition_url'];
         $extras['extra_fields']['event_contact'] = $row['field_event_contact_value'];
         $extras['extra_fields']['event_location'] = $location_name->fetch_row()[0];
         $extras['extra_fields']['event_organizer'] = $row['field_event_organizer_value'];
         $extras['extra_fields']['event_ticket'] = $row['field_event_ticket_url'];
         $extras['extra_fields']['event_web'] = $row['field_fevent_web_url'];
         $extras['extra_fields']['event_category'] = $row['field_event_category_tid'];
         $published_at = $row['field_event_dates_value'];
         $finished_at = $row['field_event_dates_value2'];
         $fields = serialize($extras['extra_fields']);

         $laravel->query("UPDATE is_articles SET extra_fields='".$fields."',published_at='".$published_at."',finished_at='".$finished_at."' WHERE node='".$row['nid']."'");
         $article = $laravel->query("SELECT id FROM is_articles WHERE node='".$row['nid']."'");
         $article_id = $article->fetch_row()[0];

         $image = $drupal->query("SELECT filename FROM file_managed WHERE fid='".$row['field_fevent_image_fid']."'");
         $laravel->query("INSERT INTO is_images (article_id,img) VALUES ('".$article_id."','".$image->fetch_row()[0]."')");

         $laravel->query("INSERT INTO is_article_image (article_id,image_id) VALUES ('".$article_id."','".$laravel->insert_id."')");
        echo $article_id.'-'.$laravel->insert_id.'<br>';
    }

}

