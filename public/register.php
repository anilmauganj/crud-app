<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Register</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">
  <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
    <h2 class="text-2xl font-bold mb-6 text-center">User Registration</h2>

    <div id="message" class="mb-4 text-center text-sm"></div>

    <form id="registerForm">
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Name</label>
        <input type="text" name="name" required
          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded shadow-sm">
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Mobile</label>
        <input type="text" name="mobile" required
          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded shadow-sm">
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" name="email" required
          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded shadow-sm">
      </div>

      <div class="mb-6">
        <label class="block text-sm font-medium text-gray-700">Password</label>
        <input type="password" name="password" required
          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded shadow-sm">
      </div>

      <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Register</button>
    </form>
  </div>

  <script>
  document.getElementById('registerForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);

    fetch('../actions/register.php', {
        method: 'POST',
        body: formData
      })
      .then(res => res.json())
      .then(data => {
        const msgDiv = document.getElementById('message');
        msgDiv.textContent = data.message;
        msgDiv.className = 'mb-4 text-center text-sm ' + (data.success ? 'text-green-600' : 'text-red-600');
        if (data.success) form.reset();
      })
      .catch(error => {
        console.error('Error:', error);
      });
  });
  </script>
</body>

</html>