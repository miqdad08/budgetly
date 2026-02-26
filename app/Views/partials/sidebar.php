<aside class="w-64 border-r border-primary/10 bg-white dark:bg-background-dark/50 hidden lg:flex flex-col">
    <div class="p-6 flex items-center gap-3">
        <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center">
            <span class="material-icons text-background-dark text-sm">account_balance_wallet</span>
        </div>
        <h1 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">Budgetly</h1>
    </div>
    <nav class="flex-1 px-4 space-y-1 mt-4">
        <?php
        // Definisikan menu
        $menuItems = [
            'dashboard' => ['url' => 'dashboard', 'icon' => 'dashboard', 'label' => 'Dashboard'],
            'transactions' => ['url' => 'transactions', 'icon' => 'receipt_long', 'label' => 'Transactions'],
            'budgets' => ['url' => 'budgets', 'icon' => 'pie_chart', 'label' => 'Budgets'],
            'reports' => ['url' => 'reports', 'icon' => 'insights', 'label' => 'Reports'],
            'profile' => ['url' => 'profile', 'icon' => 'account_circle', 'label' => 'Profile'],
        ];

        // Ambil menu aktif dari data yang dikirim controller, default 'dashboard'
        $activeMenu = $activeMenu ?? 'dashboard';

        foreach ($menuItems as $key => $item):
            // Tentukan class aktif jika key sama dengan activeMenu
            $isActive = ($key === $activeMenu);
            $linkClass = $isActive
                ? 'bg-primary/10 text-primary'
                : 'text-slate-500 hover:bg-primary/5 hover:text-primary';
            ?>
                <a class="flex items-center gap-3 px-4 py-3 <?= $linkClass ?> transition-all rounded-xl"
                    href="<?= site_url($item['url']) ?>">
                    <span class="material-icons"><?= $item['icon'] ?></span>
                    <span><?= $item['label'] ?></span>
                </a>
        <?php endforeach; ?>
    </nav>
    <div class="p-4 border-t border-primary/10">
        <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:bg-primary/5 hover:text-primary transition-all rounded-xl"
            href="<?= site_url('logout') ?>">
            <span class="material-icons">logout</span>
            <span>Logout</span>
        </a>
    </div>
</aside>