<div class="flex flex-col gap-6">
    <div class="flex items-end justify-between gap-6">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight">Utilisateurs</h1>
            <p class="mt-1 text-slate-600">Gestion des statuts et des rôles.</p>
        </div>
        <div class="flex gap-2">
            <a class="rounded-xl border px-4 py-2 text-sm font-medium hover:bg-slate-50" href="<?= ROOT_URL ?>admin/petitions">Pétitions</a>
        </div>
    </div>

    <div class="overflow-hidden rounded-2xl border bg-white shadow-sm">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-600">
                <tr>
                    <th class="px-4 py-3 text-left font-medium">Utilisateur</th>
                    <th class="px-4 py-3 text-left font-medium">Email</th>
                    <th class="px-4 py-3 text-left font-medium">Rôle</th>
                    <th class="px-4 py-3 text-left font-medium">Statut</th>
                    <th class="px-4 py-3 text-right font-medium">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                <?php foreach ($users as $u) : ?>
                    <tr>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <?php if (!empty($u['avatar'])) : ?>
                                    <img class="h-9 w-9 rounded-xl object-cover" src="<?= ROOT_URL . htmlspecialchars($u['avatar']) ?>" alt="">
                                <?php else : ?>
                                    <div class="h-9 w-9 rounded-xl bg-slate-200"></div>
                                <?php endif; ?>
                                <div>
                                    <div class="font-medium"><?= htmlspecialchars($u['pseudo']) ?></div>
                                    <div class="text-xs text-slate-500">#<?= (int)$u['id'] ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3"><?= htmlspecialchars($u['email']) ?></td>
                        <td class="px-4 py-3">
                            <span class="rounded-lg bg-slate-100 px-2 py-1 text-xs font-medium"><?= htmlspecialchars($u['role']) ?></span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="rounded-lg bg-slate-100 px-2 py-1 text-xs font-medium"><?= htmlspecialchars($u['status']) ?></span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <?php if ($u['status'] === 'ACTIVE') : ?>
                                <a class="inline-flex rounded-lg border border-rose-200 bg-rose-50 px-3 py-1.5 text-rose-800 hover:bg-rose-100" href="<?= ROOT_URL ?>admin/ban/<?= (int)$u['id'] ?>">Bannir</a>
                            <?php else : ?>
                                <a class="inline-flex rounded-lg border px-3 py-1.5 hover:bg-slate-50" href="<?= ROOT_URL ?>admin/unban/<?= (int)$u['id'] ?>">Réactiver</a>
                            <?php endif; ?>

                            <?php if ($u['role'] === 'USER') : ?>
                                <a class="inline-flex rounded-lg border px-3 py-1.5 hover:bg-slate-50" href="<?= ROOT_URL ?>admin/promote/<?= (int)$u['id'] ?>">Admin</a>
                            <?php else : ?>
                                <a class="inline-flex rounded-lg border px-3 py-1.5 hover:bg-slate-50" href="<?= ROOT_URL ?>admin/demote/<?= (int)$u['id'] ?>">User</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
