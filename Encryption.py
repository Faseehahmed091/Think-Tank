from cryptography.fernet import Fernet
from config import ENCRYPTION_KEY

fernet = Fernet(ENCRYPTION_KEY)

def encrypt_data(data):
    return fernet.encrypt(data.encode()).decode()

def decrypt_data(encrypted_data):
    return fernet.decrypt(encrypted_data.encode()).decode()
