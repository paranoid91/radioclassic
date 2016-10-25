<?php
/*
 * Created at 6/30/2015
 * Author: Salikh Gurgenidze
 * Nickname: Vati Child
 * Company: IT-Solutions
 * Website: www.it-solutions.ge
 */

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Html\FormBuilder;

/**
 * @param $str
 * @return mixed|string
 * Generates Georgian string to UTF-8 slug
 */
Str::macro('generate_ge',
    function($str){
    $converter = array(
        'ა' => 'a',   'ბ' => 'b',   'ვ' => 'v',
        'გ' => 'g',   'დ' => 'd',   'წ' => 'w',
        'ე' => 'e',   'ჟ' => 'zh',  'ზ' => 'z',
        'ი' => 'i',   'კ' => 'k',
        'ლ' => 'l',   'მ' => 'm',   'ნ' => 'n',
        'ო' => 'o',   'პ' => 'p',   'რ' => 'r',
        'ს' => 's',   'ტ' => 't',   'უ' => 'u',
        'ფ' => 'f',   'ჰ' => 'h',   'ც' => 'c',
        'ჩ' => 'ch',  'შ' => 'sh',  'თ' => 't',
        'ყ' => 'y',   'იუ' => 'ju',
        'ჯ' => 'j',   'ხ' => 'x',
        'ხ' => 'x', 'ქ' => 'q', 'ზ' => 'z',
        'ძე' => 'dze', 'ძ' => 'Z',

        'ა' => 'A',   'ბ' => 'B',   'ვ' => 'V',
        'გ' => 'G',   'დ' => 'D',   'ჯ' => 'J',
        'ე' => 'E',   'ჟ' => 'Zh',  'ზ' => 'Z',
        'ი' => 'I',   'ყ' => 'Y',   'კ' => 'K',
        'ლ' => 'L',   'მ' => 'M',   'ნ' => 'N',
        'ო' => 'O',   'პ' => 'P',   'რ' => 'R',
        'ს' => 'S',   'ტ' => 'T',   'უ' => 'U',
        'ფ' => 'F',   'ჰ' => 'H',    'ც' => 'C',
        'ჩ' => 'Ch',  'შ' => 'Sh',   'ხ' => 'X',
        'ჭ' => 'W',   'ფ' => 'f',   'ღ' => 'R',
        'ქ' => 'Q', 'ძე' => 'DZE',
    );
    $str = strtr($str, $converter);
    $str = strtolower($str);
    $str = preg_replace('~[^-a-z0-9_]+~u', '-', $str);
    $str = trim($str, "-");
    return $str;
});


/**
 * @param $title
 * @param string $separator
 * @return Generates string to UTF-8 slug
 */

Str::macro('slug_utf8',
    function($title, $separator = '-')
{
    //$title = static::ascii($title); //comment it out to suport farsi

    // Convert all dashes/underscores into separator
    $flip = $separator == '-' ? '_' : '-';

    $title = preg_replace('!['.preg_quote($flip).']+!u', $separator, $title);

    // Remove all characters that are not the separator, letters, numbers, or whitespace.
    $title = preg_replace('![^'.preg_quote($separator).'\pL\pN\s]+!u', '', mb_strtolower($title));

    // Replace all separator characters and whitespace by a single separator
    $title = preg_replace('!['.preg_quote($separator).'\s]+!u', $separator, $title);

    return trim($title, $separator);

});


/**
 * @param $name
 * @param array $list
 * @param null $selected
 * @param array $options
 * @return Select Categories List Macro for FormBuilder
 */

FormBuilder::macro('selectCat',
    function($name, $list = array(), $selected = 0, $options = array()){

    // When building a select box the "value" attribute is really the selected one
    // so we will use that when checking the model or session for a value which
    // should provide a convenient method of re-populating the forms on post.
    $selected = $this->getValueAttribute($name, $selected);

    $options['id'] = $this->getIdAttribute($name, $options);

    if ( ! isset($options['name'])) $options['name'] = $name;

    // We will simply loop through the options and build an HTML value for each of
    // them until we have an array of HTML declarations. Then we will join them
    // all together into one single HTML element that can be put on the form.
    $html = array();

    $html[] = $this->OptionCat($list,$selected,(isset($options['data-root']) ? $options['data-root'] : 0),$i=0);

    // Once we have all of this HTML, we can join this into a single element after
    // formatting the attributes into an HTML "attributes" string, then we will
    // build out a final select statement, which will contain all the values.
    $options = $this->html->attributes($options);

    $list = implode('', $html);

    return "<select{$options}><option value=0>---</option>{$list}</select>";

});


