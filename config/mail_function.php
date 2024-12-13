<?php
    /**
    * Fonction pour envoyer un email
    *
    * @param string $to L'adresse email du destinataire
    * @param string $subject Le sujet de l'email
    * @param string $message Le contenu de l'email
    * @return bool Retourne true si l'email a été envoyé avec succès, sinon false
    */
    function sendNotificationEmail($to, $subject, $message) {
    // les en-têtes pour l'email
    $headers = "From: samirolivier@gmail.com\r\n"; // Adresse de l'expéditeur
    $headers .= "Reply-To: samirolivier@gmail.com\r\n"; // Adresse pour répondre
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n"; // Type de contenu

    // Envoyer l'email
    return mail($to, $subject, $message, $headers);
    }
?>