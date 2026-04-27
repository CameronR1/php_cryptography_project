<!DOCTYPE html>
<html>
<head>
    <title>PHP File Encryption Tool</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h1>PHP File Encryption Tool</h1>
    <p class="subtitle">Encrypt and decrypt files using AES-128, AES-192, or AES-256.</p>

    <div class="card">
        <h2>Encrypt a File</h2>

        <form action="encrypt.php" method="POST" enctype="multipart/form-data">

            <label>Select File</label>
            <input type="file" name="file" required>

            <label>AES Strength</label>
            <select name="aes_size" required>
                <option value="128">AES-128</option>
                <option value="192">AES-192</option>
                <option value="256">AES-256</option>
            </select>

            <label>Key Type</label>
            <select name="key_type" required>
                <option value="password">Password Generated Key</option>
                <option value="hex">Provide Hex Key</option>
                <option value="generate">Generate Hex Key</option>
            </select>

            <label>Password or Hex Key</label>
            <input type="text" name="key_input" placeholder="Enter password or hex key. Leave blank if generating key.">

            <button type="submit">Encrypt File</button>
        </form>
    </div>

    <div class="card">
        <h2>Decrypt a File</h2>

        <form action="decrypt.php" method="POST" enctype="multipart/form-data">

            <label>Select Encrypted File</label>
            <input type="file" name="file" required>

            <label>AES Strength</label>
            <select name="aes_size" required>
                <option value="128">AES-128</option>
                <option value="192">AES-192</option>
                <option value="256">AES-256</option>
            </select>

            <label>Key Type Used During Encryption</label>
            <select name="key_type" required>
                <option value="password">Password Generated Key</option>
                <option value="hex">Hex Key</option>
            </select>

            <label>Password or Hex Key</label>
            <input type="text" name="key_input" required>

            <button type="submit">Decrypt File</button>
        </form>
    </div>

    <div class="note">
        <p><strong>Folder Support:</strong> To encrypt a folder or multiple files, place them into a ZIP file first, then encrypt the ZIP file.</p>
    </div>
</div>

</body>
</html>