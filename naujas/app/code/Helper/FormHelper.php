<?php

declare(strict_types=1);

namespace Helper;

class FormHelper
{
    private string $form;

    public function __construct($action, $method)
    {
        $this->form = '<form action="' . Url::link($action) . '" method="' . $method . '">';
    }

    public function input(array $data): void
    {
        $this->form .= '<input ';
        foreach ($data as $attribute => $value) {
            $this->form .= $attribute . ' = "' . $value . '" ';
        }
        $this->form .= ' ><br>';
    }

    public function textArea(string $name, string $placeholder): void
    {
        $this->form .= '<textarea name="' . $name . '">' . $placeholder . '</textarea><br>';
    }

    public function select(array $data): void
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

    public function label(string $text, string $for = null): void
    {
        $this->form .= '<label';
        if($for) {
            $this->form .= ' for="'.$for.'"';
        }
        $this->form .= '>'. $text .'</label><br>';
    }

    public function selectGroup(array $data): void
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

    public function getForm(): string
    {
        $this->form .= '</form>';

        return $this->form;
    }
}