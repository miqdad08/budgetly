<?= $this->extend('layouts/auth') ?>
<?= $this->section('title') ?>Create Account<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Toggle -->
<div class="flex p-1 bg-gray-100 dark:bg-zinc-800 rounded-lg mb-8">
    <a href="<?= base_url('login') ?>" class="flex-1 py-2 text-sm font-medium rounded-md text-center no-underline 
            bg-gray-100 text-gray-700 hover:bg-white
            dark:bg-zinc-700 dark:text-gray-200 dark:hover:bg-zinc-600">
        Login
    </a>
    <span class="flex-1 py-2 text-sm font-medium rounded-md text-center bg-primary text-black">
        Register
    </span>
</div>


<form action="<?= base_url('register') ?>" method="POST">
    <?= csrf_field() ?>

    <!-- Full Name -->
    <div class="mb-5"> <!-- spacing antar form -->
        <label for="regName"
            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5 ml-1">
            Full Name
        </label>
        <div class="relative">
            <span
                class="material-icons absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg">person_outline</span>
            <input type="text" id="regName" name="name" value="<?= old('name') ?>" placeholder="John Doe"
                class="w-full pl-10 pr-4 py-3 bg-gray-50 dark:bg-zinc-800 border-gray-200 dark:border-zinc-700 rounded-lg text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all dark:text-white"
                required>
        </div>
    </div>

    <!-- Email -->
    <div class="mb-5">
        <label for="regEmail"
            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5 ml-1">
            Email Address
        </label>
        <div class="relative">
            <span
                class="material-icons absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg">mail_outline</span>
            <input type="email" id="regEmail" name="email" value="<?= old('email') ?>" placeholder="name@company.com"
                class="w-full pl-10 pr-4 py-3 bg-gray-50 dark:bg-zinc-800 border-gray-200 dark:border-zinc-700 rounded-lg text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all dark:text-white"
                required>
        </div>
    </div>

    <!-- Password -->
    <div class="mb-5">
        <label for="regPassword"
            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5 ml-1">
            Password
        </label>
        <div class="relative">
            <span
                class="material-icons absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg">lock_outline</span>
            <input type="password" id="regPassword" name="password" placeholder="••••••••"
                class="w-full pl-10 pr-12 py-3 bg-gray-50 dark:bg-zinc-800 border-gray-200 dark:border-zinc-700 rounded-lg text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all dark:text-white"
                required>
            <button type="button"
                class="password-toggle absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                <span class="material-icons text-lg">visibility_off</span>
            </button>
        </div>
    </div>

    <!-- Confirm Password -->
    <div class="mb-6">
        <label for="regConfirm"
            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5 ml-1">
            Confirm Password
        </label>
        <div class="relative">
            <span
                class="material-icons absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg">lock_outline</span>
            <input type="password" id="regConfirm" name="confirm_password" placeholder="••••••••"
                class="w-full pl-10 pr-12 py-3 bg-gray-50 dark:bg-zinc-800 border-gray-200 dark:border-zinc-700 rounded-lg text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all dark:text-white"
                required>
            <button type="button"
                class="password-toggle absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                <span class="material-icons text-lg">visibility_off</span>
            </button>
        </div>
    </div>

    <!-- Register Button -->
    <button type="submit"
        class="w-full bg-primary hover:bg-opacity-90 text-background-dark font-semibold py-3 rounded-lg shadow-lg shadow-primary/20 transition-all flex items-center justify-center gap-2 group">
        Create Account
        <span class="material-icons text-xl group-hover:translate-x-1 transition-transform">arrow_forward</span>
    </button>
</form>
<?= $this->endSection() ?>