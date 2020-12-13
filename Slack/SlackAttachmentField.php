<?php

// Função responsável por adicionar os campos em um attachment
class SlackAttachmentField {
    // Obrgiatórios
    public $title = "";
    public $value = "";

    // Opcional
    public $short;

    function __construct($title, $value, $short = NULL) {
        $this->title = $title;
        $this->value = $value;
        if (isset($short)) {
            $this->short = $short;
        }
    }

    function setShort($bool = true) {
        $this->short = $bool;
        return $this;
    }

    function toArray() {
        $data = array(
            'title' => $this->title,
            'value' => $this->value,
        );
        if (isset($this->short)) {
            $data['short'] = $this->short;
        }
        return $data;
    }
}
?>