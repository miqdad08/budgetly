<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Budgetly - Edit Category</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
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
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark text-slate-800 dark:text-slate-100 font-display">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar (salin dari partial atau sesuaikan) -->
        <?= $this->include('partials/sidebar') ?>


        <main class="flex-1 overflow-y-auto custom-scrollbar flex items-center justify-center p-4">
            <div
                class="w-full max-w-xl bg-white dark:bg-background-dark border border-primary/10 rounded-2xl shadow-xl overflow-hidden">
                <div class="p-8 border-b border-primary/5">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Edit Category</h2>
                            <p class="text-sm text-slate-500">Update your category details.</p>
                        </div>
                        <a href="<?= base_url('profile') ?>"
                            class="p-2 text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-900 rounded-full transition-all">
                            <span class="material-icons">close</span>
                        </a>
                    </div>
                </div>

                <form method="post" action="<?= base_url('profile/categories/update/' . $category['id']) ?>"
                    class="p-8 space-y-8">
                    <?= csrf_field() ?>

                    <!-- Toggle Expense/Income -->
                    <div class="flex justify-center">
                        <div class="inline-flex p-1 bg-slate-100 dark:bg-slate-900 rounded-xl w-full max-w-sm">
                            <div class="flex-1">
                                <input type="radio" name="type" id="type-expense" value="expense"
                                    class="sr-only peer"
                                    <?= old('type', $category['type']) == 'expense' ? 'checked' : '' ?>>
                                <label for="type-expense"
                                    class="flex items-center justify-center py-2 px-4 rounded-lg cursor-pointer text-sm font-semibold text-slate-500 transition-all peer-checked:bg-white peer-checked:dark:bg-slate-800 peer-checked:text-slate-900 peer-checked:dark:text-white peer-checked:shadow-sm">Expense</label>
                            </div>
                            <div class="flex-1">
                                <input type="radio" name="type" id="type-income" value="income"
                                    class="sr-only peer"
                                    <?= old('type', $category['type']) == 'income' ? 'checked' : '' ?>>
                                <label for="type-income"
                                    class="flex items-center justify-center py-2 px-4 rounded-lg cursor-pointer text-sm font-semibold text-slate-500 transition-all peer-checked:bg-white peer-checked:dark:bg-slate-800 peer-checked:text-slate-900 peer-checked:dark:text-white peer-checked:shadow-sm">Income</label>
                            </div>
                        </div>
                    </div>
                    <?php if (session('errors.type')): ?>
                    <p class="text-red-500 text-xs text-center"><?= session('errors.type') ?></p>
                    <?php endif; ?>

                    <!-- Category Name -->
                    <div class="space-y-2">
                        <label
                            class="text-sm font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider">Category
                            Name</label>
                        <input type="text" name="name" value="<?= old('name', $category['name']) ?>" required
                            class="w-full bg-slate-50 dark:bg-slate-900/50 border-primary/10 rounded-xl focus:ring-primary focus:border-primary text-slate-900 dark:text-white px-4 py-3 transition-all"
                            placeholder="e.g. Groceries, Entertainment..." />
                        <?php if (session('errors.name')): ?>
                        <p class="text-red-500 text-xs mt-1"><?= session('errors.name') ?></p>
                        <?php endif; ?>
                    </div>

                    <!-- Icon Selection -->
                    <div class="space-y-3">
                        <label
                            class="text-sm font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider">Select
                            Icon</label>
                        <div class="grid grid-cols-5 sm:grid-cols-8 gap-3">
                            <?php $icons = ['shopping_cart', 'restaurant', 'commute', 'home', 'movie', 'fitness_center', 'medical_services', 'school', 'pets', 'payments']; ?>
                            <?php foreach ($icons as $icon): ?>
                            <label class="icon-option cursor-pointer relative">
                                <input type="radio" name="icon" value="<?= $icon ?>" class="sr-only peer"
                                    <?= old('icon', $category['icon']) == $icon ? 'checked' : '' ?> required>
                                <div
                                    class="w-10 h-10 flex items-center justify-center border-2 border-slate-100 dark:border-slate-800 rounded-xl hover:border-primary/50 transition-all peer-checked:border-primary peer-checked:bg-primary/10 peer-checked:text-primary">
                                    <span class="material-icons text-xl"><?= $icon ?></span>
                                </div>
                            </label>
                            <?php endforeach; ?>
                        </div>
                        <?php if (session('errors.icon')): ?>
                        <p class="text-red-500 text-xs mt-1"><?= session('errors.icon') ?></p>
                        <?php endif; ?>
                    </div>

                    <!-- Color Selection -->
                    <div class="space-y-3">
                        <label
                            class="text-sm font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider">Category
                            Color</label>
                        <div class="flex flex-wrap gap-4">
                            <?php $colors = ['emerald', 'blue', 'purple', 'pink', 'rose', 'orange', 'amber', 'indigo']; ?>
                            <?php foreach ($colors as $color): ?>
                            <label class="color-option cursor-pointer relative">
                                <input type="radio" name="color" value="<?= $color ?>" class="sr-only peer"
                                    <?= old('color', $category['color'] ?? '') == $color ? 'checked' : '' ?>>
                                <div
                                    class="w-8 h-8 rounded-full bg-<?= $color ?>-500 transition-transform hover:scale-110 peer-checked:ring-2 peer-checked:ring-offset-2 peer-checked:ring-slate-400 dark:peer-checked:ring-slate-500">
                                </div>
                            </label>
                            <?php endforeach; ?>
                        </div>
                        <?php if (session('errors.color')): ?>
                        <p class="text-red-500 text-xs mt-1"><?= session('errors.color') ?></p>
                        <?php endif; ?>
                    </div>

                    <!-- Actions -->
                    <div class="flex flex-col-reverse sm:flex-row items-center gap-4 pt-4">
                        <a href="<?= base_url('profile') ?>"
                            class="w-full sm:w-auto px-8 py-3.5 text-slate-500 font-bold hover:bg-slate-100 dark:hover:bg-slate-900 rounded-xl transition-all text-center">Cancel</a>
                        <button type="submit"
                            class="w-full sm:flex-1 bg-primary text-background-dark px-8 py-3.5 rounded-xl font-bold hover:opacity-90 transition-all shadow-lg shadow-primary/20 flex items-center justify-center gap-2">
                            <span>Update Category</span>
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>

</html>
