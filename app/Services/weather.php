<?php namespace App\Services;
/**
 * Created by Vati Child.
 * User: vatia13
 * Date: 10/19/14
 * Time: 12:47 PM
 */

class weather
{
    var $key;
    var $json;
    var $week_days;
    var $w_icons;
    var $w_text;
    function __construct($key,$week_days = array(1 => 'Monday',2 => 'Tuesday',3 => 'Wednesday',4 => 'Thursday',5 => 'Friday',6 => 'Saturday',7 => 'Sunday')){
        $this->key = $key;
        $this->week_days = $week_days;
    }
    function city_w($city,$days,$cur = false){
        $curr_day = date("l");
        $w_days = array();
        $this->json = file_get_contents('http://api.worldweatheronline.com/free/v2/weather.ashx?q='.trim($city).'&format=JSON&num_of_days='.trim($days).'&key='.trim($this->key).'');
        $w = json_decode($this->json);
        //$w_current = $w->data->current_condition;
        if($cur == true){
            $last = count($w->data->weather[0]->hourly) - 1;
            $this->w_icons = $this->icon_w($w->data->weather[0]->hourly[$last]);
            $this->w_text = $this->text_w($w->data->weather[0]->hourly[$last]);
            $w_today = array("weather" => $w->data->weather[0]->hourly[$last],"w_icons" => $this->w_icons,"w_text" => $this->w_text);

            return $w_today;
        }else{
            $week_days = array(1 => 'Monday',2 => 'Tuesday',3 => 'Wednesday',4 => 'Thursday',5 => 'Friday',6 => 'Saturday',7 => 'Sunday');
            $i=0;foreach($week_days as $s):$i++;
                if($s == $curr_day):
                    $w_days[] = $this->week_days[$i];
                    for($a=0;$a<$days - 1;$a++):
                        $i = $i + 1;
                        if($i > 7): $i = 1; endif;
                        $w_days[] = $this->week_days[$i];
                    endfor;
                endif;
            endforeach;

            $this->w_icons = $this->icon_w($w->data->weather);
            $this->w_text = $this->text_w($w->data->weather);
            $w_today = array("location" => $w->data->request[0]->query, "weather" => $w->data->weather,"week_days" => $w_days,"w_icons" => $this->w_icons,"w_text" => $this->w_text);
            return $w_today;
        }
    }

    function icon_w($d){
        $w_icon = array();

        //foreach($data as $d):
            if($d->weatherCode == 113){
                $w_icon[] = "1.png";
            }else if($d->weatherCode == 116){
                $w_icon[] = "2.png";
            }else if($d->weatherCode == 119){
                $w_icon[] = "3.png";
            }else if($d->weatherCode == 122){
                $w_icon[] = "4.png";
            }else if($d->weatherCode == 143){
                $w_icon[] = "5.png";
            }else if($d->weatherCode == 176){
                $w_icon[] = "6.png";
            }else if($d->weatherCode == 179){
                $w_icon[] = "7.png";
            }else if($d->weatherCode == 182){
                $w_icon[] = "9.png";
            }else if($d->weatherCode == 185){
                $w_icon[] = "9.png";
            }else if($d->weatherCode == 200){
                $w_icon[] = "10.png";
            }else if($d->weatherCode == 227){
                $w_icon[] = "11.png";
            }else if($d->weatherCode == 230){
                $w_icon[] = "11.png";
            }else if($d->weatherCode == 248){
                $w_icon[] = "12.png";
            }else if($d->weatherCode == 260){
                $w_icon[] = "13.gif";
            }else if($d->weatherCode == 263){
                $w_icon[] = "6.png";
            }else if($d->weatherCode == 266){
                $w_icon[] = "14.png";
            }else if($d->weatherCode == 281){
                $w_icon[] = "15.png";
            }else if($d->weatherCode == 284){
                $w_icon[] = "15.png";
            }else if($d->weatherCode == 293){
                $w_icon[] = "14.png";
            }else if($d->weatherCode == 296){
                $w_icon[] = "14.png";
            }else if($d->weatherCode == 299){
                $w_icon[] = "16.png";
            }else if($d->weatherCode == 302){
                $w_icon[] = "17.png";
            }else if($d->weatherCode == 305){
                $w_icon[] = "18.png";
            }else if($d->weatherCode == 308){
                $w_icon[] = "19.png";
            }else if($d->weatherCode == 311){
                $w_icon[] = "9.png";
            }else if($d->weatherCode == 314){
                $w_icon[] = "20.png";
            }else if($d->weatherCode == 317){
                $w_icon[] = "9.png";
            }else if($d->weatherCode == 320){
                $w_icon[] = "21.png";
            }else if($d->weatherCode == 323){
                $w_icon[] = "22.png";
            }else if($d->weatherCode == 326){
                $w_icon[] = "22.png";
            }else if($d->weatherCode == 329){
                $w_icon[] = "23.png";
            }else if($d->weatherCode == 332){
                $w_icon[] = "23.png";
            }else if($d->weatherCode == 335){
                $w_icon[] = "24.png";
            }else if($d->weatherCode == 338){
                $w_icon[] = "11.png";
            }else if($d->weatherCode == 350){
                $w_icon[] = "20.png";
            }else if($d->weatherCode == 353){
                $w_icon[] = "6.png";
            }else if($d->weatherCode == 356){
                $w_icon[] = "16.png";
            }else if($d->weatherCode == 359){
                $w_icon[] = "17.png";
            }else if($d->weatherCode == 362){
                $w_icon[] = "7.png";
            }else if($d->weatherCode == 365){
                $w_icon[] = "20.png";
            }else if($d->weatherCode == 368){
                $w_icon[] = "22.png";
            }else if($d->weatherCode == 371){
                $w_icon[] = "24.png";
            }else if($d->weatherCode == 374){
                $w_icon[] = "7.png";
            }else if($d->weatherCode == 377){
                $w_icon[] = "9.png";
            }else if($d->weatherCode == 386){
                $w_icon[] = "10.png";
            }else if($d->weatherCode == 389){
                $w_icon[] = "25.png";
            }else if($d->weatherCode == 392){
                $w_icon[] = "27.png";
            }else if($d->weatherCode == 395){
                $w_icon[] = "26.png";
            }
       // endforeach;

        return $w_icon;
    }

