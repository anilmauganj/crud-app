<?php
session_start();
if (isset($_SESSION['user'])) {
    header("Location: dashboard.php"); // Or your user list page
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Login - User System</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- jQuery for AJAX -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<body class="bg-gray-100 h-screen flex items-center justify-center">

  <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-sm">
    <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>
    <form id="loginForm">


      <div class="mb-4">
        <label for="email" class="block mb-1 text-sm font-medium">Email</label>
        <input type="email" name="email" id="email" required
          class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300" />
      </div>

      <div class="mb-6">
        <label for="password" class="block mb-1 text-sm font-medium">Password</label>
        <input type="password" name="password" id="password" required
          class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300" />
      </div>


      <button type="submit"
        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition">
        Login
      </button>

    </form>
    <div id="loginMsg" class="text-center text-red-500 mt-4 hidden">Invalid credentials</div>
  </div>

  <script>
  $("#loginForm").on("submit", function(e) {
    e.preventDefault();
    $.post("../actions/login.php", $(this).serialize(), function(res) {
      let data = JSON.parse(res);
      if (data.success) {
        window.location.href = "dashboard.php"; // Redirect after login
      } else {
        $("#loginMsg").removeClass("hidden");
      }
    });
  });
  </script>

</body>

</html>