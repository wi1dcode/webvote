<div class="max-w-md flex items-center flex-col justify-center mx-auto">
    <h1 class="text-2xl font-semibold tracking-tight">Connexion</h1>
    <p class="mt-1 text-slate-600">Accédez à votre espace.</p>

    <form class="mt-6 space-y-4 rounded-2xl border bg-white p-6 shadow-sm w-full" method="post" action="<?= ROOT_URL ?>auth/login">
        <div>
            <label class="block text-sm font-medium">Email</label>
            <input name="email" type="email" required class="mt-1 w-full rounded-xl border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-slate-300">
        </div>

        <div>
            <label class="block text-sm font-medium">Mot de passe</label>
            <input name="password" type="password" required class="mt-1 w-full rounded-xl border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-slate-300">
        </div>

        <button class="w-full rounded-xl bg-slate-900 px-4 py-2.5 font-medium text-white hover:bg-slate-800">Se connecter</button>

        <p class="text-sm text-slate-600 text-center">
            Pas de compte ?
            <a class="font-medium text-slate-900 underline" href="<?= ROOT_URL ?>auth/register">Créer un compte</a>
        </p>
    </form>
</div>
