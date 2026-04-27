<?php

function getCipherMethod($aesSize) {
    if ($aesSize == "128") {
        return "aes-128-cbc";
    } elseif ($aesSize == "192") {
        return "aes-192-cbc";
    } elseif ($aesSize == "256") {
        return "aes-256-cbc";
    } else {
        return false;
    }
}

function getKeyLength($aesSize) {
    if ($aesSize == "128") {
        return 16;
    } elseif ($aesSize == "192") {
        return 24;
    } elseif ($aesSize == "256") {
        return 32;
    } else {
        return false;
    }
}

function generateHexKey($aesSize) {
    $keyLength = getKeyLength($aesSize);

    if (!$keyLength) {
        return false;
    }

    return bin2hex(random_bytes($keyLength));
}

function createKeyFromPassword($password, $salt, $aesSize) {
    $keyLength = getKeyLength($aesSize);

    return hash_pbkdf2(
        "sha256",
        $password,
        $salt,
        100000,
        $keyLength,
        true
    );
}

function createKeyFromHex($hexKey, $aesSize) {
    $keyLength = getKeyLength($aesSize);

    if (!ctype_xdigit($hexKey)) {
        return false;
    }

    if (strlen($hexKey) !== ($keyLength * 2)) {
        return false;
    }

    return hex2bin($hexKey);
}

function safeFileName($fileName) {
    return preg_replace("/[^a-zA-Z0-9._-]/", "_", basename($fileName));
}
?>