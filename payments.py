from flask import Blueprint, request, jsonify
from db import db
from models import Order
import requests
import config

payments_bp = Blueprint("payments", __name__)

def get_paypal_access_token():
    auth_response = requests.post(
        f"{config.PAYPAL_API_BASE}/v1/oauth2/token",
        auth=(config.PAYPAL_CLIENT_ID, config.PAYPAL_SECRET),
        data={"grant_type": "client_credentials"},
    )
    return auth_response.json()["access_token"]

# Process Payment
@payments_bp.route("/process", methods=["POST"])
def process_payment():
    data = request.json
    order_id = data.get("order_id")

    order = Order.query.get(order_id)
    if not order:
        return jsonify({"error": "Order not found"}), 404

    access_token = get_paypal_access_token()
    order_payload = {
        "intent": "CAPTURE",
        "purchase_units": [{"amount": {"currency_code": "USD", "value": "20.00"}}],
        "application_context": {"return_url": "http://localhost:5000/success"}
    }

    response = requests.post(
        f"{config.PAYPAL_API_BASE}/v2/checkout/orders",
        json=order_payload,
        headers={"Authorization": f"Bearer {access_token}", "Content-Type": "application/json"}
    )

    order_data = response.json()
    order.paypal_order_id = order_data["id"]
    db.session.commit()

    approval_url = next(link["href"] for link in order_data["links"] if link["rel"] == "approve")
    return jsonify({"approval_url": approval_url, "order_id": order.paypal_order_id})

# Check Payment Status
@payments_bp.route("/status/<order_id>", methods=["GET"])
def check_payment_status(order_id):
    access_token = get_paypal_access_token()
    response = requests.get(
        f"{config.PAYPAL_API_BASE}/v2/checkout/orders/{order_id}",
        headers={"Authorization": f"Bearer {access_token}"}
    )

    order_data = response.json()
    order = Order.query.filter_by(paypal_order_id=order_id).first()
    if not order:
        return jsonify({"error": "Order not found"}), 404

    if order_data["status"] == "COMPLETED":
        order.status = "COMPLETED"
        db.session.commit()

    return jsonify({"order_id": order.id, "status": order.status})
