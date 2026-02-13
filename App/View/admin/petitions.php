<div class="flex flex-col gap-6">
    <div class="flex items-end justify-between gap-6">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight">Pétitions</h1>
            <p class="mt-1 text-slate-600">Visibilité des contenus.</p>
        </div>
        <div class="flex gap-2">
            <a class="rounded-xl border px-4 py-2 text-sm font-medium hover:bg-slate-50" href="<?= ROOT_URL ?>admin/users">Utilisateurs</a>
        </div>
    </div>

    <div class="overflow-hidden rounded-2xl border bg-white shadow-sm">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-600">
                <tr>
                    <th class="px-4 py-3 text-left font-medium">Titre</th>
                    <th class="px-4 py-3 text-left font-medium">Auteur</th>
                    <th class="px-4 py-3 text-left font-medium">Catégorie</th>
                    <th class="px-4 py-3 text-left font-medium">Statut</th>
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
                        <td class="px-4 py-3"><?= htmlspecialchars($p['pseudo']) ?></td>
                        <td class="px-4 py-3"><?= htmlspecialchars($p['category_name']) ?></td>
                        <td class="px-4 py-3">
                            <span class="rounded-lg bg-slate-100 px-2 py-1 text-xs font-medium"><?= htmlspecialchars($p['status']) ?></span>
                        </td>
                        <td class="px-4 py-3"><?= (int)$p['signatures_count'] ?></td>
                        <td class="px-4 py-3 text-right">
                            <?php if ($p['status'] === 'PUBLISHED') : ?>
                                <a class="inline-flex rounded-lg border px-3 py-1.5 hover:bg-slate-50" href="<?= ROOT_URL ?>admin/hide/<?= (int)$p['id'] ?>">Masquer</a>
                            <?php else : ?>
                                <a class="inline-flex rounded-lg border px-3 py-1.5 hover:bg-slate-50" href="<?= ROOT_URL ?>admin/publish/<?= (int)$p['id'] ?>">Publier</a>
                            <?php endif; ?>
                            <a class="inline-flex rounded-lg border px-3 py-1.5 hover:bg-slate-50" href="<?= ROOT_URL ?>petition/edit/<?= (int)$p['id'] ?>">Éditer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>

                <?php if (empty($petitions)) : ?>
                    <tr>
                        <td class="px-4 py-6 text-slate-600" colspan="6">Aucune pétition.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
