<?php
session_start();
if(!isset($_SESSION['user'])) {
   header("Location: index.php");
   exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans">

  <!-- Navbar -->
  <header class="bg-white shadow-md p-4 flex justify-between items-center">
    <h1 class="text-xl font-bold text-gray-800">Dashboard</h1>
    <div class="flex items-center space-x-4">
      <span class="text-gray-600">Welcome, Anil</span>
      <a href="../actions/logout.php" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">Logout</a>

    </div>
  </header>

  <div class="flex h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r shadow-md">
      <nav class="p-6 space-y-4">
        <a href="#" class="block text-gray-700 hover:text-blue-600 font-medium">Dashboard</a>
        <a href="#" class="block text-gray-700 hover:text-blue-600 font-medium">Users</a>
        <a href="#" class="block text-gray-700 hover:text-blue-600 font-medium">Settings</a>
        <a href="#" class="block text-gray-700 hover:text-blue-600 font-medium">Reports</a>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6 overflow-auto">
      <h2 class="text-2xl font-semibold mb-4">Overview</h2>

      <!-- Stats Cards -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white p-4 rounded shadow">
          <p class="text-gray-600">Users</p>
          <h3 class="text-2xl font-bold text-blue-600">120</h3>
        </div>
        <div class="bg-white p-4 rounded shadow">
          <p class="text-gray-600">Projects</p>
          <h3 class="text-2xl font-bold text-green-600">18</h3>
        </div>
        <div class="bg-white p-4 rounded shadow">
          <p class="text-gray-600">Revenue</p>
          <h3 class="text-2xl font-bold text-purple-600">$2,300</h3>
        </div>
      </div>

      <!-- Table Example -->
      <div class="bg-white p-4 rounded shadow">
        <h3 class="text-lg font-semibold mb-4">Recent Users</h3>
        <table class="w-full table-auto">
          <thead>
            <tr class="bg-gray-100 text-left">
              <th class="px-4 py-2">#</th>
              <th class="px-4 py-2">Name</th>
              <th class="px-4 py-2">Email</th>
              <th class="px-4 py-2">Mobile</th>
            </tr>
          </thead>
          <tbody id="userBody">
            <!-- Data will be inserted here via AJAX -->
          </tbody>
        </table>
      </div>
    </main>
  </div>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script>
  $.ajax({
    url: "../actions/fetch-users.php",
    method: "GET",
    dataType: "json",
    success: function(response) {
      if (response.success) {
        let html = "";
        response.users.forEach((user, index) => {
          html += `
          <tr class="border-b">
            <td class="px-4 py-2">${index + 1}</td>
            <td class="px-4 py-2">${user.name}</td>
            <td class="px-4 py-2">${user.email}</td>
            <td class="px-4 py-2">${user.mobile}</td>
          </tr>`;
        });
        $("#userBody").html(html);
      } else {
        alert("Failed to fetch users");
      }
    },
    error: function(xhr, status, error) {
      console.error(error);
      console.log(xhr.responseText);
    }
  });
  </script>

</body>

</html>