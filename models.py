from db import db

class Order(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    product_id = db.Column(db.Integer, nullable=False)
    quantity = db.Column(db.Integer, nullable=False)
    status = db.Column(db.String(20), default="PENDING")
    paypal_order_id = db.Column(db.String(100), unique=True, nullable=True)
