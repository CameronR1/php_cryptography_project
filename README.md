# php_cryptography_project
PHP AES File Encryption Tool for secure data-at-rest protection.
# PHP File Encryption Tool

## Overview

This project is a PHP-based encryption and decryption application created for the CYBR 448 Final Project. It provides secure protection for data at rest by allowing users to encrypt and decrypt files using Advanced Encryption Standard (AES) symmetric encryption.

The tool was designed to demonstrate confidentiality and integrity concepts learned throughout the semester using practical cryptographic implementation.

---

## Features

- Encrypt a single file
- Decrypt encrypted files
- Supports AES-128, AES-192, and AES-256
- Supports password-derived keys
- Supports true hexadecimal cryptographic keys
- Supports generated random cryptographic keys
- Web-based interface using PHP
- Folder / multiple file support through ZIP file encryption

---

## Technologies Used

- PHP
- OpenSSL Extension for PHP
- HTML / CSS
- XAMPP (Apache Server)

---

## Cryptographic Tools / Libraries Used

- `openssl_encrypt()`
- `openssl_decrypt()`
- `random_bytes()`
- `hash_pbkdf2()`
- `bin2hex()`
- `hex2bin()`

---

## Encryption Algorithms Supported

- AES-128-CBC
- AES-192-CBC
- AES-256-CBC

---

## Folder Structure

php_crypto_project/
- index.php
- encrypt.php
- decrypt.php
- functions.php
- style.css
- README.md

Folders:
- uploads/
- encrypted/
- decrypted/
- keys/

---

## How to Run the Project

1. Install XAMPP.
2. Place the project folder inside:

C:\xampp\htdocs\php_crypto_project

3. Start Apache in XAMPP.
4. Open browser and go to:

http://localhost/php_crypto_project/

---

## How to Encrypt a File

1. Select a file.
2. Choose AES-128, AES-192, or AES-256.
3. Choose:
   - Password Key
   - Hex Key
   - Generate Key
4. Click **Encrypt File**.
5. Download the encrypted file.

---

## How to Decrypt a File

1. Upload the encrypted file.
2. Select the same AES version used during encryption.
3. Enter the same password or hex key.
4. Click **Decrypt File**.
5. Download the restored file.

---

## Multiple Files / Folder Support

To encrypt multiple files or folders:

1. Compress them into a ZIP file.
2. Upload the ZIP file.
3. Encrypt normally.
4. Decrypt later and extract.

---

## Security Notes

- Users must store their password or generated key safely.
- Without the correct key, files cannot be decrypted.
- AES is an industry-standard symmetric encryption algorithm widely used to secure sensitive data.

---

## Author

Cameron Rockingham  
Christopher Newport University  
CYBR 448 - Spring 2026

---

## Project Purpose

This project demonstrates practical use of cryptography to secure stored data while applying real-world cybersecurity principles through software development.
