<header class="h-20 border-b border-primary/10 bg-white/50 dark:bg-background-dark/50 backdrop-blur-md flex items-center justify-between px-8 sticky top-0 z-10">
    <div>
        <h2 class="text-2xl font-bold text-slate-900 dark:text-white"><?= $this->renderSection('page_title') ?: 'Dashboard Overview' ?></h2>
        <p class="text-sm text-slate-500">Welcome back, <?= esc($username ?? 'User') ?>! Manage your finances.</p>
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