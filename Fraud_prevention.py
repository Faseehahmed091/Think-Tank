import requests
from config import PAYPAL_API_BASE

def verify_paypal_webhook(headers, body, webhook_id, access_token):
    verification_response = requests.post(
        f"{PAYPAL_API_BASE}/v1/notifications/verify-webhook-signature",
        json={
            "auth_algo": headers.get("PAYPAL-AUTH-ALGO"),
            "cert_url": headers.get("PAYPAL-CERT-URL"),
            "transmission_id": headers.get("PAYPAL-TRANSMISSION-ID"),
            "transmission_sig": headers.get("PAYPAL-TRANSMISSION-SIG"),
            "transmission_time": headers.get("PAYPAL-TRANSMISSION-TIME"),
            "webhook_id": webhook_id,
            "webhook_event": body
        },
        headers={"Authorization": f"Bearer {access_token}"}
    )

    return verification_response.json()["verification_status"]
