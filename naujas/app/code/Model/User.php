<?php

namespace Model;

use Helper\DBHelper;

class User
{
    public static function emailUniq($email) {
        $db = new DBHelper();

        $rez = $db->select()->from('users')->where('email', $email)->get();

        return empty($rez);
        //return $rez;
    }


}