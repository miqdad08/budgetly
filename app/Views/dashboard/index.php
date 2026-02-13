<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('title') ?>Dashboard Overview<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Dashboard Overview<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Total Balance -->
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

    <!-- Monthly Income -->
    <div class="bg-white dark:bg-background-dark border border-primary/10 p-6 rounded-xl shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <span class="text-slate-500 font-medium">Monthly Income</span>
            <div
                class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center text-green-600">
                <span class="material-icons">south_west</span>
            </div>
        </div>
        <div class="space-y-1">
            <h3 class="text-3xl font-bold text-slate-900 dark:text-white">$8,240.00</h3>
            <p class="text-sm text-slate-400">Scheduled for May 25th</p>
        </div>
    </div>

    <!-- Monthly Expenses -->
    <div class="bg-white dark:bg-background-dark border border-primary/10 p-6 rounded-xl shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <span class="text-slate-500 font-medium">Monthly Expenses</span>
            <div
                class="w-10 h-10 bg-orange-100 dark:bg-orange-900/30 rounded-full flex items-center justify-center text-orange-600">
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

<!-- Main Grid: Chart & Recent Transactions -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Spending Trends -->
    <div class="lg:col-span-2 bg-white dark:bg-background-dark border border-primary/10 p-8 rounded-xl shadow-sm">
        <div class="flex items-center justify-between mb-8">
            <h3 class="text-xl font-bold text-slate-900 dark:text-white">Spending Trends</h3>
            <select
                class="bg-background-light dark:bg-background-dark border-primary/20 rounded-lg text-sm focus:ring-primary focus:border-primary">
                <option>Last 6 Months</option>
                <option>Last Year</option>
            </select>
        </div>
        <div class="relative h-64 w-full flex items-end justify-between gap-2">
            <!-- Placeholder icon -->
            <div class="absolute inset-0 flex items-center justify-center opacity-10">
                <span class="material-icons text-9xl">show_chart</span>
            </div>
            <!-- Mock bars -->
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

    <!-- Recent Activity -->
    <div
        class="bg-white dark:bg-background-dark border border-primary/10 p-6 rounded-xl shadow-sm overflow-hidden flex flex-col">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold text-slate-900 dark:text-white">Recent Activity</h3>
            <button class="text-sm text-primary font-medium hover:underline">View All</button>
        </div>
        <div class="space-y-5 overflow-y-auto max-h-[400px] pr-2 custom-scrollbar">
            <!-- Transaction 1 -->
            <div class="flex items-center justify-between group cursor-pointer">
                <div class="flex items-center gap-4">
                    <div
                        class="w-12 h-12 bg-slate-100 dark:bg-slate-800 rounded-xl flex items-center justify-center group-hover:bg-primary/10 transition-colors">
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
                    <div
                        class="w-12 h-12 bg-slate-100 dark:bg-slate-800 rounded-xl flex items-center justify-center group-hover:bg-primary/10 transition-colors">
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
                    <div
                        class="w-12 h-12 bg-slate-100 dark:bg-slate-800 rounded-xl flex items-center justify-center group-hover:bg-primary/10 transition-colors">
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
                    <div
                        class="w-12 h-12 bg-slate-100 dark:bg-slate-800 rounded-xl flex items-center justify-center group-hover:bg-primary/10 transition-colors">
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
<div
    class="relative overflow-hidden bg-background-dark text-white rounded-2xl p-10 flex flex-col md:flex-row items-center justify-between">
    <div class="relative z-10 space-y-4 max-w-xl">
        <h4 class="text-3xl font-bold">Plan your future with Premium</h4>
        <p class="text-slate-400">Unlock advanced budgeting tools, unlimited bank connections, and AI-powered spending
            insights.</p>
        <button
            class="bg-primary text-background-dark font-bold px-8 py-3 rounded-full hover:scale-105 transition-transform">Upgrade
            Now</button>
    </div>
    <div class="absolute top-0 right-0 w-1/3 h-full opacity-20 pointer-events-none">
        <img alt="Finance Background" class="object-cover w-full h-full"
            data-alt="Abstract green financial growth data visualization"
            src="https://lh3.googleusercontent.com/aida-public/AB6AXuA9u5t_Z1FBhxDfobl12y_fRy3N6KLEzbF2Vq7nDwGu5_GY6DIjFuueXlAHJ1W_Yplgj7vl1qj1QMkz3LXroO-dC3iVapeRI3j8KGZK5FOMs8WYxixMmnQhpyhvO1fRpjj_GgdWLMnqR2K4wp3anBer2CbqKSD5Qnnu5AWsv-luaJfpACPfD5KgDamo5D5Atnfj-0up2ulEwVF96KAf6GKMIPM1w62dSTuPZcdUrMzyEgWgcZSDMW5tOoYRT-BbsAO1d-0DXoul1rg" />
    </div>
</div>
<?= $this->endSection() ?>