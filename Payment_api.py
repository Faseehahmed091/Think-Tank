from flask import Blueprint, request, jsonify
from payment_gateway import get_paypal_access_token, create_paypal_order
from models import db, Order
from encryption import encrypt_data
import requests

payment_bp = Blueprint('payment', __name__)

@payment_bp.route("/payments/process", methods=["POST"])
def process_payment():
    data = request.json
    amount = data.get("amount")

    if not amount:
        return jsonify({"error": "Amount is required"}), 400

    access_token = get_paypal_access_token()
    order_data = create_paypal_order(amount, access_token)

    paypal_order_id = order_data["id"]

    # Store order in database
    new_order = Order(paypal_order_id=paypal_order_id)
    db.session.add(new_order)
    db.session.commit()

    approval_url = next(link["href"] for link in order_data["links"] if link["rel"] == "approve")
    return jsonify({"approval_url": approval_url, "order_id": paypal_order_id})


@payment_bp.route("/payments/status/<order_id>", methods=["GET"])
def check_payment_status(order_id):
    access_token = get_paypal_access_token()
    response = requests.get(
        f"{PAYPAL_API_BASE}/v2/checkout/orders/{order_id}",
        headers={"Authorization": f"Bearer {access_token}"}
    )

    if response.status_code != 200:
        return jsonify({"error": "Failed to fetch order status"}), response.status_code

    order_data = response.json()
    order_status = order_data["status"]

    # Find the order in the database
    order = Order.query.filter_by(paypal_order_id=order_id).first()
    if not order:
        return jsonify({"error": "Order not found"}), 404

    if order_status == "COMPLETED" and order.status != "COMPLETED":
        capture_link = next((link["href"] for link in order_data["links"] if link["rel"] == "capture"), None)

        if capture_link:
            capture_response = requests.post(
                capture_link,
                headers={"Authorization": f"Bearer {access_token}"}
            )

            if capture_response.status_code != 201:
                return jsonify({"error": "Failed to capture payment"}), 400

            capture_data = capture_response.json()
            transaction_id = capture_data["id"]
            payer_email = encrypt_data(capture_data["payer"]["email_address"])
            amount_paid = float(capture_data["purchase_units"][0]["payments"]["captures"][0]["amount"]["value"])

            # Update order in database
            order.status = "COMPLETED"
            order.transaction_id = transaction_id
            order.payer_email = payer_email
            order.amount_paid = amount_paid
            db.session.commit()

    return jsonify({
        "order_id": order.paypal_order_id,
        "status": order.status,
        "transaction_id": order.transaction_id,
        "payer_email": order.payer_email,  # ⚠️ This is encrypted, decrypt if needed
        "amount_paid": order.amount_paid
    })
