<div class="mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-semibold tracking-tight">Profil</h1>
        <p class="mt-1 text-slate-600">Paramètres du compte.</p>
    </div>

    <section class="rounded-3xl border bg-white p-4 shadow-sm sm:p-4">
        <div class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-5">
                <?php if (!empty($user['avatar'])) : ?>
                    <img src="<?= ROOT_URL . htmlspecialchars($user['avatar']) ?>" alt="avatar" class="h-16 w-16 rounded-2xl object-cover sm:h-20 sm:w-20">
                <?php else : ?>
                    <div class="h-16 w-16 rounded-2xl bg-slate-900 text-white flex items-center justify-center text-2xl font-semibold sm:h-20 sm:w-20">
                        <?= htmlspecialchars(mb_strtoupper(mb_substr($user['pseudo'] ?? 'U', 0, 1))) ?>
                    </div>
                <?php endif; ?>

                <div class="min-w-0">
                    <div class="flex flex-wrap items-center gap-2">
                        <h2 class="text-xl font-semibold leading-tight sm:text-2xl">
                            <?= htmlspecialchars($user['pseudo'] ?? '') ?>
                        </h2>
                    </div>

                    <div class="mt-1 text-sm text-slate-600 truncate">
                        <?= htmlspecialchars($user['email'] ?? '') ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="mt-8 grid gap-6 lg:grid-cols-2">
        <section class="rounded-3xl border bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold">Avatar</h2>
            <p class="mt-1 text-sm text-slate-600">Formats: jpg, png, webp. Taille max: 2MB.</p>

            <form class="mt-5 space-y-4" method="post" enctype="multipart/form-data" action="<?= ROOT_URL ?>user/profile">
                <input type="hidden" name="section" value="avatar">

                <div>
                    <label class="block text-sm font-medium">Fichier</label>
                    <input name="avatar" type="file" accept="image/png,image/jpeg,image/webp" required
                           class="mt-1 w-full rounded-xl border bg-white px-3 py-2 text-sm file:mr-4 file:rounded-lg file:border-0 file:bg-slate-900 file:px-4 file:py-2 file:text-sm file:font-medium file:text-white hover:file:bg-slate-800">
                </div>

                <button class="w-full rounded-xl bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-800">
                    Mettre à jour
                </button>
            </form>
        </section>

        <section class="rounded-3xl border bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold">Mot de passe</h2>
            <p class="mt-1 text-sm text-slate-600">Choisissez un mot de passe d'au moins 8 caractères.</p>

            <form class="mt-5 space-y-4" method="post" action="<?= ROOT_URL ?>user/profile">
                <input type="hidden" name="section" value="password">

                <div>
                    <label class="block text-sm font-medium">Mot de passe actuel</label>
                    <input name="password_current" type="password" required
                           class="mt-1 w-full rounded-xl border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-slate-300">
                </div>

                <div>
                    <label class="block text-sm font-medium">Nouveau mot de passe</label>
                    <input name="password_new" type="password" required
                           class="mt-1 w-full rounded-xl border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-slate-300">
                </div>

                <div>
                    <label class="block text-sm font-medium">Confirmation</label>
                    <input name="password_confirm" type="password" required
                           class="mt-1 w-full rounded-xl border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-slate-300">
                </div>

                <button class="w-full rounded-xl bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-800">
                    Modifier
                </button>
            </form>
        </section>
    </div>
</div>
