from flask import Flask
from models import db
from payment_api import payment_bp

app = Flask(__name__)

# Configure app
app.config.from_object('config')

# Initialize extensions
db.init_app(app)

# Register blueprints
app.register_blueprint(payment_bp)

if __name__ == "__main__":
    app.run(debug=True)
