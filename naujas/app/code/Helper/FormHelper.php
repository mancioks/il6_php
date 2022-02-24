<?php

namespace Helper;

class FormHelper
{
    private $form;

    public function __construct($action, $method)
    {
        $this->form = '<form action="' . Url::link($action) . '" method="' . $method . '">';
    }

    public function input($data)
    {
        $this->form .= '<input ';
        foreach ($data as $attribute => $value) {
            $this->form .= $attribute . ' = "' . $value . '" ';
        }
        $this->form .= ' ><br>';
    }

    public function textArea($name, $placeholder)
    {
        $this->form .= '<textarea name="' . $name . '">' . $placeholder . '</textarea><br>';
    }

    public function select($data)
    {
        $this->form .= '<select name="' . $data["name"] . '">';

        foreach ($data["options"] as $value => $option) {
            $this->form .= '<option ';

            if (isset($data["selected"])) {
                if ($data["selected"] == $value) {
                    $this->form .= "selected ";
                }
            }

            $this->form .= 'value="' . $value . '">' . $option . '</option>';
        }

        $this->form .= '</select><br>';
    }

    public function label($text, $for = null) {
        $this->form .= '<label';
        if($for) {
            $this->form .= ' for="'.$for.'"';
        }
        $this->form .= '>'. $text .'</label><br>';
    }

    public function selectGroup($data)
    {
        $this->form .= '<select name="' . $data["name"] . '">';

        foreach($data["group"] as $groupName => $group) {
            $this->form .= '<optgroup label="'.$groupName.'">';
            foreach ($group as $value => $option) {
                $this->form .= '<option ';

                if (isset($data["selected"])) {
                    if ($data["selected"] == $value) {
                        $this->form .= "selected ";
                    }
                }

                $this->form .= 'value="' . $value . '">' . $option . '</option>';
            }
            $this->form .= "</optgroup>";
        }

        $this->form .= '</select><br>';
    }

    public function getForm()
    {
        $this->form .= '</form>';

        return $this->form;
    }
}