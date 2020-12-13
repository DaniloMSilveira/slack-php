<?php

// Função responsável por armazenar os atributos e construir o formato da mensagem
class SlackMessage {
    // variável a ser indicada a configuração do slack
    private $slack;
    // texto da mensagem
    public $text = "";
    // Inidica o usuario no Slack
    // Vazio => Será considerado a configuração padrão do Webhook integration
    public $username;
    // Inidica o canal no Slack
    // Vazio => Será considerado a configuração padrão do Webhook integration
    public $channel;
    // Seta um icone para o usuario no Slack
    // Vazio => Será considerado a configuração padrão do Webhook integration
    public $icon_url;
    // Seta um emoji para o usuario no Slack
    // Vazio => Será considerado a configuração padrão do Webhook integration
    public $icon_emoji;
    // Cria um attachments para a URL automaticamente
    // Vazio = seta o valor "false" como padrão
    public $unfurl_links;

    // Array para as instancias do SlackAttachment
    public $attachments;

    // Construtor (obrigatório passar a instancia da classe Slack)
    function __construct(Slack $slack) {
        $this->slack = $slack;
    }

    // // Funções para setar os valores aos atributos
    function setText($text) {
        $this->text = $text;
        return $this;
    }
    function setUsername($username) {
        $this->username = $username;
        return $this;
    }
    function setChannel($channel) {
        $this->channel = $channel;
        return $this;
    }
    function setEmoji($emoji) {
        $this->icon_emoji = $emoji;
        return $this;
    }
    function setIcon($url) {
        $this->icon_url = $url;
        return $this;
    }
    function setUnfurlLinks($bool) {
        $this->unfurl_links = $bool;
        return $this;
    }

    // Função responsável por adicionar um attachment a mensagem
    function addAttachment(SlackAttachment $attachment) {
        if (!isset($this->attachments)) {
            $this->attachments = array($attachment);
            return $this;
        }

        $this->attachments[] = $attachment;
        return $this;
    }

    // Função responsável por criar o array com o payload
    function toArray() {
        // Definindo os valores padrões
        if (isset($this->slack->username)) {
            $username = $this->slack->username;
        }
        if (isset($this->slack->channel)) {
            $channel = $this->slack->channel;
        }
        if (isset($this->slack->icon_url)) {
            $icon_url = $this->slack->icon_url;
        }
        if (isset($this->slack->icon_emoji)) {
            $icon_emoji = $this->slack->icon_emoji;
        }
        if (isset($this->slack->unfurl_links)) {
            $unfurl_links = $this->slack->unfurl_links;
        }

        // Sobreescrever os atributos caso seja passado uma configuração diferente
        if (isset($this->username)) {
            $username = $this->username;
        }
        if (isset($this->channel)) {
            $channel = $this->channel;
        }
        if (isset($this->icon_url)) {
            $icon_url = $this->icon_url;
        }
        if (isset($this->icon_emoji)) {
            $icon_emoji = $this->icon_emoji;
        }
        if (isset($this->unfurl_links)) {
            $unfurl_links = $this->unfurl_links;
        }

        $data = array(
            'text' => $this->text,
        );
        if (isset($username)) {
            $data['username'] = $username;
        }
        if (isset($channel)) {
            $data['channel'] = $channel;
        }
        if (isset($icon_url)) {
            $data['icon_url'] = $icon_url;
        } else {
            if (isset($icon_emoji)) {
                $data['icon_emoji'] = $icon_emoji;
            }
        }
        if (isset($unfurl_links)) {
            $data['unfurl_links'] = $unfurl_links;
        }
        if (isset($this->attachments)) {
            $attachments = array();
            foreach ($this->attachments as $attachment) {
                $attachments[] = $attachment->toArray();
            }
            $data['attachments'] = $attachments;
        }
        return $data;
    }

    // Função responsável para enviar a mensagem (chamar método PAI do slack)
    function send() {
        return $this->slack->send($this);
    }
}
?>