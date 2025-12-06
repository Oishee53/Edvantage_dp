<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Dashboard</title>
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet" />
  <style>
    /* Custom CSS Variables */
    :root {
      --primary-color:  #0E1B33;
      --primary-light-hover-bg: #E3E6F3; 
      --body-background: #f9fafb;
      --card-background: #ffffff;
      --text-default: #333;
      --text-gray-600: #4b5563; /* Equivalent to Tailwind's gray-600 */
      --text-gray-700: #374151; /* Equivalent to Tailwind's gray-700 */
      --text-gray-500: #6b7280; /* Equivalent to Tailwind's gray-500 */
      --border-color: #e5e7eb; /* Equivalent to Tailwind's gray-200 */
    }

    body {
      font-family: 'Montserrat', sans-serif;
      background-color: var(--body-background);
      margin: 0;
      display: flex;
      min-height: 100vh;
    }

    /* Sidebar */
    .sidebar {
      width: 17.5rem; /* w-64 */
      background-color: var(--card-background);
      min-height: 100vh;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); /* shadow-md */
    }

    .sidebar-header {
      padding: 1.5rem; /* p-6 */
      display: flex;
      align-items: center;
      gap: 0.5rem; /* gap-2 */
      color: var(--primary-color);
      font-weight: 700; /* font-bold */
      font-size: 1.25rem; /* text-xl */
    }

    .sidebar-header img {
      height: 2.5rem; /* h-10 */
    }

    .sidebar-nav {
      margin-top: 2.5rem; /* mt-10 */
    }

    .sidebar-nav a {
      display: block;
      padding: 0.75rem 1.5rem; /* py-3 px-6 */
      color: var(--primary-color);
      font-weight: 500; /* font-medium */
      text-decoration: none;
      transition: background-color 0.2s ease-in-out, color 0.2s ease-in-out;
    }

    .sidebar-nav a:hover {
      background-color: var(--primary-light-hover-bg); /* Changed hover background */
      color: #0E1B33;; /* Text color on hover */
    }

    /* Main content */
    .main-content {
      flex: 1; /* flex-1 */
      padding: 2rem; /* p-8 */
    }

    /* Top bar */
    .top-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 2rem; /* mb-8 */
    }

    .top-bar-title {
      font-size: 1.5rem; /* text-2xl */
      font-weight: 400; /* font-semibold */
      color: var(--primary-color);
    }

    .user-info {
      display: flex;
      align-items: center;
      gap: 1rem; /* space-x-4 */
    }

    .user-info span {
      color: var(--primary-color);
      font-weight: 500; /* font-medium */
    }

    .logout-button {
      background-color: var(--primary-color);
      color: white;
      padding: 0.5rem 0.75rem; /* px-3 py-2 */
      border-radius: 0.25rem; /* rounded */
      border: none;
      cursor: pointer;
      transition: opacity 0.2s ease-in-out;
    }

    .logout-button:hover {
      opacity: 0.9; /* hover:bg-opacity-90 */
    }

    /* Stats cards */
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); /* grid-cols-1 md:grid-cols-4 */
      gap: 1.5rem; /* gap-6 */
      margin-bottom: 2rem; /* mb-8 */
    }

    .stat-card {
      background-color: var(--card-background);
      padding: 1.5rem; /* p-6 */
      border-radius: 0.5rem; /* rounded-lg */
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); /* shadow */
    }

    .stat-card-label {
      color: var(--text-gray-600);
    }

    .stat-card-value {
      font-size: 1.2rem; /* text-2xl */
      font-weight: 500; /* font-bold */
      color: var(--primary-color);
    }

    /* Graph */
    .chart-section {
      display: grid;
      grid-template-columns: 1fr; /* grid-cols-1 */
      gap: 1.5rem; /* gap-6 */
    }

    .chart-card {
      background-color: var(--card-background);
      padding: 1.5rem; /* p-6 */
      border-radius: 0.5rem; /* rounded-lg */
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); /* shadow */
      grid-column: span 3 / span 3; /* col-span-3 */
    }

    .chart-title {
      color: var(--primary-color);
      font-size: 1.125rem; /* text-lg */
      font-weight: 400; /* font-semibold */
      margin-bottom: 1rem; /* mb-4 */
    }

    /* Contact List */
    .contact-list-container {
      background-color: var(--card-background);
      margin-top: 2rem; /* mt-8 */
      padding: 1.5rem; /* p-6 */
      border-radius: 0.5rem; /* rounded-lg */
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); /* shadow */
    }

    .contact-list-title {
      color: var(--primary-color);
      font-size: 1.125rem; /* text-lg */
      font-weight: 600; /* font-semibold */
      margin-bottom: 1rem; /* mb-4 */
    }

    .contact-table {
      min-width: 100%; /* min-w-full */
      font-size: 0.875rem; /* text-sm */
      color: var(--text-gray-700);
      border-collapse: collapse;
    }

    .contact-table thead {
      color: var(--text-gray-500);
      border-bottom: 1px solid var(--border-color);
    }

    .contact-table th {
      padding: 0.5rem 0; /* py-2 */
      text-align: left;
    }

    .contact-table td {
      padding: 0.5rem 0; /* py-2 */
    }

    .contact-table tbody tr {
      border-bottom: 1px solid var(--border-color);
    }

    .contact-table tbody tr:last-child {
      border-bottom: none;
    }

    .contact-table .action-link {
      color: var(--primary-color);
      text-decoration: none;
      cursor: pointer;
      transition: text-decoration 0.2s ease-in-out;
    }

    .contact-table .action-link:hover {
      text-decoration: underline;
    }

    /* Responsive adjustments */
    @media (min-width: 768px) { /* md breakpoint */
      .stats-grid {
        grid-template-columns: repeat(4, 1fr); /* md:grid-cols-4 */
      }
      .chart-section {
        grid-template-columns: repeat(3, 1fr); /* md:grid-cols-3 */
      }
    }
  </style>
  <!-- Chart.js CDN -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="flex">
  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="sidebar-header">
      <img src="/image/Edvantage.png" class="h-10" alt="Edvantage Logo">
    </div>
    <nav class="sidebar-nav">
      <a href="/admin_panel">Dashboard</a>
      <a href="/admin_panel/manage_courses">Manage Course</a>
      <a href="/admin_panel/manage_user">Manage User</a>
      <a href="/pending-courses">Manage Pending Courses ({{ $pendingCoursesCount ?? 0 }})</a>
    </nav>
  </aside>
  <!-- Main content -->
  <main class="main-content">
    <!-- Top bar -->
    <div class="top-bar">
      <div class="top-bar-title">Dashboard</div>
      @auth
        <div class="user-info">
          <span class="text-primary font-medium">{{ auth()->user()->name }}</span>
          <form action="/logout" method="POST">
            @csrf
            <button class="logout-button">
              Logout
            </button>
          </form>
        </div>
      @endauth
    </div>
    <!-- Stats cards -->
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-card-label">Total Courses</div>
        <div class="stat-card-value">{{ $totalCourses ?? 6 }}</div>
      </div>
      <div class="stat-card">
        <div class="stat-card-label">Total Earn</div>
        <div class="stat-card-value">৳{{ $totalEarn ?? 3835 }}</div>
      </div>
      <div class="stat-card">
        <div class="stat-card-label">Total Students</div>
        <div class="stat-card-value">{{ $totalStudents ?? 3 }}</div>
      </div>
      <div class="stat-card">
        <div class="stat-card-label">Pending Courses</div>
        <div class="stat-card-value">{{ $pendingCoursesCount ?? 0 }}</div>
      </div>
    </div>
    <!-- Graph -->
    <div class="chart-section">
      <div class="chart-card">
        <div class="chart-title">
          Total Student Enrollments
        </div>
        <canvas id="enrollmentsChart" height="100"></canvas>
      </div>
    </div>
  </main>
<script>
  const monthlyData = @json($monthlyData); // comes from controller

  const ctx = document.getElementById('enrollmentsChart').getContext('2d');
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
               'Jul','Aug','Sep','Oct','Nov','Dec'],
      datasets: [{
        label: 'Student Enrollments',
        data: monthlyData,   // <-- dynamic data here
        backgroundColor: '#0E1B33'
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true,
          min: 0,
          max: 20,      // optional (remove if you want auto scale)
          ticks: {
            stepSize: 2 // optional
          }
        }
      }
    }
  });
</script>

</body>
</html>
