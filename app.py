from flask import Flask
from db import db
import config

# Importing Blueprints
from orders import orders_bp
from payments import payments_bp
from auth import auth_bp

app = Flask(__name__)

# Configurations
app.config.from_object("config")

# Initialize database
db.init_app(app)

# Register Blueprints
app.register_blueprint(orders_bp, url_prefix="/orders")
app.register_blueprint(payments_bp, url_prefix="/payments")
app.register_blueprint(auth_bp, url_prefix="/auth")

# Run app
if __name__ == "__main__":
    with app.app_context():
        db.create_all()  # Create tables if they don’t exist
    app.run(debug=True)
