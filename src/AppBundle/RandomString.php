<?php

namespace AppBundle;

/**
 * Created by PhpStorm.
 * User: Menedyl
 * Date: 10/10/2017
 * Time: 20:16
 */
trait RandomString
{
    public function randomString(int $value)
    {

        $characters = 'azertyuiopqsdfghjklmwxcvbn';
        $charactersLength = strlen($characters);

        $randString = '';

        for ($i = 0; $i < $value; $i++) {
            $randString .= $characters[rand(0, ($charactersLength - 1))];
        }

        return $randString;
    }

}
