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
        <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:bg-primary/5 hover:text-primary transition-all rounded-xl" href="<?= base_url('logout') ?>">
            <span class="material-icons">logout</span>
            <span>Logout</span>
        </a>
    </div>
</aside>