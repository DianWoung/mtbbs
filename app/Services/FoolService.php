<?php
/**
 * Created by PhpStorm.
 * User: mt
 * Date: 2018/6/28
 * Time: 17:02
 */

namespace App\Services;


use App\Contracts\FoolContract;

class FoolService implements FoolContract
{
    public function __construct()
    {
    }

    public function doFool($controller)
    {
        return "You are fool!";
    }
}