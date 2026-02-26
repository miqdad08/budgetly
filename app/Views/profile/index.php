<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('title') ?>Budgetly - Profile & Account Management<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Profile & Account Management<?= $this->endSection() ?>
<?= $this->section('page_subtitle') ?>Manage your financial accounts and profile preferences.<?= $this->endSection() ?>
<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<div class=" space-y-8 max-w-7xl mx-auto">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-8">
            <!-- Personal Information -->
            <div class="bg-white dark:bg-background-dark border border-primary/10 p-8 rounded-xl shadow-sm">
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-6 flex items-center gap-2">
                    <span class="material-icons text-primary">manage_accounts</span>
                    Personal Information
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-600 dark:text-slate-400">Full Name</label>
                        <input
                            class="w-full bg-slate-50 dark:bg-slate-900/50 border-primary/10 rounded-xl focus:ring-primary focus:border-primary text-slate-900 dark:text-white px-4 py-2.5"
                            type="text" value="<?= esc($user['name']) ?>" />
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-600 dark:text-slate-400">Email Address</label>
                        <input
                            class="w-full bg-slate-50 dark:bg-slate-900/50 border-primary/10 rounded-xl focus:ring-primary focus:border-primary text-slate-900 dark:text-white px-4 py-2.5"
                            type="email" value="<?= esc($user['email']) ?>" />
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-600 dark:text-slate-400">Currency</label>
                        <select
                            class="w-full bg-slate-50 dark:bg-slate-900/50 border-primary/10 rounded-xl focus:ring-primary focus:border-primary text-slate-900 dark:text-white px-4 py-2.5">
                            <option>IDR (Rp) - Indonesian Rupiah</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-600 dark:text-slate-400">Timezone</label>
                        <select
                            class="w-full bg-slate-50 dark:bg-slate-900/50 border-primary/10 rounded-xl focus:ring-primary focus:border-primary text-slate-900 dark:text-white px-4 py-2.5">
                            <option>(GMT+07:00) Western Indonesia Time (WIB)</option>
                            <option>(GMT+08:00) Central Indonesia Time (WITA)</option>
                            <option>(GMT+09:00) Eastern Indonesia Time (WIT)
                            </option>
                        </select>
                    </div>
                </div>
                <div class="mt-8 pt-6 border-t border-primary/10 flex justify-end">
                    <button
                        class="bg-primary text-background-dark px-6 py-2.5 rounded-xl font-bold hover:opacity-90 transition-all">Save
                        Changes</button>
                </div>
            </div>

            <!-- Accounts Management -->
            <div class="bg-white dark:bg-background-dark border border-primary/10 p-8 rounded-xl shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white flex items-center gap-2">
                        <span class="material-icons text-primary">account_balance</span>
                        Accounts Management
                    </h3>
                    <a href="<?= base_url('profile/accounts/create') ?>"
                        class="flex items-center gap-2 text-primary font-bold text-sm bg-primary/10 px-4 py-2 rounded-lg hover:bg-primary/20 transition-all">
                        <span class="material-icons text-sm">add</span> Add Account
                    </a>
                </div>

                <?php if (empty($accounts)): ?>
                    <p class="text-center text-slate-500 py-8">Belum ada akun. Tambahkan akun pertama Anda.</p>
                <?php else: ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                        <?php foreach ($accounts as $acc): ?>
                            <?php
                            // Tentukan warna background berdasarkan tipe
                            $bgColor = match ($acc['type']) {
                                'bank' => 'bg-blue-100 dark:bg-blue-900/30 text-blue-600',
                                'e-wallet' => 'bg-purple-100 dark:bg-purple-900/30 text-purple-600',
                                'wallet' => 'bg-green-100 dark:bg-green-900/30 text-green-600',
                                default => 'bg-slate-100 dark:bg-slate-800 text-slate-600',
                            };
                            $icon = match ($acc['type']) {
                                'bank' => 'account_balance',
                                'e-wallet' => 'account_balance_wallet',
                                'wallet' => 'payments',
                                default => 'account_balance',
                            };
                            ?>
                            <div
                                class="p-4 bg-slate-50 dark:bg-slate-900/50 rounded-xl border border-primary/5 hover:border-primary/20 transition-all group">
                                <div class="flex items-start justify-between mb-3">
                                    <div class="w-10 h-10 <?= $bgColor ?> rounded-lg flex items-center justify-center">
                                        <span class="material-icons"><?= $icon ?></span>
                                    </div>
                                    <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <a href="<?= base_url('profile/accounts/edit/' . $acc['id']) ?>"
                                            class="p-1 hover:text-primary transition-colors">
                                            <span class="material-icons text-xs">edit</span>
                                        </a>
                                        <a href="<?= base_url('profile/accounts/delete/' . $acc['id']) ?>"
                                            onclick="return confirm('Hapus akun ini? Semua transaksi terkait akan ikut terhapus?')"
                                            class="p-1 hover:text-red-500 transition-colors">
                                            <span class="material-icons text-xs">delete</span>
                                        </a>
                                    </div>
                                </div>
                                <h4 class="font-bold text-slate-900 dark:text-white"><?= esc($acc['name']) ?></h4>
                                <p class="text-xs text-slate-500 mb-2 tracking-wide"><?= ucfirst($acc['type']) ?></p>
                                <p class="text-lg font-bold text-slate-900 dark:text-white">
                                    Rp <?= number_format($acc['balance'], 2, ',', '.') ?>
                                </p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Categories Management -->
            <div class="bg-white dark:bg-background-dark border border-primary/10 p-8 rounded-xl shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white flex items-center gap-2">
                        <span class="material-icons text-primary">category</span>
                        Categories Management
                    </h3>
                    <a href="<?= base_url('profile/categories/create') ?>"
                        class="flex items-center gap-2 text-primary font-bold text-sm bg-primary/10 px-4 py-2 rounded-lg hover:bg-primary/20 transition-all">
                        <span class="material-icons text-sm">add</span> Add New
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Expense Categories -->
                    <div class="space-y-4">
                        <h4 class="text-sm font-bold text-slate-400 uppercase tracking-wider">Expense Categories</h4>
                        <div class="space-y-2">
                            <?php if (empty($expenseCategories)): ?>
                                <p class="text-slate-400 text-sm">No expense categories yet.</p>
                            <?php else: ?>
                                <?php foreach ($expenseCategories as $cat): ?>
                                    <div
                                        class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-900/50 rounded-xl border border-primary/5 group">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-8 h-8 <?= isset($cat['color']) ? 'bg-' . $cat['color'] . '-500/30' : 'bg-orange-100/50 dark:bg-orange-900/30' ?> rounded-lg flex items-center justify-center text-<?= $cat['color'] ?? 'orange' ?>-600">
                                                <span class="material-icons text-sm"><?= $cat['icon'] ?? 'category' ?></span>
                                            </div>
                                            <span
                                                class="font-medium text-slate-700 dark:text-slate-200"><?= esc($cat['name']) ?></span>
                                        </div>
                                        <div
                                            class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <a href="<?= base_url('profile/categories/edit/' . $cat['id']) ?>"
                                                class="p-1.5 hover:bg-primary/10 rounded-md text-slate-400 hover:text-primary">
                                                <span class="material-icons text-sm">edit</span>
                                            </a>
                                            <form method="post"
                                                action="<?= base_url('profile/categories/delete/' . $cat['id']) ?>"
                                                style="display:inline;" onsubmit="return confirm('Hapus kategori ini?')">
                                                <?= csrf_field() ?>
                                                <button type="submit"
                                                    class="p-1.5 hover:bg-red-500/10 rounded-md text-slate-400 hover:text-red-500">
                                                    <span class="material-icons text-sm">delete</span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Income Categories -->
                    <div class="space-y-4">
                        <h4 class="text-sm font-bold text-slate-400 uppercase tracking-wider">Income Categories</h4>
                        <div class="space-y-2">
                            <?php if (empty($incomeCategories)): ?>
                                <p class="text-slate-400 text-sm">No income categories yet.</p>
                            <?php else: ?>
                                <?php foreach ($incomeCategories as $cat): ?>
                                    <div
                                        class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-900/50 rounded-xl border border-primary/5 group">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-8 h-8 <?= isset($cat['color']) ? 'bg-' . $cat['color'] . '-500/30' : 'bg-orange-100/50 dark:bg-orange-900/30' ?> rounded-lg flex items-center justify-center text-<?= $cat['color'] ?? 'orange' ?>-600">
                                                <span class="material-icons text-sm"><?= $cat['icon'] ?? 'category' ?></span>
                                            </div>
                                            <span
                                                class="font-medium text-slate-700 dark:text-slate-200"><?= esc($cat['name']) ?></span>
                                        </div>
                                        <div
                                            class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <a href="<?= base_url('profile/categories/edit/' . $cat['id']) ?>"
                                                class="p-1.5 hover:bg-primary/10 rounded-md text-slate-400 hover:text-primary">
                                                <span class="material-icons text-sm">edit</span>
                                            </a>
                                            <form method="post"
                                                action="<?= base_url('profile/categories/delete/' . $cat['id']) ?>"
                                                style="display:inline;" onsubmit="return confirm('Hapus kategori ini?')">
                                                <?= csrf_field() ?>
                                                <button type="submit"
                                                    class="p-1.5 hover:bg-red-500/10 rounded-md text-slate-400 hover:text-red-500">
                                                    <span class="material-icons text-sm">delete</span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right column -->
        <div class="space-y-8">
            <!-- Data Export -->
            <div class="bg-white dark:bg-background-dark border border-primary/10 p-8 rounded-xl shadow-sm">
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-6 flex items-center gap-2">
                    <span class="material-icons text-primary">ios_share</span>
                    Data Export
                </h3>
                <div class="space-y-6">
                    <p class="text-sm text-slate-500">Download your transaction history and financial reports
                        for external analysis.</p>
                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-3">
                            <div class="space-y-1.5">
                                <label
                                    class="text-[10px] font-bold uppercase text-slate-400 tracking-wider">Month</label>
                                <select
                                    class="w-full bg-slate-50 dark:bg-slate-900/50 border-primary/10 rounded-lg text-sm focus:ring-primary focus:border-primary py-2 px-3">
                                    <option>May</option>
                                    <option>April</option>
                                    <option>March</option>
                                </select>
                            </div>
                            <div class="space-y-1.5">
                                <label
                                    class="text-[10px] font-bold uppercase text-slate-400 tracking-wider">Year</label>
                                <select
                                    class="w-full bg-slate-50 dark:bg-slate-900/50 border-primary/10 rounded-lg text-sm focus:ring-primary focus:border-primary py-2 px-3">
                                    <option>2024</option>
                                    <option>2023</option>
                                </select>
                            </div>
                        </div>
                        <button
                            class="w-full bg-primary text-background-dark font-bold py-3 px-4 rounded-xl flex items-center justify-center gap-2 hover:scale-[1.02] transition-transform shadow-lg shadow-primary/20">
                            <span class="material-symbols-outlined text-xl">table_view</span>
                            <span>Export Monthly Report to Excel</span>
                        </button>
                        <button
                            class="w-full bg-slate-100 dark:bg-slate-900 text-slate-600 dark:text-slate-400 font-bold py-3 px-4 rounded-xl flex items-center justify-center gap-2 hover:bg-slate-200 dark:hover:bg-slate-800 transition-colors">
                            <span class="material-symbols-outlined text-xl">picture_as_pdf</span>
                            <span>Download PDF</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Security -->
            <div class="bg-white dark:bg-background-dark border border-primary/10 p-8 rounded-xl shadow-sm">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Security</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Two-Factor
                            Auth</span>
                        <div class="w-10 h-5 bg-primary/20 rounded-full relative cursor-pointer">
                            <div class="absolute right-0.5 top-0.5 w-4 h-4 bg-primary rounded-full"></div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Email
                            Updates</span>
                        <div class="w-10 h-5 bg-slate-200 dark:bg-slate-800 rounded-full relative cursor-pointer">
                            <div class="absolute left-0.5 top-0.5 w-4 h-4 bg-slate-400 rounded-full"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="bg-red-500/5 border border-red-500/20 p-8 rounded-xl">
                <div class="space-y-4">
                    <div>
                        <h4 class="text-xl font-bold text-red-600 mb-1">Danger Zone</h4>
                        <p class="text-sm text-red-600/70">Once you delete your account, there is no going
                            back.</p>
                    </div>
                    <button
                        class="w-full bg-red-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-red-700 transition-colors">Delete
                        Account</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>