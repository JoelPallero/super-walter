<?php
declare(strict_types=1);

require __DIR__ . '/_bootstrap.php';

if (!sw_admin_is_logged_in()) {
    header('Location: login.php');
    exit;
}
