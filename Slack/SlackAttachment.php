<?php

require('SlackAttachmentField.php');

class SlackAttachment {
    // Obrigatório
    public $fallback = "";

    // Opcional
    public $color;
    public $pretext;
    public $author_name;
    public $author_icon;
    public $author_link;
    public $title;
    public $title_link;
    public $text;
    public $fields;
    public $mrkdwn_in;
    public $image_url;
    public $thumb_url;

    // Rodapé do attachment
    public $footer;
    public $footer_icon;
    public $ts;

    // Ações
    public $actions;

    function __construct($fallback) {
        $this->fallback = $fallback;
    }

    // Cores aceitadas: "good", "warning", "danger" ou qualquer código hexadecimal
    function setColor($color) {
        $this->color = $color;
        return $this;
    }

    function setText($text) {
        $this->text = $text;
        return $this;
    }

    // Texto opcional para aparecer acima do blodo de anexo
    function setPretext($pretext) {
        $this->pretext = $pretext;
        return $this;
    }

    // Função para setar o Autor no attachment, indicando seu nome, URL para perfil e ícone
    function setAuthor($author_name, $author_link = NULL, $author_icon = NULL) {
        $this->setAuthorName($author_name);
        if (isset($author_link)) {
            $this->setAuthorLink($author_link);
        }
        if (isset($author_icon)) {
            $this->setAuthorIcon($author_icon);
        }
        return $this;
    }

    function setAuthorName($author_name) {
        $this->author_name = $author_name;
        return $this;
    }
    function setAuthorIcon($author_icon) {
        $this->author_icon = $author_icon;
        return $this;
    }
    function setAuthorLink($author_link) {
        $this->author_link = $author_link;
        return $this;
    }

    // Indicado as configurações do attachment para "pretext", "text" or "fields".
    function enableMarkdownFor($mrkdwn_in) {
        if (!isset($this->mrkdwn_in_fields)) {
            $this->mrkdwn_in_fields = array($mrkdwn_in);
            return $this;
        }
        $this->mrkdwn_in_fields[] = $mrkdwn_in;
        return $this;
    }


    // Indicado o título da mensagem do attachment
    function setTitle($title, $link = NULL) {
        $this->title = $title;
        if (isset($link)) {
            $this->title_link = $link;
        }
        return $this;
    }

    // Imagem exibida dentro de um attachment
    function setImage($url) {
        $this->image_url = $url;
        return $this;
    }

    // Será indicado a URL de uma imagem para aparecer ao lado direito do attachment
    function setThumbnail($url) {
        $this->thumb_url = $url;
        return $this;
    }

    // Setar o texto do rodapé
    function setFooterText($text) {
        $this->footer = $text;
        return $this;
    }

    // Setar o ícone do rodapé
    function setFooterIcon($url) {
        $this->footer_icon = $url;
        return $this;
    }

    // Indicar o horário como data/hora no rodapé da mensagem
    function setTimestamp($timestamp) {
        $this->ts = $timestamp;
        return $this;
    }

    // Criar uma instância para incluir os campos no attachment    
    function addFieldInstance(SlackAttachmentField $field) {
        if (!isset($this->fields)) {
            $this->fields = array($field);
            return $this;
        }
        $this->fields[] = $field;
        return $this;
    }

    // Adicionar campos para a instância
    function addField($title, $value, $short = NULL) {
        return $this->addFieldInstance(new SlackAttachmentField($title, $value, $short));
    }

    // Adicionar ações
    private function addAction($action) {
        if (!isset($this->actions)) {
            $this->actions = array($action);
            return $this;
        }
        $this->actions[] = $action;
        return $this;
    }

    // Função para criar um botão dentro do attachment
    function addButton($text, $url, $style = null) {
        $action = (object) [
            "type" => "button",
            "text" => $text,
            "url" => $url,
        ];
        if (isset($style)) {
            $action->style = $style;
        }
        $this->addAction($action);
        return $this;
    }

    // Função responsável por criar o array com o payload
    function toArray() {
        $data = array(
            'fallback' => $this->fallback,
        );
        if (isset($this->color)) {
            $data['color'] = $this->color;
        }
        if (isset($this->pretext)) {
            $data['pretext'] = $this->pretext;
        }
        if (isset($this->author_name)) {
            $data['author_name'] = $this->author_name;
        }
        if (isset($this->mrkdwn_in_fields)) {
            $data['mrkdwn_in'] = $this->mrkdwn_in_fields;
        }
        if (isset($this->author_link)) {
            $data['author_link'] = $this->author_link;
        }
        if (isset($this->author_icon)) {
            $data['author_icon'] = $this->author_icon;
        }
        if (isset($this->title)) {
            $data['title'] = $this->title;
        }
        if (isset($this->title_link)) {
            $data['title_link'] = $this->title_link;
        }
        if (isset($this->text)) {
            $data['text'] = $this->text;
        }
        if (isset($this->fields)) {
            $fields = array();
            foreach ($this->fields as $field) {
                $fields[] = $field->toArray();
            }
            $data['fields'] = $fields;
        }
        if (isset($this->image_url)) {
            $data['image_url'] = $this->image_url;
        }
        if (isset($this->thumb_url)) {
            $data['thumb_url'] = $this->thumb_url;
        }
        if (isset($this->footer)) {
            $data['footer'] = $this->footer;
        }
        if (isset($this->footer_icon)) {
            $data['footer_icon'] = $this->footer_icon;
        }
        if (isset($this->ts)) {
            $data['ts'] = $this->ts;
        }
        if (isset($this->actions)) {
            $data['actions'] = (array) $this->actions;
        }

        return $data;
    }
}
?>