/**
 * @param $tree
 * @param $selected
 * @param $root
 * @param $i
 * @return Get List of Categories as Parent -- Children
 */

FormBuilder::macro('OptionCat',
    function($tree, $selected,  $root, $i){

        $output = '';
        $line = ($i == 0) ? '' : '-';
        for($a=0;$a<$i;$a++){
            $line .= $line;
        }
        $i++;

        if(!is_null($tree) && count($tree) > 0) {
            foreach($tree as $child => $parent) {
                if($parent->parent == $root) {

                    unset($tree[$child]);
                    $sel = $this->getSelectedValue($parent->id, $selected);
                    $options = array('value' => e($parent->id), 'selected' => $sel);
                    $output .= '<option '.$this->html->attributes($options).'>'.$line.' '.get_trans($parent->name).'</option>';
                    $output .= $this->OptionCat($tree, $selected, $parent->id,$i);

                }

            }

        }

        return $output;
    });

/**
 * @param $name
 * @param array $list
 * @param null $selected Children
 * @param array $options
 * @return Select Categories Child List Macro for FormBuilder
 */

FormBuilder::macro('selectChild',
    function($name, $list = array(), $selected = null, $options = array()){

        // When building a select box the "value" attribute is really the selected one
        // so we will use that when checking the model or session for a value which
        // should provide a convenient method of re-populating the forms on post.
        $selected = $this->getValueAttribute($name, $selected);

        $options['id'] = $this->getIdAttribute($name, $options);

        if ( ! isset($options['name'])) $options['name'] = $name;

        // We will simply loop through the options and build an HTML value for each of
        // them until we have an array of HTML declarations. Then we will join them
        // all together into one single HTML element that can be put on the form.
        $html = array();

        $html[] = $this->OptionChild($list,$selected);

        // Once we have all of this HTML, we can join this into a single element after
        // formatting the attributes into an HTML "attributes" string, then we will
        // build out a final select statement, which will contain all the values.
        $options = $this->html->attributes($options);

        $list = implode('', $html);

        return "<select{$options}><option value=''>---</option>{$list}</select>";

    });

/**
 * @param $tree
 * @param $selected
 * @param $root
 * @param $i
 * @return Get List of Categories as Children
 */

FormBuilder::macro('OptionChild',
    function($tree, $selected){
        $output = '';
        if(!is_null($tree) && count($tree) > 0) {
            foreach($tree as $key => $child) {
                unset($tree[$key]);
                $sel = $this->getSelectedValue($child->id, $selected);
                $options = array('value' => e($child->id), 'selected' => $sel);
                $output .= '<option '.$this->html->attributes($options).'>'.$child->name.'</option>';
            }

        }

        return $output;
    });


/**
 * Create a select box field.
 *
 * @param  string  $name
 * @param  array   $list
 * @param  string  $selected
 * @param  array   $options
 * @return string
 */
FormBuilder::macro('selectMy',
    function($name, $list = array(), $selected = null, $option='', $options = array())
    {
        // When building a select box the "value" attribute is really the selected one
        // so we will use that when checking the model or session for a value which
        // should provide a convenient method of re-populating the forms on post.
        $selected = $this->getValueAttribute($name, $selected);

        $options['id'] = $this->getIdAttribute($name, $options);

        if ( ! isset($options['name'])) $options['name'] = $name;

        // We will simply loop through the options and build an HTML value for each of
        // them until we have an array of HTML declarations. Then we will join them
        // all together into one single HTML element that can be put on the form.
        $html = array();

        foreach ($list as $value => $display)
        {
            $html[] = $this->getSelectOption($display, $value, $selected);
        }

        // Once we have all of this HTML, we can join this into a single element after
        // formatting the attributes into an HTML "attributes" string, then we will
        // build out a final select statement, which will contain all the values.
        $options = $this->html->attributes($options);

        $list = implode('', $html);


        return "<select{$options}>{$option}{$list}</select>";
    });


