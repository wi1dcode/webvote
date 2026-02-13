<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="<?= ROOT_URL ?>public/img/logo.png">
    <title>WebVote<?= isset($pageTitle) ? ' - ' . htmlspecialchars($pageTitle) : '' ?></title>
</head>
<body class="min-h-screen bg-slate-50 text-slate-900">
    <header class="border-b bg-white">
        <div class="mx-auto max-w-6xl px-4 py-4 flex items-center justify-between">
            <a href="<?= ROOT_URL ?>" class="flex items-center gap-2 font-semibold tracking-tight">
                <img src="<?= ROOT_URL ?>public/img/logo.png" alt="Logo" class="h-8 w-auto">
                <span>WebVote</span>
            </a>

            <nav class="flex items-center gap-2 text-sm">
                <a class="px-3 py-2 rounded-lg hover:bg-slate-100" href="<?= ROOT_URL ?>">Pétitions</a>

                <?php if (!empty($user)) : ?>
                    <a class="px-3 py-2 rounded-lg hover:bg-slate-100" href="<?= ROOT_URL ?>petition/mine">Mes pétitions</a>
                    <a class="px-3 py-2 rounded-lg hover:bg-slate-100" href="<?= ROOT_URL ?>petition/create">Créer</a>
                    <a class="px-3 py-2 rounded-lg hover:bg-slate-100" href="<?= ROOT_URL ?>user/profile">Profil</a>

                    <?php if (($user['role'] ?? '') === 'ADMIN') : ?>
                        <a class="px-3 py-2 rounded-lg hover:bg-green-800 bg-green-700 text-white" href="<?= ROOT_URL ?>admin/petitions">Admin</a>
                    <?php endif; ?>

                    <a class="px-3 py-2 rounded-lg bg-red-700 text-white hover:bg-red-800" href="<?= ROOT_URL ?>auth/logout">Déconnexion</a>
                <?php else : ?>
                    <a class="px-3 py-2 rounded-lg hover:bg-slate-100" href="<?= ROOT_URL ?>auth/login">Connexion</a>
                    <a class="px-3 py-2 rounded-lg bg-green-700 text-white hover:bg-green-800" href="<?= ROOT_URL ?>auth/register">Inscription</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <main class="mx-auto max-w-6xl px-4 py-8">
        <?php if (!empty($messages['errors'])) : ?>
            <div class="mb-6 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-rose-800">
                <?= htmlspecialchars($messages['errors']) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($messages['success'])) : ?>
            <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800">
                <?= htmlspecialchars($messages['success']) ?>
            </div>
        <?php endif; ?>

        <?= $content ?>
    </main>

    <footer class="border-t bg-white w-full">
        <div class="mx-auto text-center max-w-6xl px-4 py-6 text-sm text-slate-500 flex items-center justify-between">
            <span>© <?= date('Y') ?> WebVote</span>
        </div>
    </footer>
</body>
</html>
