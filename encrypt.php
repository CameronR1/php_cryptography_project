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

$originalName = safeFileName($_FILES["file"]["name"]);
$tmpPath = $_FILES["file"]["tmp_name"];

$uploadPath = "uploads/" . $originalName;

if (!move_uploaded_file($tmpPath, $uploadPath)) {
    die("File upload failed.");
}

$fileData = file_get_contents($uploadPath);

if ($fileData === false) {
    die("Could not read uploaded file.");
}

$iv = random_bytes(16);
$salt = random_bytes(16);
$generatedHexKey = "";

if ($keyType === "password") {

    if (empty($keyInput)) {
        die("Password is required.");
    }

    $key = createKeyFromPassword($keyInput, $salt, $aesSize);

} elseif ($keyType === "hex") {

    if (empty($keyInput)) {
        die("Hex key is required.");
    }

    $key = createKeyFromHex($keyInput, $aesSize);

    if (!$key) {
        die("Invalid hex key length or format.");
    }

} elseif ($keyType === "generate") {

    $generatedHexKey = generateHexKey($aesSize);
    $key = createKeyFromHex($generatedHexKey, $aesSize);
    $keyType = "hex";

} else {
    die("Invalid key type.");
}

$encryptedData = openssl_encrypt(
    $fileData,
    $cipherMethod,
    $key,
    OPENSSL_RAW_DATA,
    $iv
);

if ($encryptedData === false) {
    die("Encryption failed.");
}

$metadata = [
    "original_name" => $originalName,
    "aes_size" => $aesSize,
    "key_type" => $keyType,
    "salt" => base64_encode($salt),
    "iv" => base64_encode($iv)
];

$metadataJson = json_encode($metadata);
$metadataLength = strlen($metadataJson);

$finalData = pack("N", $metadataLength) . $metadataJson . $encryptedData;

$encryptedFileName = $originalName . ".encrypted";
$encryptedPath = "encrypted/" . $encryptedFileName;

file_put_contents($encryptedPath, $finalData);

if (!empty($generatedHexKey)) {
    $keyFileName = "key_" . time() . ".txt";
    $keyPath = "keys/" . $keyFileName;

    file_put_contents($keyPath, $generatedHexKey);
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Encryption Complete</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <div class="card">
        <h1>Encryption Complete</h1>

        <p>Your file was encrypted successfully.</p>

        <p>
            <a href="<?php echo $encryptedPath; ?>" download>Download Encrypted File</a>
        </p>

        <?php if (!empty($generatedHexKey)) { ?>
            <p><strong>Generated Hex Key:</strong></p>
            <div class="key-box"><?php echo htmlspecialchars($generatedHexKey); ?></div>

            <p>
                <a href="<?php echo $keyPath; ?>" download>Download Key File</a>
            </p>

            <p class="warning">Save this key. You need it to decrypt the file.</p>
        <?php } ?>

        <a href="index.php">Back to Home</a>
    </div>
</div>

</body>
</html>