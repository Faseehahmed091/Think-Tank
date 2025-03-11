import os

# Database Configuration
SQLALCHEMY_DATABASE_URI = "sqlite:///orders.db"
SQLALCHEMY_TRACK_MODIFICATIONS = False

# PayPal API Credentials
PAYPAL_CLIENT_ID = "your-client-id"
PAYPAL_SECRET = "your-secret"
PAYPAL_API_BASE = "https://api-m.sandbox.paypal.com"  # Change for production

# Encryption Key (For storing sensitive payment details)
ENCRYPTION_KEY = os.urandom(32)  # Store this securely
