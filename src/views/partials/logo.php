<?php
/** Logo Skatearth : l'image img/logo.png si elle existe, sinon le nom en texte. */
$logo = image_url('logo.png');
?>
<?php if ($logo !== null) { ?>
    <img src="<?= e($logo) ?>" alt="Skatearth">
<?php } else { ?>
    <span class="logo-text">SKATEARTH</span>
<?php } ?>
