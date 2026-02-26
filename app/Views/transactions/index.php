<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('title') ?>Transaction History<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Transaction History<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Stats Overview -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
        <p class="text-sm font-medium text-slate-500 dark:text-slate-400 mb-1">Total Balance</p>
        <h3 class="text-2xl font-bold">Rp <?= number_format($totalBalance, 2, ',', '.') ?></h3>
    </div>
    <div class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
        <p class="text-sm font-medium text-slate-500 dark:text-slate-400 mb-1">Monthly Income</p>
        <h3 class="text-2xl font-bold text-primary">Rp <?= number_format($monthlyIncome, 2, ',', '.') ?></h3>
    </div>
    <div class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
        <p class="text-sm font-medium text-slate-500 dark:text-slate-400 mb-1">Monthly Expenses</p>
        <h3 class="text-2xl font-bold text-slate-800 dark:text-white">Rp
            <?= number_format($monthlyExpense, 2, ',', '.') ?>
        </h3>
    </div>
</div>

<!-- Filters & Action Bar -->
<form method="get" action="<?= base_url('transactions') ?>"
    class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-6">
    <div class="flex flex-wrap items-center gap-3">
        <!-- Month Filter -->
        <div class="relative">
            <select name="month"
                class="appearance-none bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg px-4 py-2 pr-10 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all cursor-pointer">
                <?php foreach ($availableMonths as $key => $label): ?>
                    <option value="<?= $key ?>" <?= $key == $month ? 'selected' : '' ?>><?= $label ?></option>
                <?php endforeach; ?>
            </select>
            <span
                class="material-icons-round absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-lg">expand_more</span>
        </div>

        <!-- Category Filter -->
        <div class="relative">
            <select name="category"
                class="appearance-none bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg px-4 py-2 pr-10 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all cursor-pointer">
                <option value="all">All Categories</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $selectedCategory ? 'selected' : '' ?>>
                        <?= esc($cat['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <span
                class="material-icons-round absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-lg">expand_more</span>
        </div>

        <!-- Search Input -->
        <div class="relative group">
            <span
                class="material-icons-round absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg group-focus-within:text-primary transition-colors">search</span>
            <input type="text" name="search" value="<?= esc($search) ?>"
                class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg pl-10 pr-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all w-64"
                placeholder="Search notes..." />
        </div>

        <!-- Apply Filters Button -->
        <button type="submit"
            class="bg-primary/10 text-primary px-4 py-2 rounded-lg text-sm font-medium hover:bg-primary/20 transition-colors">Apply
            Filters</button>
    </div>

    <!-- Add Transaction Button -->
    <a href="<?= base_url('transactions/create') ?>"
        class="bg-primary hover:bg-primary/90 text-white font-semibold py-2 px-6 rounded-lg transition-all flex items-center gap-2 shadow-sm shadow-primary/20">
        <span class="material-icons-round">add</span>
        Add Transaction
    </a>
</form>

<!-- Transaction Table -->
<div
    class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-slate-50/50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
                <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Date</th>
                <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Description</th>
                <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Category</th>
                <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-right">Amount</th>
                <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-center">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
            <?php if (empty($transactions)): ?>
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-slate-500 dark:text-slate-400">No transactions
                        found.
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($transactions as $t): ?>
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors group">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500 dark:text-slate-400">
                            <?= date('M d, Y', strtotime($t['date'])) ?>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-8 h-8 rounded-full <?= $t['type'] == 'income' ? 'bg-primary/10' : 'bg-slate-100 dark:bg-slate-800' ?> flex items-center justify-center">
                                    <span
                                        class="material-icons-round text-sm <?= $t['type'] == 'income' ? 'text-primary' : 'text-slate-500' ?>">
                                        <?= $t['type'] == 'income' ? 'arrow_downward' : 'arrow_upward' ?>
                                    </span>
                                </div>
                                <span class="font-medium text-slate-700 dark:text-slate-200">
                                    <?= esc($t['notes'] ?: '—') ?>
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="px-2.5 py-1 rounded-full text-xs font-medium <?= $t['type'] == 'income' ? 'bg-primary/10 text-primary' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400' ?>">
                                <?= esc($t['category_name'] ?? 'Uncategorized') ?>
                            </span>
                        </td>
                        <td
                            class="px-6 py-4 whitespace-nowrap text-right font-semibold <?= $t['type'] == 'income' ? 'text-primary' : 'text-slate-600 dark:text-slate-400' ?>">
                            <?= $t['type'] == 'income' ? '+' : '-' ?> Rp <?= number_format($t['amount'], 2, ',', '.') ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <div
                                class="flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="<?= base_url('transactions/edit/' . $t['id']) ?>"
                                    class="p-1.5 text-slate-400 hover:text-primary transition-colors">
                                    <span class="material-icons-round text-lg">edit</span>
                                </a>
                                <a href="<?= base_url('transactions/delete/' . $t['id']) ?>"
                                    onclick="return confirm('Hapus transaksi ini?')"
                                    class="p-1.5 text-slate-400 hover:text-red-500 transition-colors">
                                    <span class="material-icons-round text-lg">delete_outline</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Pagination Footer -->
    <?php if ($totalRows > 0): ?>
        <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between">
            <p class="text-sm text-slate-500 dark:text-slate-400">
                Showing <?= ($currentPage - 1) * $perPage + 1 ?> to <?= min($currentPage * $perPage, $totalRows) ?> of
                <?= $totalRows ?> transactions
            </p>
            <div class="flex gap-2">
                <?php if ($pager->getPreviousPageURI()): ?>
                    <a href="<?= $pager->getPreviousPageURI() ?>"
                        class="px-3 py-1.5 border border-slate-200 dark:border-slate-800 rounded-md text-sm font-medium hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">Previous</a>
                <?php else: ?>
                    <button
                        class="px-3 py-1.5 border border-slate-200 dark:border-slate-800 rounded-md text-sm font-medium opacity-50 cursor-not-allowed"
                        disabled>Previous</button>
                <?php endif; ?>

                <?php if ($pager->getNextPageURI()): ?>
                    <a href="<?= $pager->getNextPageURI() ?>"
                        class="px-3 py-1.5 border border-slate-200 dark:border-slate-800 rounded-md text-sm font-medium hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">Next</a>
                <?php else: ?>
                    <button
                        class="px-3 py-1.5 border border-slate-200 dark:border-slate-800 rounded-md text-sm font-medium opacity-50 cursor-not-allowed"
                        disabled>Next</button>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>


<!-- Budgeting Tip Card -->
<div class="mt-8 p-4 bg-primary/5 border border-primary/10 rounded-xl flex items-start gap-3">
    <span class="material-icons-round text-primary mt-0.5">lightbulb</span>
    <div>
        <h4 class="text-sm font-bold text-slate-800 dark:text-slate-200">Budgeting Tip</h4>
        <p class="text-sm text-slate-600 dark:text-slate-400">You spent 15% more on <span
                class="font-semibold italic">Food &amp; Drink</span> this week compared to last. Consider checking
            your monthly cap.</p>
    </div>
</div>

<?= $this->endSection() ?>