<?php
include "functions.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Invalid request.");
}

if (!isset($_FILES["file"])) {
    die("No file uploaded.");
}

$aesSize = $_POST["aes_size"];
$keyType = $_POST["key_type"];
$keyInput = $_POST["key_input"];

$cipherMethod = getCipherMethod($aesSize);

if (!$cipherMethod) {
    die("Invalid AES size selected.");
}

$fileName = safeFileName($_FILES["file"]["name"]);
$tmpPath = $_FILES["file"]["tmp_name"];

$uploadPath = "uploads/" . $fileName;

if (!move_uploaded_file($tmpPath, $uploadPath)) {
    die("File upload failed.");
}

$finalData = file_get_contents($uploadPath);

if ($finalData === false) {
    die("Could not read encrypted file.");
}

$metadataLengthData = substr($finalData, 0, 4);
$metadataLength = unpack("N", $metadataLengthData)[1];

$metadataJson = substr($finalData, 4, $metadataLength);
$encryptedData = substr($finalData, 4 + $metadataLength);

$metadata = json_decode($metadataJson, true);

if (!$metadata) {
    die("Invalid encrypted file format.");
}

$originalName = $metadata["original_name"];
$storedAesSize = $metadata["aes_size"];
$storedKeyType = $metadata["key_type"];
$salt = base64_decode($metadata["salt"]);
$iv = base64_decode($metadata["iv"]);

if ($storedAesSize !== $aesSize) {
    die("AES size does not match the encrypted file.");
}

if ($keyType === "password") {

    if ($storedKeyType !== "password") {
        die("This file was not encrypted with a password.");
    }

    $key = createKeyFromPassword($keyInput, $salt, $aesSize);

} elseif ($keyType === "hex") {

    if ($storedKeyType !== "hex") {
        die("This file was not encrypted with a hex key.");
    }

    $key = createKeyFromHex($keyInput, $aesSize);

    if (!$key) {
        die("Invalid hex key length or format.");
    }

} else {
    die("Invalid key type.");
}

$decryptedData = openssl_decrypt(
    $encryptedData,
    $cipherMethod,
    $key,
    OPENSSL_RAW_DATA,
    $iv
);

if ($decryptedData === false) {
    die("Decryption failed. Wrong password/key or corrupted file.");
}

$decryptedPath = "decrypted/" . $originalName;

file_put_contents($decryptedPath, $decryptedData);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Decryption Complete</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <div class="card">
        <h1>Decryption Complete</h1>

        <p>Your file was decrypted successfully.</p>

        <p>
            <a href="<?php echo $decryptedPath; ?>" download>Download Decrypted File</a>
        </p>

        <a href="index.php">Back to Home</a>
    </div>
</div>

</body>
</html>