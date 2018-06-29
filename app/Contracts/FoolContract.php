<?php
/**
 * Created by PhpStorm.
 * User: mt
 * Date: 2018/6/29
 * Time: 9:50
 */

namespace App\Contracts;


interface FoolContract
{
    const name = 'fool';
    public function doFool($controller);
}