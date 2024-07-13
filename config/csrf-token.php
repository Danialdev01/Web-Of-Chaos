<?php

    function generateCSRFToken() {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    function verifyCSRFToken($token) {
        if (hash_equals($_SESSION['csrf_token'], $token)) {
            return true;
        } else {
            return false;
        }
    }

?>