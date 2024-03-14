<?php
session_start();
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <div>
    <?php if ($user) { ?>
      <logout>Sudah login</logout>
      <a href="/logout.php">
        Logout
      </a>

    <?php } ?>
  </div>

  <div id="response-register"></div>
  <form id="register">
    <h1>Register</h1>
    <input type="text" name="name" id="name" placeholder="Name" required>
    <input type="email" name="email" id="email" placeholder="Email" required>
    <input type="password" name="password" id="password" placeholder="Password" required>
    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm Your Password"
      required>
    <button type="submit">Register</button>
  </form>

  <div id="response-login"></div>
  <form id="login">
    <h1>Login</h1>
    <input type="email" name="email" id="email" placeholder="Email" required>
    <input type="password" name="password" id="password" placeholder="Password" required>
    <button type="submit" <?php echo $user ? "disabled" : ""; ?>>Login</button>
  </form>

  <?php if ($user) { ?>
    <form id="student" action="/student_store.php" method="POST">
      <h1>Student form</h1>
      <input type="text" name="fullname" id="fullname" placeholder="Fullname" required>
      <input type="text" name="age" id="age" placeholder="Age" required>
      <input type="text" name="class" id="class" placeholder="Class" required>
      <button type="submit">Save</button>
    </form>
  <?php } ?>

  <script>
    const responseRegister = document.querySelector('#response-register')
    document.querySelector('#register').addEventListener('submit', (e) => {
      e.preventDefault()
      const payload = {
        name: document.querySelector('#register input#name').value,
        email: document.querySelector('#register input#email').value,
        password: document.querySelector('#register input#password').value,
        password_confirmation: document.querySelector('#register input#password_confirmation').value,
      }

      fetch('/register.php', {
        method: 'POST',
        body: JSON.stringify(payload),
        headers: {
          'Content-Type': 'application/json'
        }
      })
        .then(res => res.json())
        .then(data => {
          console.log(data)
          responseRegister.innerHTML = JSON.stringify(data)
        })
        .catch(err => {
          responseRegister.innerHTML = JSON.stringify(err)
        })
    })

    // LOGIN
    document.querySelector('#login').addEventListener('submit', (e) => {
      e.preventDefault()
      const payload = {
        email: document.querySelector('#login input#email').value,
        password: document.querySelector('#login input#password').value,
      }

      fetch('/login.php', {
        method: 'POST',
        body: JSON.stringify(payload),
        headers: {
          'Content-Type': 'application/json'
        }
      })
        .then(res => res.json())
        .then(data => {
          console.log(data)
          // responseRegister.innerHTML = JSON.stringify(data)
          responseRegister.innerHTML = 'login success, will redirect in 5 seconds'
          setTimeout(() => {
            window.location.reload()
          }, 5000)
        })
        .catch(err => {
          responseRegister.innerHTML = JSON.stringify(err)
        })
    })
  </script>
</body>

</html>