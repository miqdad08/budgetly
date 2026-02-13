<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?> | Budgetly</title>
    
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <!-- Google Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="<?= base_url('assets/css/dashboard.css') ?>" rel="stylesheet">
    
    <!-- Tailwind Config (bisa dipisah ke JS) -->
    <script src="<?= base_url('assets/js/dashboard.js') ?>"></script>
    
    <?= $this->renderSection('styles') ?>
</head>
<body class="bg-background-light dark:bg-background-dark text-slate-800 dark:text-slate-100 font-display">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <?= $this->include('partials/sidebar') ?>
        
        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            <!-- Header -->
            <?= $this->include('partials/header') ?>
            
            <!-- Dynamic Content -->
            <div class="p-8 space-y-8">
                <?= $this->renderSection('content') ?>
            </div>
        </main>
    </div>
    
    <!-- Floating Action Button Mobile -->
    <button class="lg:hidden fixed bottom-6 right-6 w-14 h-14 bg-primary text-background-dark rounded-full shadow-2xl flex items-center justify-center z-50">
        <span class="material-icons">add</span>
    </button>
    
    <?= $this->renderSection('scripts') ?>
</body>
</html>