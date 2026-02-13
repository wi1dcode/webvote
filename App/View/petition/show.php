<?php
$count = (int)$petition['signatures_count'];
$goal = max(1, (int)$petition['goal_signatures']);
$pct = min(100, (int)floor(($count / $goal) * 100));
$isOwner = !empty($user) && ((int)$user['id'] === (int)$petition['user_id']);
$isAdmin = !empty($user) && (($user['role'] ?? '') === 'ADMIN');
?>
<div class="grid gap-6 lg:grid-cols-3">
    <div class="lg:col-span-2">
        <div class="rounded-2xl border bg-white p-6 shadow-sm">
            <div class="flex flex-wrap items-start justify-between gap-4">
                <div class="min-w-0">
                    <div class="inline-flex items-center gap-2 text-xs text-slate-600">
                        <span class="rounded-lg bg-slate-100 px-2 py-1 font-medium"><?= htmlspecialchars($petition['category_name']) ?></span>
                        <span><?= htmlspecialchars(date('d/m/Y', strtotime($petition['created_at']))) ?></span>
                    </div>
                    <h1 class="mt-3 text-3xl font-semibold tracking-tight"><?= htmlspecialchars($petition['title']) ?></h1>
                    <div class="mt-4 flex items-center gap-3 text-sm text-slate-600">
                        <?php if (!empty($petition['avatar'])) : ?>
                            <img class="h-8 w-8 rounded-xl object-cover" src="<?= ROOT_URL . htmlspecialchars($petition['avatar']) ?>" alt="">
                        <?php else : ?>
                            <div class="h-8 w-8 rounded-xl bg-slate-200"></div>
                        <?php endif; ?>
                        <span>par <span class="font-medium text-slate-900"><?= htmlspecialchars($petition['pseudo']) ?></span></span>
                    </div>
                </div>

                <?php if ($isOwner || $isAdmin) : ?>
                    <div class="flex items-center gap-2">
                        <a class="rounded-xl border px-4 py-2 text-sm font-medium hover:bg-slate-50" href="<?= ROOT_URL ?>petition/edit/<?= (int)$petition['id'] ?>">Modifier</a>
                        <a class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-2 text-sm font-medium text-rose-800 hover:bg-rose-100" href="<?= ROOT_URL ?>petition/delete/<?= (int)$petition['id'] ?>" onclick="return confirm('Supprimer ?')">Supprimer</a>
                    </div>
                <?php endif; ?>
            </div>

            <?php if (!empty($petition['image'])) : ?>
                <div class="mt-6 overflow-hidden rounded-2xl border bg-slate-100">
                    <img class="w-full max-h-[380px] object-cover" src="<?= ROOT_URL . htmlspecialchars($petition['image']) ?>" alt="">
                </div>
            <?php endif; ?>

            <div class="mt-6 prose max-w-none">
                <p class="whitespace-pre-line text-slate-800"><?= htmlspecialchars($petition['description']) ?></p>
            </div>
        </div>
    </div>

    <div>
        <div class="rounded-2xl border bg-white p-6 shadow-sm">
            <h2 class="font-semibold">Objectif</h2>

            <div class="mt-4">
                <div class="flex items-center justify-between text-sm text-slate-600">
                    <span><?= $count ?> signatures</span>
                    <span>objectif <?= $goal ?></span>
                </div>
                <div class="mt-2 h-2 w-full overflow-hidden rounded-full bg-slate-100">
                    <div class="h-2 rounded-full bg-slate-900" style="width: <?= $pct ?>%"></div>
                </div>
                <div class="mt-2 text-xs text-slate-500"><?= $pct ?>%</div>
            </div>

            <div class="mt-6">
                <?php if (empty($user)) : ?>
                    <a class="inline-flex w-full justify-center rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-medium text-white hover:bg-slate-800" href="<?= ROOT_URL ?>auth/login">Se connecter pour signer</a>
                <?php else : ?>
                    <?php if ($signed) : ?>
                        <a class="inline-flex w-full justify-center rounded-xl border px-4 py-2.5 text-sm font-medium hover:bg-slate-50" href="<?= ROOT_URL ?>signature/delete/<?= (int)$petition['id'] ?>">Retirer ma signature</a>
                    <?php else : ?>
                        <a class="inline-flex w-full justify-center rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-medium text-white hover:bg-slate-800" href="<?= ROOT_URL ?>signature/create/<?= (int)$petition['id'] ?>">Signer</a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="mt-6 rounded-2xl border bg-white p-6 shadow-sm">
            <h2 class="font-semibold">À propos</h2>
            <p class="mt-2 text-sm text-slate-600">Chaque compte ne peut signer qu'une seule fois.</p>
        </div>

        <div class="mt-6 rounded-2xl border bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <h2 class="font-semibold">Commentaires</h2>
                <span class="text-xs text-slate-500"><?= count($comments ?? []) ?> élément(s)</span>
            </div>

            <?php if (!empty($user) && (($user['status'] ?? '') === 'ACTIVE')) : ?>
                <form class="mt-4 flex gap-3" method="post" action="<?= ROOT_URL ?>comment/create/<?= (int)$petition['id'] ?>">
                    <textarea name="content" rows="2" required class="w-full resize-none rounded-xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-300" placeholder="Votre message..."></textarea>
                    <button class="h-fit rounded-xl bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-800">Envoyer</button>
                </form>
            <?php elseif (!empty($user) && (($user['status'] ?? '') !== 'ACTIVE')) : ?>
                <div class="mt-4 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900">
                    Compte suspendu : publication désactivée.
                </div>
            <?php else : ?>
                <div class="mt-4 rounded-xl border bg-slate-50 px-4 py-3 text-sm text-slate-700">
                    Connectez-vous pour publier un commentaire.
                </div>
            <?php endif; ?>

            <div class="mt-6 space-y-4">
                <?php foreach (($comments ?? []) as $c) : ?>
                    <?php
                        $canDelete = !empty($user) && (((int)$c['user_id'] === (int)($user['id'] ?? 0)) || (($user['role'] ?? '') === 'ADMIN'));
                    ?>
                    <div class="rounded-2xl border px-4 py-4">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <div class="text-sm font-medium"><?= htmlspecialchars($c['pseudo'] ?? '') ?></div>
                                <div class="text-xs text-slate-500"><?= htmlspecialchars($c['created_at'] ?? '') ?></div>
                            </div>
                            <?php if ($canDelete) : ?>
                                <a class="text-xs font-medium text-slate-700 hover:text-slate-900" href="<?= ROOT_URL ?>comment/delete/<?= (int)$c['id'] ?>/<?= (int)$petition['id'] ?>">Supprimer</a>
                            <?php endif; ?>
                        </div>
                        <div class="mt-2 whitespace-pre-line text-sm text-slate-700"><?= htmlspecialchars($c['content'] ?? '') ?></div>
                    </div>
                <?php endforeach; ?>

                <?php if (empty($comments)) : ?>
                    <div class="rounded-2xl border bg-slate-50 px-4 py-4 text-sm text-slate-600">
                        Aucun commentaire pour le moment.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
