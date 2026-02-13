<div class="mx-auto max-w-md">
    <h1 class="text-2xl font-semibold tracking-tight text-center">Inscription</h1>
    <p class="mt-1 text-slate-600 text-center">Créez un compte pour signer et publier des pétitions.</p>

    <form class="mt-6 space-y-4 rounded-2xl border bg-white p-6 shadow-sm" method="post" enctype="multipart/form-data" action="<?= ROOT_URL ?>auth/register">
        <div>
            <label class="block text-sm font-medium">Avatar (optionnel)</label>
            <input name="avatar" type="file" accept="image/png,image/jpeg,image/webp" class="mt-1 w-full rounded-xl border bg-white px-3 py-2 text-sm file:mr-4 file:rounded-lg file:border-0 file:bg-slate-900 file:px-4 file:py-2 file:text-sm file:font-medium file:text-white hover:file:bg-slate-800">
        </div>
    
        <div>
            <label class="block text-sm font-medium">Pseudo</label>
            <input name="pseudo" type="text" required class="mt-1 w-full rounded-xl border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-slate-300">
        </div>

        <div>
            <label class="block text-sm font-medium">Email</label>
            <input name="email" type="email" required class="mt-1 w-full rounded-xl border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-slate-300">
        </div>

        <div>
            <label class="block text-sm font-medium">Mot de passe</label>
            <input name="password" type="password" required class="mt-1 w-full rounded-xl border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-slate-300">
        </div>

        <div>
            <label class="block text-sm font-medium">Confirmation</label>
            <input name="password2" type="password" required class="mt-1 w-full rounded-xl border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-slate-300">
        </div>

        <button class="w-full rounded-xl bg-slate-900 px-4 py-2.5 font-medium text-white hover:bg-slate-800">Créer le compte</button>

        <p class="text-sm text-slate-600 text-center">
            Déjà inscrit ?
            <a class="font-medium text-slate-900 underline" href="<?= ROOT_URL ?>auth/login">Se connecter</a>
        </p>
    </form>
</div>
