<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Budgetly - Add New Account</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="<?= base_url('assets/css/styles.css') ?>" rel="stylesheet">
    <script src="<?= base_url('assets/js/dashboard.js') ?>"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #13ec1333;
            border-radius: 10px;
        }

        .account-type-card:hover input+div {
            border-color: #13ec13;
            background-color: rgba(19, 236, 19, 0.05);
        }

        .account-type-card input:checked+div {
            border-color: #13ec13;
            background-color: rgba(19, 236, 19, 0.1);
            box-shadow: 0 0 0 2px rgba(19, 236, 19, 0.2);
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark text-slate-800 dark:text-slate-100 font-display">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar Partial -->
        <?= $this->include('partials/sidebar') ?>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto custom-scrollbar flex items-center justify-center p-4">
            <div
                class="w-full max-w-2xl bg-white dark:bg-background-dark border border-primary/10 rounded-2xl shadow-xl overflow-hidden">
                <div class="p-8 border-b border-primary/5">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Add New Account</h2>
                            <p class="text-sm text-slate-500">Set up a new financial account to track your money.</p>
                        </div>
                        <a href="<?= base_url('profile') ?>"
                            class="p-2 text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-900 rounded-full transition-all">
                            <span class="material-icons">close</span>
                        </a>
                    </div>
                </div>

                <form class="p-8 space-y-8" method="post" action="<?= base_url('profile/accounts/store') ?>">
                    <?= csrf_field() ?>

                    <!-- Account Type -->
                    <div class="space-y-4">
                        <label class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider">Account
                            Type</label>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <?php
                            $types = [
                                'bank' => ['icon' => 'account_balance', 'label' => 'Bank'],
                                'e-wallet' => ['icon' => 'account_balance_wallet', 'label' => 'E-wallet'],
                                'wallet' => ['icon' => 'payments', 'label' => 'Cash']
                            ];
                            foreach ($types as $value => $info):
                                ?>
                                <label class="account-type-card cursor-pointer relative">
                                    <input type="radio" name="type" value="<?= $value ?>" class="sr-only"
                                        <?= old('type') == $value ? 'checked' : ($value == 'bank' ? 'checked' : '') ?> required>
                                    <div
                                        class="flex flex-col items-center justify-center p-6 border-2 border-slate-100 dark:border-slate-800 rounded-xl transition-all">
                                        <div
                                            class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center text-blue-600 mb-3">
                                            <span class="material-icons"><?= $info['icon'] ?></span>
                                        </div>
                                        <span class="font-bold text-slate-900 dark:text-white"><?= $info['label'] ?></span>
                                    </div>
                                </label>
                            <?php endforeach; ?>
                        </div>
                        <?php if (session('errors.type')): ?>
                            <p class="text-red-500 text-xs mt-1"><?= session('errors.type') ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Account Name -->
                        <div class="space-y-2 md:col-span-2">
                            <label class="text-sm font-semibold text-slate-600 dark:text-slate-400">Account Name</label>
                            <input type="text" name="name" value="<?= old('name') ?>" required
                                class="w-full bg-slate-50 dark:bg-slate-900/50 border-primary/10 rounded-xl focus:ring-primary focus:border-primary text-slate-900 dark:text-white px-4 py-3 transition-all"
                                placeholder="e.g. My Savings Account" />
                            <?php if (session('errors.name')): ?>
                                <p class="text-red-500 text-xs mt-1"><?= session('errors.name') ?></p>
                            <?php endif; ?>
                        </div>

                        <!-- Initial Balance -->
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-slate-600 dark:text-slate-400">Initial
                                Balance</label>
                            <div class="relative">
                                <span
                                    class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-medium">Rp</span>
                                <input type="number" name="balance" value="<?= old('balance', 0) ?>" step="0.01" min="0"
                                    class="w-full bg-slate-50 dark:bg-slate-900/50 border-primary/10 rounded-xl focus:ring-primary focus:border-primary text-slate-900 dark:text-white pl-12 pr-4 py-3 transition-all"
                                    placeholder="0,00" />
                            </div>
                        </div>

                        <!-- Currency (hidden) -->
                        <div class="space-y-2 hidden">
                            <label class="text-sm font-semibold text-slate-600 dark:text-slate-400">Currency</label>
                            <select name="currency"
                                class="w-full bg-slate-50 dark:bg-slate-900/50 border-primary/10 rounded-xl focus:ring-primary focus:border-primary text-slate-900 dark:text-white px-4 py-3 transition-all">
                                <option value="IDR">IDR (Rp)</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex flex-col-reverse sm:flex-row items-center gap-4 pt-4">
                        <a href="<?= base_url('profile') ?>"
                            class="w-full sm:w-auto px-8 py-3.5 text-slate-500 font-bold hover:bg-slate-100 dark:hover:bg-slate-900 rounded-xl transition-all text-center">
                            Cancel
                        </a>
                        <button type="submit"
                            class="w-full sm:flex-1 bg-primary text-background-dark px-8 py-3.5 rounded-xl font-bold hover:opacity-90 transition-all shadow-lg shadow-primary/20 flex items-center justify-center gap-2">
                            <span>Create Account</span>
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>

</html>