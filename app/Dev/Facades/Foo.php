<?php
/**
 * Created by PhpStorm.
 * User: Home
 * Date: 10/4/2015
 * Time: 5:47 PM
 */
namespace App\Dev\Facades;
use Illuminate\Support\Facades\Facade;
class Foo extends Facade{
    protected static function getFacadeAccessor(){
        return 'Foo';
    }
}