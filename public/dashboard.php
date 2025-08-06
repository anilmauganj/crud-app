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
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
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
        <table id="usersTable" class="w-full table-auto">
          <thead>
            <tr class="bg-gray-100 text-left">
              <th class="px-4 py-2">#</th>
              <th class="px-4 py-2">Name</th>
              <th class="px-4 py-2">Email</th>
              <th class="px-4 py-2">Mobile</th>
              <th class="px-4 py-2">Actions</th>
            </tr>
          </thead>

        </table>
      </div>
    </main>
  </div>

  <!-- Edit Model -->
  <!-- Edit User Modal -->
  <div id="editModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded shadow-md w-full max-w-md">
      <h2 class="text-xl font-bold mb-4">Edit User</h2>
      <form id="editUserForm">
        <input type="hidden" id="editId" name="id">

        <div class="mb-4">
          <label class="block mb-1 text-sm font-medium">Name</label>
          <input type="text" id="editName" name="name" class="w-full border border-gray-300 rounded px-3 py-2" required>
        </div>

        <div class="mb-4">
          <label class="block mb-1 text-sm font-medium">Email</label>
          <input type="email" id="editEmail" name="email" class="w-full border border-gray-300 rounded px-3 py-2"
            required>
        </div>

        <div class="mb-4">
          <label class="block mb-1 text-sm font-medium">Mobile</label>
          <input type="text" id="editMobile" name="mobile" class="w-full border border-gray-300 rounded px-3 py-2"
            required>
        </div>

        <div class="flex justify-end">
          <button type="button" id="closeModal" class="bg-gray-400 text-white px-4 py-2 rounded mr-2">Cancel</button>
          <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
        </div>
      </form>
    </div>
  </div>





  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

  <script>
  $.ajax({
    url: '../actions/fetch-users.php',
    method: 'GET',
    dataType: 'json',
    success: function(response) {
      if (response.success) {
        $('#usersTable').DataTable({
          data: response.users,
          destroy: true,
          columns: [{
              data: 'id'
            },
            {
              data: 'name'
            },
            {
              data: 'email'
            },
            {
              data: 'mobile'
            },
            {
              data: 'actions'
            }
          ]
        });
      } else {
        alert(response.message);
      }
    }
  });
  </script>

  <script>
  $(document).on('click', '.edit-btn', function() {
    const userId = $(this).data('id');
    //alert(userId);
    $.ajax({
      url: '../actions/get-user.php',
      method: 'POST',
      data: {
        id: userId
      },
      dataType: 'json',
      success: function(res) {
        if (res.success) {
          $('#editId').val(res.user.id);
          $('#editName').val(res.user.name);
          $('#editEmail').val(res.user.email);
          $('#editMobile').val(res.user.mobile);
          $('#editModal').removeClass('hidden');
        } else {
          alert('User not found');
        }
      }
    });
  });

  $('#closeModal').on('click', function() {
    $('#editModal').addClass('hidden');
  });

  $('#editUserForm').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
      url: '../actions/update-user.php',
      method: 'POST',
      data: $(this).serialize(),
      dataType: 'json',
      success: function(res) {
        if (res.success) {
          $('#editModal').addClass('hidden');
          alert('User updated successfully!');
          $('#usersTable').DataTable().ajax.reload(); // Refresh table
        } else {
          alert('Update failed!');
        }
      }
    });
  });
  </script>

</body>

</html>