<?php
$isEdit = !empty($petition);
$action = $isEdit ? (ROOT_URL . 'petition/edit/' . (int)$petition['id']) : (ROOT_URL . 'petition/create');
?>
<div class="flex flex-col mx-auto">
    <div class="flex items-end justify-between gap-6">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight"><?= $isEdit ? 'Modifier une pétition' : 'Créer une pétition' ?></h1>
            <p class="mt-1 text-slate-600">Rédigez un titre clair et une description précise.</p>
        </div>
        <a class="rounded-xl border px-4 py-2 text-sm font-medium hover:bg-slate-50" href="<?= ROOT_URL ?>">Retour</a>
    </div>

    <form class="mt-6 space-y-4 rounded-2xl border bg-white p-6 shadow-sm" method="post" enctype="multipart/form-data" action="<?= $action ?>">


        <div class="grid gap-4 md:grid-cols-2">
            <div>
                <label class="block text-sm font-medium">Titre</label>
                <input name="title" type="text" required value="<?= $isEdit ? htmlspecialchars($petition['title']) : '' ?>" class="mt-1 w-full rounded-xl border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-slate-300">
            </div>
            
            <div>
                <label class="block text-sm font-medium">Catégorie</label>
                <select name="category_id" required class="mt-1 w-full rounded-xl border px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-slate-300">
                    <option value="">Choisir</option>
                    <?php foreach ($categories as $c) : ?>
                        <?php $selected = $isEdit && ((int)$petition['category_id'] === (int)$c['id']); ?>
                        <option value="<?= (int)$c['id'] ?>" <?= $selected ? 'selected' : '' ?>><?= htmlspecialchars($c['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium">Description</label>
            <textarea name="description" rows="8" required class="mt-1 w-full rounded-xl border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-slate-300"><?= $isEdit ? htmlspecialchars($petition['description']) : '' ?></textarea>
        </div>

        <div class="grid gap-4 md:grid-cols-2">
            <div>
                <label class="block text-sm font-medium">Objectif (signatures)</label>
                <input name="goal_signatures" type="number" min="1" required value="<?= $isEdit ? (int)$petition['goal_signatures'] : 100 ?>" class="mt-1 w-full rounded-xl border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-slate-300">
            </div>

            <div>
                <label class="block text-sm font-medium"><?= $isEdit ? 'Changer l\'image' : 'Image' ?></label>

                                    <input name="avatar" type="file" accept="image/png,image/jpeg,image/webp" 
                           class="mt-1 w-full rounded-xl border bg-white text-sm file:mr-4 file:rounded-lg file:border-0 file:bg-slate-900 file:px-4 file:py-2 file:text-sm file:font-medium file:text-white hover:file:bg-slate-800">
                <p class="mt-1 text-xs text-slate-500">PNG, JPG, JPEG, WEBP (3 MB max).</p>
            </div>
        </div>

        <?php if ($isEdit && !empty($petition['image'])) : ?>
            <div class="rounded-2xl border bg-slate-50 p-4">
                <div class="text-sm font-medium">Image actuelle</div>
                <img class="mt-3 max-h-56 rounded-xl border object-cover" src="<?= ROOT_URL . htmlspecialchars($petition['image']) ?>" alt="">
            </div>
        <?php endif; ?>

        <div class="flex items-center gap-2">
            <button class="rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-medium text-white hover:bg-slate-800">
                <?= $isEdit ? 'Enregistrer' : 'Publier' ?>
            </button>
            <?php if ($isEdit) : ?>
                <a class="rounded-xl border px-4 py-2.5 text-sm font-medium hover:bg-slate-50" href="<?= ROOT_URL ?>petition/show/<?= (int)$petition['id'] ?>">Annuler</a>
            <?php endif; ?>
        </div>
    </form>
</div>
