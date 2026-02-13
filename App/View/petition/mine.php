<div class="flex flex-col gap-6">
    <div class="flex items-end justify-between gap-6">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight">Mes pétitions</h1>
            <p class="mt-1 text-slate-600">Gestion de vos publications.</p>
        </div>
        <a class="rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-medium text-white hover:bg-slate-800" href="<?= ROOT_URL ?>petition/create">Créer</a>
    </div>

    <div class="overflow-hidden rounded-2xl border bg-white shadow-sm">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-600">
                <tr>
                    <th class="px-4 py-3 text-left font-medium">Titre</th>
                    <th class="px-4 py-3 text-left font-medium">Catégorie</th>
                    <th class="px-4 py-3 text-left font-medium">Signatures</th>
                    <th class="px-4 py-3 text-right font-medium">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                <?php foreach ($petitions as $p) : ?>
                    <tr>
                        <td class="px-4 py-3">
                            <a class="font-medium hover:underline" href="<?= ROOT_URL ?>petition/show/<?= (int)$p['id'] ?>"><?= htmlspecialchars($p['title']) ?></a>
                            <div class="text-xs text-slate-500"><?= htmlspecialchars(date('d/m/Y', strtotime($p['created_at']))) ?></div>
                        </td>
                        <td class="px-4 py-3"><?= htmlspecialchars($p['category_name']) ?></td>
                        <td class="px-4 py-3"><?= (int)$p['signatures_count'] ?></td>
                        <td class="px-4 py-3 text-right">
                            <a class="inline-flex rounded-lg border px-3 py-1.5 hover:bg-slate-50" href="<?= ROOT_URL ?>petition/edit/<?= (int)$p['id'] ?>">Modifier</a>
                            <a class="inline-flex rounded-lg border border-rose-200 bg-rose-50 px-3 py-1.5 text-rose-800 hover:bg-rose-100" href="<?= ROOT_URL ?>petition/delete/<?= (int)$p['id'] ?>" onclick="return confirm('Supprimer ?')">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>

                <?php if (empty($petitions)) : ?>
                    <tr>
                        <td class="px-4 py-6 text-slate-600" colspan="4">Aucune pétition.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
