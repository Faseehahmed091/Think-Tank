import base64
import os

# PayPal API credentials
PAYPAL_CLIENT_ID = "your-client-id"
PAYPAL_SECRET = "your-secret"
PAYPAL_API_BASE = "https://api-m.sandbox.paypal.com"  # Change to live URL when deploying

# Encryption setup
ENCRYPTION_KEY = base64.urlsafe_b64encode(os.urandom(32))
