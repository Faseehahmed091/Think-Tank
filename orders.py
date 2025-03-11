from flask import Blueprint, request, jsonify
from db import db
from models import Order
import requests
import config

orders_bp = Blueprint("orders", __name__)

# External Inventory API URL
INVENTORY_API_URL = "https://inventory.api.com/get-stock"  # Example URL

# Create a new order
@orders_bp.route("/", methods=["POST"])
def create_order():
    data = request.json
    product_id = data.get("product_id")
    quantity = data.get("quantity")

    # Check inventory availability
    response = requests.get(f"{INVENTORY_API_URL}/{product_id}")
    if response.status_code != 200 or response.json().get("stock") < quantity:
        return jsonify({"error": "Insufficient stock"}), 400

    # Create order
    new_order = Order(product_id=product_id, quantity=quantity, status="PENDING")
    db.session.add(new_order)
    db.session.commit()

    return jsonify({"order_id": new_order.id, "status": new_order.status})

# Get order details
@orders_bp.route("/<int:order_id>", methods=["GET"])
def get_order(order_id):
    order = Order.query.get(order_id)
    if not order:
        return jsonify({"error": "Order not found"}), 404

    return jsonify({"order_id": order.id, "status": order.status, "product_id": order.product_id, "quantity": order.quantity})

# Update order status
@orders_bp.route("/<int:order_id>", methods=["PUT"])
def update_order_status(order_id):
    data = request.json
    new_status = data.get("status")

    order = Order.query.get(order_id)
    if not order:
        return jsonify({"error": "Order not found"}), 404

    order.status = new_status
    db.session.commit()

    return jsonify({"order_id": order.id, "status": order.status})
