<?= $this->extend('layouts/auth') ?>
<?= $this->section('title') ?>Sign In<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Toggle Buttons -->
<div class="flex p-1 bg-gray-100 dark:bg-zinc-800 rounded-lg mb-8">
    <span
        class="flex-1 py-2 text-sm font-medium rounded-md text-center bg-white text-gray-900 shadow-sm dark:bg-zinc-700 dark:text-white">
        Login
    </span>

    <a href="<?= base_url('register') ?>"
        class="flex-1 py-2 text-sm font-medium rounded-md text-center no-underline bg-gray-100 text-gray-700 dark:bg-zinc-700 dark:text-gray-200">
        Register
    </a>
</div>

<!-- FORM LOGIN -->
<form action="<?= base_url('login') ?>" method="POST" class="space-y-5">
    <?= csrf_field() ?>


    <!-- Email -->
    <div>
        <label for="loginEmail"
            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5 ml-1">
            Email Address
        </label>
        <div class="relative">
            <span
                class="material-icons absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg">mail_outline</span>
            <input type="email" id="loginEmail" name="email" value="<?= old('email') ?>"
                placeholder="name@company.com"
                class="w-full pl-10 pr-4 py-3 bg-gray-50 dark:bg-zinc-800 border-gray-200 dark:border-zinc-700 rounded-lg text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all dark:text-white"
                required />
        </div>
    </div>
    <!-- Password -->
    <div>
        <div class="flex justify-between items-center mb-1.5 ml-1">
            <label for="loginPassword"
                class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                Password
            </label>
            <a href="<?= base_url('forgot-password') ?>" class="text-xs font-medium text-primary hover:underline">Forgot
                password?</a>
        </div>
        <div class="relative">
            <span
                class="material-icons absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg">lock_outline</span>
            <input type="password" id="loginPassword" name="password" placeholder="••••••••"
                class="w-full pl-10 pr-12 py-3 bg-gray-50 dark:bg-zinc-800 border-gray-200 dark:border-zinc-700 rounded-lg text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all dark:text-white"
                required />
            <button type="button"
                class="password-toggle absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                <span class="material-icons text-lg">visibility_off</span>
            </button>
        </div>
    </div>
    <!-- Remember Me -->
    <div class="flex items-center space-x-2 ml-1">
        <input type="checkbox" id="remember" name="remember"
            class="w-4 h-4 rounded text-primary border-gray-300 focus:ring-primary" />
        <label for="remember" class="text-sm text-gray-600 dark:text-gray-400">Keep me logged in</label>
    </div>
    <!-- Sign In Button -->
    <button type="submit"
        class="w-full bg-primary hover:bg-opacity-90 text-background-dark font-semibold py-3 rounded-lg shadow-lg shadow-primary/20 transition-all flex items-center justify-center gap-2 group">
        Sign In
        <span class="material-icons text-xl group-hover:translate-x-1 transition-transform">arrow_forward</span>
    </button>
</form>
<?= $this->endSection() ?>
