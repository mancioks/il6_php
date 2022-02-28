<?php

namespace Controller;

use Core\AbstractController;
use Core\Interfaces\ControllerInterface;
use Model\Ad;

class Home extends AbstractController implements ControllerInterface
{
    public function index()
    {
        $newAds = Ad::getAll(["order_by" => "id", "clause" => "DESC", "limit" => 5]);
        $popularAds = Ad::getAll(["order_by" => "views", "clause" => "DESC", "limit" => 5]);

        $this->data["new_ads"] = $newAds;
        $this->data["popular_ads"] = $popularAds;
        $this->render('parts/home');
    }
}