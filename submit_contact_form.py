from flask import Flask, request
from Crypto.Cipher import AES
import base64
import os

app = Flask(__name__)

# Generate a random secret key
key = os.urandom(32)

# Define the AES encryption and decryption functions
def encrypt(message):
    iv = os.urandom(16)
    cipher = AES.new(key, AES.MODE_CBC, iv)
    padded_message = message + b"\0" * (AES.block_size - len(message) % AES.block_size)
    ciphertext = cipher.encrypt(padded_message)
    return base64.b64encode(iv + ciphertext)

def decrypt(ciphertext):
    ciphertext = base64.b64decode(ciphertext)
    iv = ciphertext[:AES.block_size]
    cipher = AES.new(key, AES.MODE_CBC, iv)
    plaintext = cipher.decrypt(ciphertext[AES.block_size:])
    return plaintext.rstrip(b"\0")

# Define the Flask route for handling the form submission
@app.route('/submit_contact_form.py', methods=['POST'])
def submit_contact_form():
    # Get the form data
    name = request.form['name']
    email = request.form['email']
    comment = request.form['comment']

    # Encrypt the data
    encrypted_name = encrypt(name.encode())
    encrypted_email = encrypt(email.encode())
    encrypted_comment = encrypt(comment.encode())

    # Store the encrypted data in a file or database
    with open('contacts.csv', 'a') as f:
        f.write(f'{encrypted_name},{encrypted_email},{encrypted_comment}\n')

    return 'Thank you for contacting us!'

if __name__ == '__main__':
    app.run()
