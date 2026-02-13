<div class="flex flex-col gap-6">
    <div class="flex items-end justify-between gap-6">
        <div>
            <h1 class="text-3xl font-semibold tracking-tight">Pétitions</h1>
            <p class="mt-1 text-slate-600">Découvrez, signez et partagez des causes.</p>
        </div>
        <?php if (!empty($user)) : ?>
            <a class="hidden sm:inline-flex rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-medium text-white hover:bg-slate-800" href="<?= ROOT_URL ?>petition/create">Nouvelle pétition</a>
        <?php endif; ?>
    </div>

    <form class="grid gap-3 rounded-2xl border bg-white p-4 shadow-sm md:grid-cols-4" method="get" action="<?= ROOT_URL ?>">
        <div class="md:col-span-2">
            <label class="block text-sm font-medium">Recherche</label>
            <input name="q" value="<?= htmlspecialchars((string)($filters['q'] ?? '')) ?>" class="mt-1 w-full rounded-xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-300" placeholder="Titre...">
        </div>

        <div>
            <label class="block text-sm font-medium">Catégorie</label>
            <select name="category_id" class="mt-1 w-full rounded-xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-300">
                <option value="">Toutes</option>
                <?php foreach ($categories as $c) : ?>
                    <option value="<?= (int)$c['id'] ?>" <?= ((string)($filters['category_id'] ?? '') === (string)$c['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($c['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="flex items-end gap-2">
            <button class="w-full rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-medium text-white hover:bg-slate-800">Filtrer</button>
            <a class="w-full text-center rounded-xl border px-4 py-2.5 text-sm font-medium hover:bg-slate-50" href="<?= ROOT_URL ?>">Réinitialiser</a>
        </div>
    </form>

    <div class="grid gap-4 md:grid-cols-2">
        <?php foreach ($petitions as $p) : ?>
            <?php
                $count = (int)$p['signatures_count'];
                $goal = max(1, (int)$p['goal_signatures']);
                $pct = min(100, (int)floor(($count / $goal) * 100));
            ?>
            <a href="<?= ROOT_URL ?>petition/show/<?= (int)$p['id'] ?>" class="group rounded-2xl border bg-white p-5 shadow-sm hover:shadow-md transition">
                <div class="flex gap-4">
                    <div class="h-16 w-16 shrink-0 overflow-hidden rounded-2xl bg-slate-100">
                        <?php if (!empty($p['image'])) : ?>
                            <img class="h-full w-full object-cover" src="<?= ROOT_URL . htmlspecialchars($p['image']) ?>" alt="">
                        <?php endif; ?>
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="flex items-center justify-between gap-3">
                            <h2 class="truncate text-lg font-semibold group-hover:underline"><?= htmlspecialchars($p['title']) ?></h2>
                            <span class="shrink-0 rounded-lg bg-slate-100 px-2 py-1 text-xs font-medium text-slate-700"><?= htmlspecialchars($p['category_name']) ?></span>
                        </div>
                        <p class="mt-1 text-sm text-slate-600"><?= htmlspecialchars(mb_strimwidth($p['description'], 0, 140, '…')) ?></p>

                        <div class="mt-4">
                            <div class="flex items-center justify-between text-xs text-slate-600">
                                <span><?= $count ?> signatures</span>
                                <span>objectif <?= $goal ?></span>
                            </div>
                            <div class="mt-2 h-2 w-full overflow-hidden rounded-full bg-slate-100">
                                <div class="h-2 rounded-full bg-slate-900" style="width: <?= $pct ?>%"></div>
                            </div>
                        </div>

                        <div class="mt-4 flex items-center justify-between text-xs text-slate-500">
                            <span>par <?= htmlspecialchars($p['pseudo']) ?></span>
                            <span><?= htmlspecialchars(date('d/m/Y', strtotime($p['created_at']))) ?></span>
                        </div>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>

        <?php if (empty($petitions)) : ?>
            <div class="rounded-2xl border bg-white p-6 text-slate-600 md:col-span-2">
                Aucun résultat.
            </div>
        <?php endif; ?>
    </div>
</div>
