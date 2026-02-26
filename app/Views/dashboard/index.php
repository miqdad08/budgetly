<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('title') ?>Dashboard Overview<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Dashboard Overview<?= $this->endSection() ?>
<?= $this->section('page_subtitle') ?>Welcome back, <?= esc($username) ?>! Manage your finances.<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="space-y-8">
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
                <h3 class="text-3xl font-bold text-slate-900 dark:text-white">Rp
                    <?= number_format($totalBalance, 2, ',', '.') ?>
                </h3>
                <!-- Optional: perbandingan bulan lalu bisa ditambahkan nanti -->
                <!-- <div class="flex items-center gap-1 text-primary text-sm font-medium">
                    <span class="material-icons text-xs">trending_up</span>
                    <span>+2.5% this month</span>
                </div> -->
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
                <h3 class="text-3xl font-bold text-slate-900 dark:text-white">Rp
                    <?= number_format($monthlyIncome, 2, ',', '.') ?>
                </h3>
                <!-- Optional: info tambahan -->
                <!-- <p class="text-sm text-slate-400">Scheduled for May 25th</p> -->
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
                <h3 class="text-3xl font-bold text-slate-900 dark:text-white">Rp
                    <?= number_format($monthlyExpense, 2, ',', '.') ?>
                </h3>
                <!-- Progress bar sederhana (opsional) -->
                <?php if ($monthlyIncome > 0): ?>
                    <div class="w-full bg-slate-100 dark:bg-slate-800 h-1.5 rounded-full mt-3 overflow-hidden">
                        <div class="bg-orange-500 h-full"
                            style="width: <?= min(100, round(($monthlyExpense / $monthlyIncome) * 100)) ?>%"></div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Main Grid: Chart & Recent Transactions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Spending Trends -->
        <!-- Spending Trends -->
        <div class="lg:col-span-2 bg-white dark:bg-background-dark border border-primary/10 p-8 rounded-xl shadow-sm">
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-xl font-bold text-slate-900 dark:text-white">Spending Trends</h3>
                <form method="get" action="" class="flex items-center gap-2">
                    <select name="period" onchange="this.form.submit()"
                        class="bg-background-light dark:bg-background-dark border-primary/20 rounded-lg text-sm focus:ring-primary focus:border-primary">
                        <option value="6" <?= $period == '6' ? 'selected' : '' ?>>Last 6 Months</option>
                        <option value="12" <?= $period == '12' ? 'selected' : '' ?>>Last Year</option>
                    </select>
                </form>
            </div>

            <?php if (!empty($spendingTrends['data']) && array_sum($spendingTrends['data']) > 0): ?>
                <div class="relative h-64 w-full flex items-end justify-between gap-2">
                    <?php
                    $maxValue = max($spendingTrends['data']) ?: 1;
                    foreach ($spendingTrends['data'] as $value):
                        $height = ($value / $maxValue) * 100;
                        ?>
                        <div class="flex-1 bg-primary/20 hover:bg-primary/30 transition-all rounded-t-lg"
                            style="height: <?= $height ?>%"></div>
                    <?php endforeach; ?>
                </div>
                <div class="flex justify-between mt-4 text-xs font-medium text-slate-400">
                    <?php foreach ($spendingTrends['labels'] as $label): ?>
                        <span><?= $label ?></span>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="relative h-64 w-full flex items-center justify-center">
                    <span class="text-slate-400">No expense data for the selected period.</span>
                </div>
            <?php endif; ?>
        </div>

        <!-- Recent Activity -->
        <div
            class="bg-white dark:bg-background-dark border border-primary/10 p-6 rounded-xl shadow-sm overflow-hidden flex flex-col">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-slate-900 dark:text-white">Recent Activity</h3>
                <a href="<?= base_url('transactions') ?>" class="text-sm text-primary font-medium hover:underline">View
                    All</a>
            </div>

            <?php if (empty($recentTransactions)): ?>
                <div class="text-center py-8 text-slate-400">No recent transactions.</div>
            <?php else: ?>
                <div class="space-y-5 overflow-y-auto max-h-[400px] pr-2 custom-scrollbar">
                    <?php foreach ($recentTransactions as $t): ?>
                        <div class="flex items-center justify-between group cursor-pointer">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-12 h-12 <?= $t['type'] == 'income' ? 'bg-primary/10' : 'bg-slate-100 dark:bg-slate-800' ?> rounded-xl flex items-center justify-center group-hover:bg-primary/10 transition-colors">
                                    <span
                                        class="material-icons <?= $t['type'] == 'income' ? 'text-primary' : 'text-slate-600 dark:text-slate-400' ?>">
                                        <?= $t['type'] == 'income' ? 'arrow_downward' : 'arrow_upward' ?>
                                    </span>
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-900 dark:text-white leading-none">
                                        <?= esc($t['notes'] ?: 'No description') ?>
                                    </p>
                                    <p class="text-xs text-slate-500 mt-1"><?= esc($t['category_name'] ?? 'Uncategorized') ?> •
                                        <?= date('M d', strtotime($t['date'])) ?>
                                    </p>
                                </div>
                            </div>
                            <span
                                class="font-bold <?= $t['type'] == 'income' ? 'text-primary' : 'text-slate-900 dark:text-white' ?>">
                                <?= $t['type'] == 'income' ? '+' : '-' ?> Rp <?= number_format($t['amount'], 2, ',', '.') ?>
                            </span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Footer Marketing Banner -->
    <div
        class="relative overflow-hidden bg-background-dark text-white rounded-2xl p-10 flex flex-col md:flex-row items-center justify-between">
        <div class="relative z-10 space-y-4 max-w-xl">
            <h4 class="text-3xl font-bold">Plan your future with Premium</h4>
            <p class="text-slate-400">Unlock advanced budgeting tools, unlimited bank connections, and AI-powered
                spending insights.</p>
            <button
                class="bg-primary text-background-dark font-bold px-8 py-3 rounded-full hover:scale-105 transition-transform">Upgrade
                Now</button>
        </div>
        <div class="absolute top-0 right-0 w-1/3 h-full opacity-20 pointer-events-none">
            <img alt="Finance Background" class="object-cover w-full h-full"
                src="https://lh3.googleusercontent.com/aida-public/AB6AXuA9u5t_Z1FBhxDfobl12y_fRy3N6KLEzbF2Vq7nDwGu5_GY6DIjFuueXlAHJ1W_Yplgj7vl1qj1QMkz3LXroO-dC3iVapeRI3j8KGZK5FOMs8WYxixMmnQhpyhvO1fRpjj_GgdWLMnqR2K4wp3anBer2CbqKSD5Qnnu5AWsv-luaJfpACPfD5KgDamo5D5Atnfj-0up2ulEwVF96KAf6GKMIPM1w62dSTuPZcdUrMzyEgWgcZSDMW5tOoYRT-BbsAO1d-0DXoul1rg" />
        </div>
    </div>
</div>
<?= $this->endSection() ?>