<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Budgetly | <?= $this->renderSection('title') ?></title>

    <!-- Tailwind & Fonts -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?= base_url('assets/css/styles.css') ?>" rel="stylesheet">

    <!-- Tailwind Config (bisa dipisah ke JS) -->
    <script src="<?= base_url('assets/js/dashboard.js') ?>"></script>
</head>

<body
    class="bg-background-light dark:bg-background-dark min-h-screen flex items-center justify-center font-display antialiased">
    <div class="w-full max-w-md p-6">
        <!-- Logo -->
        <div class="flex flex-col items-center mb-8">
            <div
                class="w-12 h-12 bg-primary flex items-center justify-center rounded-xl mb-3 shadow-lg shadow-primary/20">
                <span class="material-icons text-white text-3xl">account_balance_wallet</span>
            </div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Budgetly</h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Your wealth, simplified.</p>
        </div>

        <!-- Card -->
        <div
            class="bg-white dark:bg-zinc-900 rounded-xl auth-card-shadow border border-gray-100 dark:border-zinc-800 p-8 relative">
            <div id="toastContainer" class="toast-container"></div>
            <?= $this->renderSection('content') ?>

            <!-- Social Auth (tetap) -->
            <div class="relative my-8">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-200 dark:border-zinc-800"></div>
                </div>
                <div class="relative flex justify-center text-xs uppercase">
                    <span class="bg-white dark:bg-zinc-900 px-4 text-gray-400">Or continue with</span>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <button
                    class="flex items-center justify-center gap-2 py-2.5 px-4 border border-gray-200 dark:border-zinc-700 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-zinc-800 transition-all">
                    <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuDv52hVpsBpE4Pc0DBL3XhYnKFMRModaSMbJ9BTLwNYFX8TYXX6M-lT1MwPHf69iAMfDpL_2yLBRhaidJSA5ZWzKPJEQY2uxDZC9iX9F8Cf7kqoSpPGz10gZB9VzTld8ElnRFj7pUPlbHQO_GN6WkMIZA3M8aBLHzMHkbos9AEi6Uqc3x220IS1jUhbZo7M3Osh-QyAOO0BTEYLzMq2FfS4ktJxaNFm7Xn-AkcWeNEawVjrP5p6hmQV_QimQWhkk0aKBb4jVgrWHPM"
                        alt="Google" class="w-4 h-4">
                    Google
                </button>
                <button
                    class="flex items-center justify-center gap-2 py-2.5 px-4 border border-gray-200 dark:border-zinc-700 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-zinc-800 transition-all">
                    <span class="material-icons text-lg">apple</span>
                    Apple
                </button>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-8 flex flex-col items-center gap-4">
            <div class="flex gap-6 text-sm text-gray-500 dark:text-gray-400">
                <a href="<?= base_url('privacy') ?>" class="hover:text-primary transition-colors">Privacy Policy</a>
                <a href="<?= base_url('terms') ?>" class="hover:text-primary transition-colors">Terms of Service</a>
                <a href="<?= base_url('help') ?>" class="hover:text-primary transition-colors">Help Center</a>
            </div>
            <p class="text-xs text-gray-400 dark:text-gray-500">© 2024 Budgetly Inc. All rights reserved.</p>
        </div>
    </div>

    <!-- Decorative Elements -->
    <div class="fixed top-0 right-0 -z-10 w-1/3 h-1/3 opacity-20 pointer-events-none">
        <div class="w-full h-full bg-gradient-to-bl from-primary to-transparent blur-3xl rounded-full"></div>
    </div>
    <div class="fixed bottom-0 left-0 -z-10 w-1/4 h-1/4 opacity-10 pointer-events-none">
        <div class="w-full h-full bg-gradient-to-tr from-primary to-transparent blur-3xl rounded-full"></div>
    </div>

    <script>
        // Toast System (ringkas, aman, auto-remove 5 detik)
        (function() {
            const container = document.getElementById('toastContainer');
            if (container) container.innerHTML = '';

            function escapeHTML(str) {
                return String(str).replace(/[&<>"]/g, c => ({
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;'
                })[c]);
            }

            function showToast(msg, type = 'success') {
                const toast = document.createElement('div');
                toast.className = `toast toast-${type}`;
                toast.innerHTML = `
                    <span class="material-icons">${type === 'success' ? 'check_circle' : 'error_outline'}</span>
                    <span style="flex:1">${escapeHTML(msg)}</span>
                    <button class="ml-auto hover:opacity-80" onclick="this.closest('.toast').classList.add('toast-remove');setTimeout(()=>this.closest('.toast')?.remove(),200)">
                        <span class="material-icons text-white text-lg">close</span>
                    </button>
                `;
                container.appendChild(toast);
                setTimeout(() => {
                    toast.classList.add('toast-remove');
                    setTimeout(() => toast.remove(), 200);
                }, 5000);
            }

            <?php if (session()->getFlashdata('success')): ?>
            showToast('<?= esc(session()->getFlashdata('success'), 'js') ?>', 'success');
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
            showToast('<?= esc(session()->getFlashdata('error'), 'js') ?>', 'error');
            <?php endif; ?>
            <?php if ($errors = session()->getFlashdata('errors')): ?>
            showToast('<?= esc(is_array($errors) ? implode('. ', $errors) : $errors, 'js') ?>', 'error');
            <?php endif; ?>
        })();

        // Password Toggle
        (function() {
            document.querySelectorAll('.password-toggle').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const input = this.closest('.relative').querySelector('input');
                    const icon = this.querySelector('.material-icons');
                    input.type = input.type === 'password' ? 'text' : 'password';
                    icon.textContent = input.type === 'password' ? 'visibility_off' : 'visibility';
                });
            });
        })();
    </script>
</body>

</html>