    function text_w($d){
        $w_text = array();
        //foreach($data as $d):
            if($d->weatherDesc[0]->value == "Sunny"){
                $w_text[] = trans('all.SUNNY');
            }else if($d->weatherDesc[0]->value == "Clear"){
                $w_text[] = trans('all.CLEAR');
            }else if($d->weatherDesc[0]->value == "Partly Cloudy"){
                $w_text[] = trans('all.PARLTY_CLOUDY');
            }else if($d->weatherDesc[0]->value == "Cloudy"){
                $w_text[] = trans('all.CLOUDY');
            }else if($d->weatherDesc[0]->value == "Overcast"){
                $w_text[] = trans('all.OVERCAST');
            }else if($d->weatherDesc[0]->value == "Mist"){
                $w_text[] = trans('all.MIST');
            }else if($d->weatherDesc[0]->value == "Patchy rain nearby"){
                $w_text[] = trans('all.PATCHY_RAIN_NEARBY');
            }else if($d->weatherDesc[0]->value == "Patchy snow nearby"){
                $w_text[] = trans('all.PATCHY_SNOW_NEARBY');
            }else if($d->weatherDesc[0]->value == "Patchy sleet nearby"){
                $w_text[] = trans('all.PATCHY_STEEL_NEARBY');
            }else if($d->weatherDesc[0]->value == "Patchy sleet nearby"){
                $w_text[] =  trans('all.PATCHY_STEEL_NEARBY');
            }else if($d->weatherDesc[0]->value == "Thundery outbreaks"){
                $w_text[] = trans('all.THUNDERY_OUTBREAKS');
            }else if($d->weatherDesc[0]->value == "Blowing snow"){
                $w_text[] = trans('all.BLOWING_SNOW');
            }else if($d->weatherDesc[0]->value == "Blizzard"){
                $w_text[] = trans('all.BLIZZARD');
            }else if($d->weatherDesc[0]->value == "Fog"){
                $w_text[] = trans('all.FOG');
            }else if($d->weatherDesc[0]->value == "Freezing fog"){
                $w_text[] = trans('all.FREEZING_FOG');
            }else if($d->weatherDesc[0]->value == "Patchy light drizzle"){
                $w_text[] = trans('all.PATCHY_LIGHT_DRIZZLE');
            }else if($d->weatherDesc[0]->value == "Light drizzle"){
                $w_text[] = trans('all.LIGHT_DRIZZLE');
            }else if($d->weatherDesc[0]->value == "Freezing drizzle"){
                $w_text[] = trans('all.FREEZING_DRIZZLE');
            }else if($d->weatherDesc[0]->value == "Heavy freezing drizzle"){
                $w_text[] = trans('all.HEAVY_FREEZING_DRIZZLE');
            }else if($d->weatherDesc[0]->value == "Patchy light rain"){
                $w_text[] = trans('all.PATCHY_LIGHT_RAIN');
            }else if($d->weatherDesc[0]->value == "Light rain"){
                $w_text[] = trans('all.LIGHT_RAIN');
            }else if($d->weatherDesc[0]->value == "Moderate rain at times"){
                $w_text[] = trans('all.MODERATE_RAIN_AT_TIMES');
            }else if($d->weatherDesc[0]->value == "Moderate rain"){
                $w_text[] = trans('all.MODERATE_RAIN');
            }else if($d->weatherDesc[0]->value == "Heavy rain at times"){
                $w_text[] = trans('all.HEAVY_RAIN_AT_TIMES');
            }else if($d->weatherDesc[0]->value == "Heavy rain"){
                $w_text[] = trans('all.HEAVY_RAIN');
            }else if($d->weatherDesc[0]->value == "Light freezing rain"){
                $w_text[] = trans('all.LIGHT_FREEZING_RAIN');
            }else if($d->weatherDesc[0]->value == "Moderate or Heavy freezing rain"){
                $w_text[] = trans('all.MODERATE_OR_HEAVY_FREEZING_RAIN');
            }else if($d->weatherDesc[0]->value == "Light sleet"){
                $w_text[] = trans('all.LIGHT_STEEL');
            }else if($d->weatherDesc[0]->value == "Moderate or heavy sleet"){
                $w_text[] = trans('all.MODERATE_OR_HEAVY_STEEL');
            }else if($d->weatherDesc[0]->value == "Patchy light snow"){
                $w_text[] = trans('all.PATCHY_LIGHT_SNOW');
            }else if($d->weatherDesc[0]->value == "Light snow"){
                $w_text[] = trans('all.LIGHT_SNOW');
            }else if($d->weatherDesc[0]->value == "Patchy moderate snow"){
                $w_text[] = trans('all.PATCHY_MODERATE_SNOW');
            }else if($d->weatherDesc[0]->value == "Moderate snow"){
                $w_text[] = trans('all.MODERATE_SNOW');
            }else if($d->weatherDesc[0]->value == "Patchy heavy snow"){
                $w_text[] = trans('all.PATCHY_HEAVY_SNOW');
            }else if($d->weatherDesc[0]->value == "Heavy snow"){
                $w_text[] = trans('all.HEAVY_SNOW');
            }else if($d->weatherDesc[0]->value == "Ice pellets"){
                $w_text[] = trans('all.ICE_PALLETS');
            }else if($d->weatherDesc[0]->value == "Light rain shower"){
                $w_text[] = trans('all.LIGHT_RAIN_SHOWER');
            }else if($d->weatherDesc[0]->value == "Moderate or heavy rain shower"){
                $w_text[] = trans('all.MODERATE_OR_HEAVY_RAIN_SHOWER');
            }else if($d->weatherDesc[0]->value == "Torrential rain shower"){
                $w_text[] = trans('all.TORRENTIAL_RAIN_SHOWER');
            }else if($d->weatherDesc[0]->value == "Light sleet showers"){
                $w_text[] = trans('all.LIGHT_STEEL_SHOWERS');
            }else if($d->weatherDesc[0]->value == "Moderate or heavy sleet showers"){
                $w_text[] = trans('all.MODERATE_OR_HEAVY_STEEL_SHOWERS');
            }else if($d->weatherDesc[0]->value == "Light snow showers"){
                $w_text[] = trans('all.LIGHT_SNOW_SHOWERS');
            }else if($d->weatherDesc[0]->value == "Moderate or heavy snow showers"){
                $w_text[] = trans('all.MODERATE_OR_HEAVY_SNOW_SHOWERS');
            }else if($d->weatherDesc[0]->value == "Light showers of ice pellets"){
                $w_text[] = trans('all.LIGHT_SHOWERS_OF_ICE_PALLETS');
            }else if($d->weatherDesc[0]->value == "Moderate or heavy showers of ice pellets"){
                $w_text[] = trans('all.MODERATE_OR_HEAVY_SHOWERS_OF_ICE_PALLETS');
            }else if($d->weatherDesc[0]->value == "Patchy light rain in area with thunder"){
                $w_text[] = trans('all.PATCHY_LIGHT_RAIN_WITH_THUNDER');
            }else if($d->weatherDesc[0]->value == "Moderate or heavy rain in area with thunder"){
                $w_text[] = trans('all.MODERATE_OR_HEAVY_RAIN_WITH_THUNDER');
            }else if($d->weatherDesc[0]->value == "Patchy light snow in area with thunder"){
                $w_text[] = trans('all.PATCHY_LIGHT_SNOW_WITH_THUNDER');
            }else if($d->weatherDesc[0]->value == "Moderate or heavy snow in area with thunder"){
                $w_text[] = trans('all.MODERATE_OR_HEAVY_SNOW_WITH_THUNDER');
            }
        //endforeach;
        return $w_text;
    }
}