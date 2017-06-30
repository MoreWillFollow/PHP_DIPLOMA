<?php

/**
 * Created by PhpStorm.
 * User: user
 * Date: 29.06.17
 * Time: 13:15
 */
class mdPassword
{

    private $salt = '6464321564dsa654f651asdf2165345531#@$%$^%##$]\]q]\az.xc,mfsd==/9874-+-+45486$*&&#55HQ7$5$7QW';
    function makeHash($password) {
        $hashpassword = md5($password);
        return $hashpassword;
    }

}