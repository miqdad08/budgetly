<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Welcome, <?= esc($username) ?>!</h2>
        <a href="<?= base_url('logout') ?>" class="btn btn-danger">Logout</a>
    </div>
</body>
</html> -->

<!DOCTYPE html>

<html lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Budgetly Dashboard Overview</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
        tailwind.config = {
          darkMode: "class",
          theme: {
            extend: {
              colors: {
                "primary": "#13ec13",
                "background-light": "#f6f8f6",
                "background-dark": "#102210",
              },
              fontFamily: {
                "display": ["Inter"]
              },
              borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
            },
          },
        }
    </script>
<style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark text-slate-800 dark:text-slate-100 font-display">
<div class="flex h-screen overflow-hidden">
<!-- Sidebar -->
<aside class="w-64 border-r border-primary/10 bg-white dark:bg-background-dark/50 hidden lg:flex flex-col">
<div class="p-6 flex items-center gap-3">
<div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center">
<span class="material-icons text-background-dark text-sm">account_balance_wallet</span>
</div>
<h1 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">Budgetly</h1>
</div>
<nav class="flex-1 px-4 space-y-1 mt-4">
<a class="flex items-center gap-3 px-4 py-3 bg-primary/10 text-primary rounded-xl font-medium" href="#">
<span class="material-icons">dashboard</span>
<span>Dashboard</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:bg-primary/5 hover:text-primary transition-all rounded-xl" href="#">
<span class="material-icons">receipt_long</span>
<span>Transactions</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:bg-primary/5 hover:text-primary transition-all rounded-xl" href="#">
<span class="material-icons">pie_chart</span>
<span>Budgets</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:bg-primary/5 hover:text-primary transition-all rounded-xl" href="#">
<span class="material-icons">insights</span>
<span>Reports</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:bg-primary/5 hover:text-primary transition-all rounded-xl" href="#">
<span class="material-icons">account_circle</span>
<span>Profile</span>
</a>
</nav>
<div class="p-4 border-t border-primary/10">
<a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:bg-primary/5 hover:text-primary transition-all rounded-xl" href="#">
<span class="material-icons">settings</span>
<span>Settings</span>
</a>
</div>
</aside>
<!-- Main Content -->
<main class="flex-1 overflow-y-auto">
<!-- Header -->
<header class="h-20 border-b border-primary/10 bg-white/50 dark:bg-background-dark/50 backdrop-blur-md flex items-center justify-between px-8 sticky top-0 z-10">
<div>
<h2 class="text-2xl font-bold text-slate-900 dark:text-white">Dashboard Overview</h2>
<p class="text-sm text-slate-500">Welcome back, welcome back to your financial freedom.</p>
</div>
<div class="flex items-center gap-4">
<button class="p-2 text-slate-500 hover:bg-primary/5 rounded-full transition-all">
<span class="material-icons">notifications</span>
</button>
<button class="flex items-center gap-2 bg-primary text-background-dark px-5 py-2.5 rounded-xl font-semibold shadow-lg shadow-primary/20 hover:scale-105 transition-transform">
<span class="material-icons text-sm">add</span>
<span>Add Transaction</span>
</button>
</div>
</header>
<div class="p-8 space-y-8">
<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
<!-- Card 1 -->
<div class="bg-white dark:bg-background-dark border border-primary/10 p-6 rounded-xl shadow-sm">
<div class="flex items-center justify-between mb-4">
<span class="text-slate-500 font-medium">Total Balance</span>
<div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center text-primary">
<span class="material-icons">account_balance</span>
</div>
</div>
<div class="space-y-1">
<h3 class="text-3xl font-bold text-slate-900 dark:text-white">$24,560.00</h3>
<div class="flex items-center gap-1 text-primary text-sm font-medium">
<span class="material-icons text-xs">trending_up</span>
<span>+2.5% this month</span>
</div>
</div>
</div>
<!-- Card 2 -->
<div class="bg-white dark:bg-background-dark border border-primary/10 p-6 rounded-xl shadow-sm">
<div class="flex items-center justify-between mb-4">
<span class="text-slate-500 font-medium">Monthly Income</span>
<div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center text-green-600">
<span class="material-icons">south_west</span>
</div>
</div>
<div class="space-y-1">
<h3 class="text-3xl font-bold text-slate-900 dark:text-white">$8,240.00</h3>
<p class="text-sm text-slate-400">Scheduled for May 25th</p>
</div>
</div>
<!-- Card 3 -->
<div class="bg-white dark:bg-background-dark border border-primary/10 p-6 rounded-xl shadow-sm">
<div class="flex items-center justify-between mb-4">
<span class="text-slate-500 font-medium">Monthly Expenses</span>
<div class="w-10 h-10 bg-orange-100 dark:bg-orange-900/30 rounded-full flex items-center justify-center text-orange-600">
<span class="material-icons">north_east</span>
</div>
</div>
<div class="space-y-1">
<h3 class="text-3xl font-bold text-slate-900 dark:text-white">$3,120.50</h3>
<div class="w-full bg-slate-100 dark:bg-slate-800 h-1.5 rounded-full mt-3 overflow-hidden">
<div class="bg-orange-500 h-full w-3/4"></div>
</div>
</div>
</div>
</div>
<!-- Main Layout Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
<!-- Chart Section -->
<div class="lg:col-span-2 bg-white dark:bg-background-dark border border-primary/10 p-8 rounded-xl shadow-sm">
<div class="flex items-center justify-between mb-8">
<h3 class="text-xl font-bold text-slate-900 dark:text-white">Spending Trends</h3>
<select class="bg-background-light dark:bg-background-dark border-primary/20 rounded-lg text-sm focus:ring-primary focus:border-primary">
<option>Last 6 Months</option>
<option>Last Year</option>
</select>
</div>
<div class="relative h-64 w-full flex items-end justify-between gap-2">
<!-- Placeholder for line chart visualization -->
<div class="absolute inset-0 flex items-center justify-center opacity-10">
<span class="material-icons text-9xl">show_chart</span>
</div>
<!-- Mock Bars for visualization style -->
<div class="flex-1 bg-primary/5 hover:bg-primary/20 transition-all rounded-t-lg h-[40%]"></div>
<div class="flex-1 bg-primary/5 hover:bg-primary/20 transition-all rounded-t-lg h-[60%]"></div>
<div class="flex-1 bg-primary/5 hover:bg-primary/20 transition-all rounded-t-lg h-[45%]"></div>
<div class="flex-1 bg-primary/5 hover:bg-primary/20 transition-all rounded-t-lg h-[80%]"></div>
<div class="flex-1 bg-primary/5 hover:bg-primary/20 transition-all rounded-t-lg h-[55%]"></div>
<div class="flex-1 bg-primary/20 border-t-2 border-primary transition-all rounded-t-lg h-[90%]"></div>
</div>
<div class="flex justify-between mt-4 text-xs font-medium text-slate-400">
<span>Jan</span><span>Feb</span><span>Mar</span><span>Apr</span><span>May</span><span>Jun</span>
</div>
</div>
<!-- Recent Transactions -->
<div class="bg-white dark:bg-background-dark border border-primary/10 p-6 rounded-xl shadow-sm overflow-hidden flex flex-col">
<div class="flex items-center justify-between mb-6">
<h3 class="text-xl font-bold text-slate-900 dark:text-white">Recent Activity</h3>
<button class="text-sm text-primary font-medium hover:underline">View All</button>
</div>
<div class="space-y-5 overflow-y-auto max-h-[400px] pr-2 custom-scrollbar">
<!-- Transaction 1 -->
<div class="flex items-center justify-between group cursor-pointer">
<div class="flex items-center gap-4">
<div class="w-12 h-12 bg-slate-100 dark:bg-slate-800 rounded-xl flex items-center justify-center group-hover:bg-primary/10 transition-colors">
<span class="material-icons text-slate-600 dark:text-slate-400">shopping_bag</span>
</div>
<div>
<p class="font-semibold text-slate-900 dark:text-white leading-none">Apple Store</p>
<p class="text-xs text-slate-500 mt-1">Electronics • May 12</p>
</div>
</div>
<span class="font-bold text-slate-900 dark:text-white">-$1,299.00</span>
</div>
<!-- Transaction 2 -->
<div class="flex items-center justify-between group cursor-pointer">
<div class="flex items-center gap-4">
<div class="w-12 h-12 bg-slate-100 dark:bg-slate-800 rounded-xl flex items-center justify-center group-hover:bg-primary/10 transition-colors">
<span class="material-icons text-slate-600 dark:text-slate-400">restaurant</span>
</div>
<div>
<p class="font-semibold text-slate-900 dark:text-white leading-none">The Green Bistro</p>
<p class="text-xs text-slate-500 mt-1">Dining • May 10</p>
</div>
</div>
<span class="font-bold text-slate-900 dark:text-white">-$42.50</span>
</div>
<!-- Transaction 3 -->
<div class="flex items-center justify-between group cursor-pointer">
<div class="flex items-center gap-4">
<div class="w-12 h-12 bg-slate-100 dark:bg-slate-800 rounded-xl flex items-center justify-center group-hover:bg-primary/10 transition-colors">
<span class="material-icons text-primary">payments</span>
</div>
<div>
<p class="font-semibold text-slate-900 dark:text-white leading-none">Salary Deposit</p>
<p class="text-xs text-slate-500 mt-1">Income • May 01</p>
</div>
</div>
<span class="font-bold text-primary">+$4,500.00</span>
</div>
<!-- Transaction 4 -->
<div class="flex items-center justify-between group cursor-pointer">
<div class="flex items-center gap-4">
<div class="w-12 h-12 bg-slate-100 dark:bg-slate-800 rounded-xl flex items-center justify-center group-hover:bg-primary/10 transition-colors">
<span class="material-icons text-slate-600 dark:text-slate-400">directions_car</span>
</div>
<div>
<p class="font-semibold text-slate-900 dark:text-white leading-none">Gas Station</p>
<p class="text-xs text-slate-500 mt-1">Transport • Apr 28</p>
</div>
</div>
<span class="font-bold text-slate-900 dark:text-white">-$65.00</span>
</div>
</div>
</div>
</div>
<!-- Footer Marketing Banner -->
<div class="relative overflow-hidden bg-background-dark text-white rounded-2xl p-10 flex flex-col md:flex-row items-center justify-between">
<div class="relative z-10 space-y-4 max-w-xl">
<h4 class="text-3xl font-bold">Plan your future with Premium</h4>
<p class="text-slate-400">Unlock advanced budgeting tools, unlimited bank connections, and AI-powered spending insights.</p>
<button class="bg-primary text-background-dark font-bold px-8 py-3 rounded-full hover:scale-105 transition-transform">Upgrade Now</button>
</div>
<div class="absolute top-0 right-0 w-1/3 h-full opacity-20 pointer-events-none">
<img alt="Finance Background" class="object-cover w-full h-full" data-alt="Abstract green financial growth data visualization" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA9u5t_Z1FBhxDfobl12y_fRy3N6KLEzbF2Vq7nDwGu5_GY6DIjFuueXlAHJ1W_Yplgj7vl1qj1QMkz3LXroO-dC3iVapeRI3j8KGZK5FOMs8WYxixMmnQhpyhvO1fRpjj_GgdWLMnqR2K4wp3anBer2CbqKSD5Qnnu5AWsv-luaJfpACPfD5KgDamo5D5Atnfj-0up2ulEwVF96KAf6GKMIPM1w62dSTuPZcdUrMzyEgWgcZSDMW5tOoYRT-BbsAO1d-0DXoul1rg"/>
</div>
</div>
</div>
</main>
</div>
<!-- Floating Action Button for Mobile -->
<button class="lg:hidden fixed bottom-6 right-6 w-14 h-14 bg-primary text-background-dark rounded-full shadow-2xl flex items-center justify-center z-50">
<span class="material-icons">add</span>
</button>
</body></html>