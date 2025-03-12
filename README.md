# ntt-corephp

## Prerequisites
- PHP version 7.3 to 8.3
- UAT MID and keys provided by the NDPS team

## Project Structure
The project will contain the following files:
- `index.php` - Payment request initiation
- `response.php` - Handles the response part
- `AtomAES.php` - Encryption logic
- `cacert.pem` - Certificate required for server-to-server calls

## Installation
1. **Initiate Payment Request**: Use `index.php` to create and initiate the payment request.
2. **Modify JSON Request and Keys**: Make necessary changes in the JSON request and the keys used for encryption and decryption.
3. **Setup atomcheckout.js**: Configure `atomcheckout.js` according to UAT and Production environments.
4. **Include Certificate**: Include the `cacert.pem` file in the project and ensure the correct path is specified.
5. **Handle Response**: Use `response.php` to manage responses and update the decryption keys within `response.php`.