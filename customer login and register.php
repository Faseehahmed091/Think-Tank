<?php include('navbar.php'); ?>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <!-- Nav tabs for toggle -->
      <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
          <button class="nav-link active" id="login-tab">Login</button>
        </li>
        <li class="nav-item">
          <button class="nav-link" id="register-tab">Register</button>
        </li>
      </ul>

      <!-- Login Form -->
      <div id="login-form">
        <form id="loginForm">
          <div class="mb-3">
            <input type="email" class="form-control" id="login-email" placeholder="Email" required>
          </div>
          <div class="mb-3">
            <input type="password" class="form-control" id="login-password" placeholder="Password" required>
          </div>
          <button type="submit" class="btn btn-success w-100">Login</button>
        </form>
      </div>

      <!-- Registration Form -->
      <div id="register-form" style="display:none;">
        <form id="registerForm">
          <div class="mb-3">
            <input type="text" class="form-control" id="register-name" placeholder="Full Name" required>
          </div>
          <div class="mb-3">
            <input type="email" class="form-control" id="register-email" placeholder="Email" required>
          </div>
          <div class="mb-3">
            <input type="password" class="form-control" id="register-password" placeholder="Password" required>
          </div>
          <button type="submit" class="btn btn-success w-100">Register</button>
        </form>
      </div>

      <!-- Alert box for API messages -->
      <div id="message" class="alert mt-3" style="display:none;"></div>
    </div>
  </div>

  <!-- Carousel Integration -->
  <div id="carouselExample" class="carousel slide my-5">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="img1.jpg" class="d-block w-100" alt="Welcome">
        <div class="carousel-caption">Welcome to Pick n Go!</div>
      </div>
      <div class="carousel-item">
        <img src="img2.jpg" class="d-block w-100" alt="Quality Products">
        <div class="carousel-caption">Quality Products Delivered</div>
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
    </button>
  </div>
</div>

<?php include('footer.php'); ?>

<script>
// Form toggle functionality
document.getElementById('login-tab').onclick = function(){
  document.getElementById('login-form').style.display = 'block';
  document.getElementById('register-form').style.display = 'none';
  this.classList.add('active');
  document.getElementById('register-tab').classList.remove('active');
};
document.getElementById('register-tab').onclick = function(){
  document.getElementById('register-form').style.display = 'block';
  document.getElementById('login-form').style.display = 'none';
  this.classList.add('active');
  document.getElementById('login-tab').classList.remove('active');
};

// API Integration with fetch
function handleSubmit(formId, apiUrl, data){
  fetch(apiUrl, {
    method: 'POST',
    headers: {'Content-Type':'application/json'},
    body: JSON.stringify(data)
  })
  .then(res => res.json())
  .then(response => {
    const messageBox = document.getElementById('message');
    messageBox.style.display = 'block';
    if(response.success){
      messageBox.className = 'alert alert-success';
      messageBox.innerHTML = response.message;
    }else{
      messageBox.className = 'alert alert-danger';
      messageBox.innerHTML = response.message;
    }
  })
  .catch(error => console.error('Error:', error));
}

// Login form submission
loginForm.onsubmit = function(e){
  e.preventDefault();
  handleSubmit('loginForm', 'api/login.php', {
    email: document.getElementById('login-email').value,
    password: document.getElementById('login-password').value
  });
};

// Registration form submission
registerForm.onsubmit = function(e){
  e.preventDefault();
  handleSubmit('registerForm', 'api/register.php', {
    name: document.getElementById('register-name').value,
    email: document.getElementById('register-email').value,
    password: document.getElementById('register-password').value
  });
};
</script>