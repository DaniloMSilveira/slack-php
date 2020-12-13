<?php

class Slack {
    // Indica a URL do webhook a ser comunicado com o slack
    // WebhookUrl  https://hooks.slack.com/services/XXXXXXXXX/XXXXXXXXX/XXXXXXXXXXXXXXXXXXXXXXXX
    public $url;
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
    
    // Construtor => é apenas obrigatório a URL do Webhook
    function __construct($webhookUrl) {
        $this->url = $webhookUrl;
    }

    // Isset é responsável por verificar se a variável está setada, será utilizada para atribuição de valores posteriormente
    function __isset($property) {
        return isset($this->$property);
    }

    // Função para enviar a mensagem para o canal do slack indicado
    function send(SlackMessage $message) {
        $data = $message->toArray();

        try {
            $json = json_encode($data);

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => $this->url,
                CURLOPT_USERAGENT => 'cURL Request',
                CURLOPT_POST => 1,
                CURLOPT_POSTFIELDS => array('payload' => $json),
                CURLOPT_SSL_VERIFYPEER => false,
            ));
            $result = curl_exec($curl);

            if (!$result) {
                return false;
            }

            curl_close($curl);

            if ($result == 'ok') {
                return true;
            }

            return false;
        } catch (Exception $e) {
            return false;
        }
    }

    // Funções para setar os valores padrões
    function setDefaultUnfurlLinks($unfurl) {
        $this->unfurl_links = $unfurl;
        return $this;
    }
    function setDefaultChannel($channel) {
        $this->channel = $channel;
        return $this;
    }
    function setDefaultUsername($username) {
        $this->username = $username;
        return $this;
    }
    function setDefaultIcon($url) {
        $this->icon_url = $url;
        return $this;
    }
    function setDefaultEmoji($emoji) {
        $this->icon_emoji = $emoji;
        return $this;
    }
}
?>
