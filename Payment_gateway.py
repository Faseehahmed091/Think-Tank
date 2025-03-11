import requests
from config import PAYPAL_CLIENT_ID, PAYPAL_SECRET, PAYPAL_API_BASE

def get_paypal_access_token():
    auth_response = requests.post(
        f"{PAYPAL_API_BASE}/v1/oauth2/token",
        auth=(PAYPAL_CLIENT_ID, PAYPAL_SECRET),
        data={"grant_type": "client_credentials"},
    )
    return auth_response.json()["access_token"]

def create_paypal_order(amount, access_token):
    order_payload = {
        "intent": "CAPTURE",
        "purchase_units": [{"amount": {"currency_code": "USD", "value": str(amount)}}],
        "application_context": {"return_url": "http://localhost:5000/success"}
    }

    response = requests.post(
        f"{PAYPAL_API_BASE}/v2/checkout/orders",
        json=order_payload,
        headers={"Authorization": f"Bearer {access_token}", "Content-Type": "application/json"}
    )
    return response.json()
