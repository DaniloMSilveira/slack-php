<?php

require './Slack/Slack.php';
require './Slack/SlackMessage.php';
require './Slack/SlackAttachment.php';

// Inclua abaixo a URL de sua Webhook
$slack = new Slack('');
$message = new SlackMessage($slack);

//Exemplo de mensagem a ser encaminhada
$message->setText("Mensagem enviada para o canal por webhook");

if ($message->send()) {
    echo "Enviado com sucesso";
} else {
    echo "Falha ao enviar a mensagem";
}


/* Exemplo de envio de attachment
$attachment = new SlackAttachment("Título do attachment.");
$attachment->setColor("#36a64f");
$attachment->setText("Texto para indicar dentro do attachment");
$attachment->setPretext("Texto para indicar acima do attachment");
$attachment->setAuthor(
    "Nome do autor", 
    "https://github.com/DaniloMSilveira", //link do autor
    "" // icone do autor
);
$attachment->setTitle("Titulo");
$attachment->setImage("");

// Habilita o tipo do formato do attachment
$attachment->enableMarkdownFor("text");
$attachment->enableMarkdownFor("pretext");
$attachment->enableMarkdownFor("fields");

 // Adicionar os campos e os valores dentro do attachment para dividir as sessões
$attachment->addField("Campo1", "Valor 1");
$attachment->addField("Campo2", "Valor 2", true);
$attachment->addField("Campo3", "Valor 3", false);

// Rodapé do attachment
$attachment->setFooterText('Danilo Martin');
$attachment->setFooterIcon('');
$attachment->setTimestamp(time());

// Add it to your message
$message->addAttachment($attachment);

if ($message->send()) {
    echo "Enviado com sucesso";
} else {
    echo "Falha ao enviar a mensagem";
}
*/

/* Exemplo de envio mensagem com botões
$message->setText("Siga abaixo os botoes para aprovar ou reprovar.");

$attachment = new SlackAttachment('Attachment para os botoes');
$attachment->addButton('Aprovar 👍', 'https://www.google.com/');
$attachment->addButton('Reprovar 👎', 'https://www.google.com/', 'danger');

$message->addAttachment($attachment);

if ($message->send()) {
    echo "Enviado com sucesso";
} else {
    echo "Falha ao enviar a mensagem";
}
*/