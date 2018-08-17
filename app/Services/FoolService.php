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
    public $msg;

    public function doFool($msg)
    {
        $this->msg = $msg;
        $time = Date("YmdHis",time());
        file_put_contents(public_path('dofools').'/'. $msg . '-' . $time . '.txt', $time);
    }
}