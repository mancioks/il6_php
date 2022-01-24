<?php

class FormHelper
{
    private $form;

    public function __construct()
    {
        $this->form = '';
    }

    public function getForm() {
        return $this->form;
    }
}