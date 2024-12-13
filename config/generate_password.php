<?php
    // Mot-de-passe par le mot de passe haché
    $hashedPassword = password_hash('123456', PASSWORD_BCRYPT);

    // Affichez le mot de passe haché
    echo 'Mot de passe haché : ' . $hashedPassword;
?>
