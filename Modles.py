from flask_sqlalchemy import SQLAlchemy

db = SQLAlchemy()

class Order(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    paypal_order_id = db.Column(db.String(100), unique=True, nullable=False)
    status = db.Column(db.String(20), default="PENDING")  # PENDING, COMPLETED, FAILED
    transaction_id = db.Column(db.String(100), unique=True, nullable=True)
    payer_email = db.Column(db.String(255), nullable=True)  # Encrypted Email
    amount_paid = db.Column(db.Float, nullable=True)
