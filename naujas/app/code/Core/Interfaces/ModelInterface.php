<?php

namespace Core\Interfaces;

interface ModelInterface
{
    public function load(int $id);
    public function assignData();
}