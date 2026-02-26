<header
    class="h-20 border-b border-primary/10 bg-white/50 dark:bg-background-dark/50 backdrop-blur-md flex items-center justify-between px-8 sticky top-0 z-10">
    <div>
        <h2 class="text-2xl font-bold text-slate-900 dark:text-white">
            <?= $this->renderSection('page_title') ?: 'Dashboard Overview' ?>
        </h2>
        <p class="text-sm text-slate-500"><?= $this->renderSection('page_subtitle') ?: ''?></p>
    </div>
    <div class="flex items-center gap-4">
        <button class="p-2 text-slate-500 hover:bg-primary/5 rounded-full transition-all">
            <span class="material-icons">notifications</span>
        </button>
        <div class="h-8 w-8 rounded-full overflow-hidden bg-slate-200">
            <img alt="User Profile" class="w-full h-full object-cover"
                src="<?= session()->get('user_image') ?? 'https://via.placeholder.com/32' ?>" />
        </div>
    </div>
</header>