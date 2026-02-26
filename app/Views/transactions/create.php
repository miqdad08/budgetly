<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Budgetly - Add New Transaction</title>
    <!-- Tailwind & Fonts -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?= base_url('assets/css/styles.css') ?>" rel="stylesheet">
    <!-- Tailwind Config -->
    <script src="<?= base_url('assets/js/dashboard.js') ?>"></script>
</head>

<body class="font-display bg-background-light dark:bg-background-dark min-h-screen flex flex-col">
    <!-- Navigation Header -->
    <nav class="border-b border-primary/10 bg-white/50 dark:bg-black/20 backdrop-blur-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center">
                        <span class="material-icons text-white text-xl">account_balance_wallet</span>
                    </div>
                    <span class="text-xl font-bold tracking-tight text-background-dark dark:text-white">Budgetly</span>
                </div>
                <div class="flex items-center gap-4">
                    <button
                        class="p-2 rounded-full hover:bg-primary/10 text-background-dark/60 dark:text-white/60 transition-colors">
                        <span class="material-icons">notifications_none</span>
                    </button>
                    <div class="h-8 w-8 rounded-full bg-primary/20 border border-primary/30 overflow-hidden">
                        <img class="w-full h-full object-cover" alt="User avatar"
                            src="https://lh3.googleusercontent.com/..." />
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow flex items-center justify-center p-4">
        <div
            class="w-full max-w-lg bg-white dark:bg-zinc-900 rounded-xl shadow-2xl shadow-primary/5 overflow-hidden border border-primary/5">
            <!-- Header Section -->
            <div class="px-8 pt-8 pb-4 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-background-dark dark:text-white">Add Transaction</h1>
                <a href="<?= base_url('transactions') ?>"
                    class="text-background-dark/40 hover:text-background-dark dark:text-white/40 dark:hover:text-white transition-colors">
                    <span class="material-icons">close</span>
                </a>
            </div>

            <!-- Transaction Form -->
            <form method="post" action="<?= base_url('transactions/store') ?>" class="p-8">
                <?= csrf_field() ?>

                <!-- Toggle Switch (Expense/Income) -->
                <div class="flex p-1 bg-background-light dark:bg-zinc-800 rounded-lg mb-8">
                    <label class="flex-1 cursor-pointer">
                        <input type="radio" name="type" value="expense" class="hidden peer"
                            <?= old('type') == 'expense' ? 'checked' : 'checked' ?>>
                        <div
                            class="flex items-center justify-center gap-2 py-2.5 rounded-md text-sm font-semibold transition-all peer-checked:bg-white peer-checked:dark:bg-zinc-700 peer-checked:shadow-sm peer-checked:text-background-dark peer-checked:dark:text-white text-background-dark/50 dark:text-white/50">
                            <span class="material-icons text-sm">remove_circle_outline</span>
                            Expense
                        </div>
                    </label>
                    <label class="flex-1 cursor-pointer">
                        <input type="radio" name="type" value="income" class="hidden peer"
                            <?= old('type') == 'income' ? 'checked' : '' ?>>
                        <div
                            class="flex items-center justify-center gap-2 py-2.5 rounded-md text-sm font-semibold transition-all peer-checked:bg-white peer-checked:dark:bg-zinc-700 peer-checked:shadow-sm peer-checked:text-background-dark peer-checked:dark:text-white text-background-dark/50 dark:text-white/50">
                            <span class="material-icons text-sm">add_circle_outline</span>
                            Income
                        </div>
                    </label>
                </div>

                <!-- Amount Input -->
                <div class="text-center mb-10">
                    <label
                        class="block text-xs font-medium text-background-dark/40 dark:text-white/40 uppercase tracking-widest mb-2">
                        Transaction Amount
                    </label>
                    <div class="relative flex items-center justify-center w-full">
                        <input type="text" name="amount_display" id="amountDisplay"
                            class="w-full min-w-0 font-bold bg-transparent border-none text-center focus:ring-0 p-0 text-background-dark dark:text-white placeholder:text-background-dark/10 dark:placeholder:text-white/10"
                            placeholder="Rp 0,00"
                            value="<?= old('amount') ? number_format(old('amount'), 2, ',', '.') : '' ?>"
                            inputmode="numeric" />
                    </div>
                    <div class="mt-4 flex justify-center">
                        <div class="h-1 w-16 bg-primary rounded-full"></div>
                    </div>
                </div>

                <!-- Form Fields -->
                <div class="space-y-6">
                    <!-- Category -->
                    <div>
                        <label
                            class="block text-sm font-medium text-background-dark/60 dark:text-white/60 mb-2">Category</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="material-icons text-primary text-xl">category</span>
                            </div>
                            <select name="category_id" id="categorySelect" required
                                class="block w-full pl-11 pr-10 py-3 bg-background-light dark:bg-zinc-800 border-none rounded-lg text-background-dark dark:text-white focus:ring-2 focus:ring-primary/50 appearance-none cursor-pointer">
                                <option value="">Select Category</option>
                                <!-- Options will be populated by JavaScript -->
                            </select>
                            <div
                                class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none text-background-dark/30">
                                <span class="material-icons">expand_more</span>
                            </div>
                        </div>
                        <?php if (session('errors.category_id')): ?>
                        <p class="text-red-500 text-xs mt-1"><?= session('errors.category_id') ?></p>
                        <?php endif; ?>
                    </div>

                    <!-- Date & Account -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label
                                class="block text-sm font-medium text-background-dark/60 dark:text-white/60 mb-2">Date</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="material-icons text-primary text-xl">event</span>
                                </div>
                                <input type="date" name="date" required
                                    class="block w-full pl-11 py-3 bg-background-light dark:bg-zinc-800 border-none rounded-lg text-background-dark dark:text-white focus:ring-2 focus:ring-primary/50"
                                    value="<?= old('date', date('Y-m-d')) ?>" />
                            </div>
                            <?php if (session('errors.date')): ?>
                            <p class="text-red-500 text-xs mt-1"><?= session('errors.date') ?></p>
                            <?php endif; ?>
                        </div>
                        <div>
                            <label
                                class="block text-sm font-medium text-background-dark/60 dark:text-white/60 mb-2">Account</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="material-icons text-primary text-xl">account_balance</span>
                                </div>
                                <select name="account_id" required
                                    class="block w-full pl-11 py-3 bg-background-light dark:bg-zinc-800 border-none rounded-lg text-background-dark dark:text-white focus:ring-2 focus:ring-primary/50 appearance-none">
                                    <option value="">Select Account</option>
                                    <?php foreach ($accounts as $acc): ?>
                                    <option value="<?= $acc['id'] ?>"
                                        <?= old('account_id', $transaction['account_id'] ?? '') == $acc['id'] ? 'selected' : '' ?>>
                                        <?= esc($acc['name']) ?> (<?= ucfirst($acc['type']) ?>)
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <?php if (session('errors.account_id')): ?>
                            <p class="text-red-500 text-xs mt-1"><?= session('errors.account_id') ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Notes -->
                    <div>
                        <label class="block text-sm font-medium text-background-dark/60 dark:text-white/60 mb-2">Notes
                            (Optional)</label>
                        <textarea name="notes" rows="3"
                            class="block w-full p-4 bg-background-light dark:bg-zinc-800 border-none rounded-lg text-background-dark dark:text-white focus:ring-2 focus:ring-primary/50 resize-none placeholder:text-background-dark/20 dark:placeholder:text-white/20"
                            placeholder="What was this transaction for?"><?= old('notes') ?></textarea>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="mt-10 flex flex-col gap-3">
                    <button type="submit"
                        class="w-full bg-primary text-background-dark font-bold py-4 rounded-xl shadow-lg shadow-primary/20 hover:brightness-105 active:scale-[0.98] transition-all flex items-center justify-center gap-2">
                        <span class="material-icons">check_circle</span>
                        Save Transaction
                    </button>
                    <a href="<?= base_url('transactions') ?>"
                        class="w-full text-center py-3 text-sm font-medium text-background-dark/40 dark:text-white/40 hover:text-background-dark dark:hover:text-white transition-colors">
                        Discard Changes
                    </a>
                </div>
            </form>
        </div>
    </main>

    <!-- Support Tip -->
    <div class="hidden lg:fixed bottom-8 right-8 flex items-center gap-4">
        <div
            class="p-3 bg-white dark:bg-zinc-900 rounded-xl shadow-xl border border-primary/10 flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                <span class="material-icons">lightbulb</span>
            </div>
            <div>
                <p class="text-xs font-bold text-background-dark dark:text-white">Pro Tip</p>
                <p class="text-[10px] text-background-dark/50 dark:text-white/50 uppercase tracking-tighter">Press <kbd
                        class="px-1 border rounded">Enter</kbd> to save quickly</p>
            </div>
        </div>
    </div>

    <?php
    // Prepare categories grouped by type
    $incomeCategories = array_filter($categories, fn($cat) => $cat['type'] === 'income');
    $expenseCategories = array_filter($categories, fn($cat) => $cat['type'] === 'expense');
    ?>

    <script>
        // ==================== CATEGORY FILTER ====================
        const categoriesByType = {
            income: <?= json_encode(array_values($incomeCategories)) ?>,
            expense: <?= json_encode(array_values($expenseCategories)) ?>
        };

        const categorySelect = document.getElementById('categorySelect');
        const typeRadios = document.querySelectorAll('input[name="type"]');

        function updateCategoryOptions(selectedType) {
            categorySelect.innerHTML = '<option value="">Select Category</option>';
            const categories = categoriesByType[selectedType] || [];
            categories.forEach(cat => {
                const option = document.createElement('option');
                option.value = cat.id;
                option.textContent = cat.name;
                categorySelect.appendChild(option);
            });
            const oldCategory = '<?= old('category_id') ?>';
            if (oldCategory) {
                const optionExists = Array.from(categorySelect.options).some(opt => opt.value === oldCategory);
                if (optionExists) {
                    categorySelect.value = oldCategory;
                }
            }
        }

        const checkedRadio = document.querySelector('input[name="type"]:checked');
        if (checkedRadio) {
            updateCategoryOptions(checkedRadio.value);
        }

        typeRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.checked) {
                    updateCategoryOptions(this.value);
                }
            });
        });

        // ==================== AMOUNT FORMATTING & DYNAMIC FONT SIZE ====================
        const displayInput = document.getElementById('amountDisplay');
        const form = displayInput.closest('form');

        function formatRupiah(angka, prefix = 'Rp ') {
            let number_string = angka.replace(/[^,\d]/g, '').toString();
            let split = number_string.split(',');
            let sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa);
            let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix ? prefix + rupiah : rupiah;
        }

        function cleanRupiah(rupiah) {
            return rupiah.replace(/[^\d,]/g, '').replace(',', '.');
        }

        function getDigitCount(rawValue) {
            return rawValue.replace(/\D/g, '').length;
        }

        function adjustFontSize(input, digitCount) {
            let baseSize = 48;
            let maxDigits = 10;
            let minSize = 20;
            let extraDigits = Math.max(0, digitCount - maxDigits);
            let newSize = Math.max(minSize, baseSize - (extraDigits * 3));
            input.style.fontSize = newSize + 'px';
        }

        if (displayInput.value) {
            let raw = displayInput.value.replace(/^Rp\s?/i, '');
            let digits = getDigitCount(raw);
            adjustFontSize(displayInput, digits);
        } else {
            adjustFontSize(displayInput, 0);
        }

        displayInput.addEventListener('input', function(e) {
            let value = this.value;
            value = value.replace(/^Rp\s?/i, '');
            let raw = value.replace(/[^\d,]/g, '');
            let parts = raw.split(',');
            if (parts.length > 2) {
                raw = parts[0] + ',' + parts.slice(1).join('');
            }

            let digitCount = raw.replace(/\D/g, '').length;

            let formatted = formatRupiah(raw, 'Rp ');
            this.value = formatted;

            adjustFontSize(this, digitCount);

            this.setSelectionRange(formatted.length, formatted.length);
        });

        form.addEventListener('submit', function(e) {
            let rawDisplay = displayInput.value;
            let cleaned = cleanRupiah(rawDisplay);

            let hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'amount';
            hiddenInput.value = cleaned;
            form.appendChild(hiddenInput);

            displayInput.disabled = true;
        });
    </script>
</body>

</html>
