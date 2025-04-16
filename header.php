<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>supinstream</title>
    <link href="src/output.css" rel="stylesheet">
</head>
<body>
<header class="bg-[#181A1B] shadow">
    <nav class="mx-auto flex max-w-7xl items-center justify-between p-4 lg:px-8" aria-label="Global">
        <div class="flex lg:flex-1">
            <a href="index.php" class="-m-1.5 p-1.5">
                <span class="sr-only">Supinstream</span>
                <img class="h-8 w-auto" src="images/fast-forward-circle-regular-24%20(1).png" alt="">
            </a>
        </div>

        <div class="flex lg:hidden">
            <button type="button" id="mobile-menu-button" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-[#BDB7AE]">
                <span class="sr-only">Open main menu</span>
                <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>
        </div>

        <div class="hidden lg:flex lg:gap-x-8">
            <a href="index.php" class="text-sm font-semibold text-white hover:text-indigo-600">Accueil</a>
            <a href="movei.php" class="text-sm font-semibold text-white hover:text-indigo-600">Films</a>
            <a href="categories.php" class="text-sm font-semibold text-white hover:text-indigo-600">Categories</a>
        </div>

        <div class="hidden lg:flex lg:flex-1 lg:justify-center mx-4">
            <form method="GET" action="search.php" class="flex w-full max-w-md">
                <input type="text" name="query" placeholder="Search..." class="w-full rounded-l-md text-[#9E9E9D] shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <button type="submit" class="rounded-r-md border border-l-0 border-indigo-600 bg-indigo-600 px-4 text-sm font-semibold text-white hover:bg-indigo-700">
                    Search
                </button>
            </form>
        </div>

        <div class="hidden lg:flex lg:items-center lg:gap-x-6">
            <a href="cart.php" class="p-2 text-[#BDB7AE] hover:text-indigo-600">
                <span class="sr-only">Cart</span>
                <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                </svg>
            </a>
            <a href="<?php echo isset($_SESSION['user_id']) ? 'account.php' : 'connexion.php'; ?>" class="p-2 text-[#BDB7AE] hover:text-indigo-600">
                <span class="sr-only">User account</span>
                <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                </svg>
            </a>
        </div>
    </nav>

    <div class="lg:hidden hidden" id="mobile-menu" role="dialog" aria-modal="true">
        <div class="fixed inset-y-0 right-0 z-10 w-full overflow-y-auto bg-[#181A1B] px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
            <div class="flex items-center justify-between">
                <a href="index.php" class="-m-1.5 p-1.5">
                    <span class="sr-only">Your Company</span>
                    <img class="h-8 w-auto" src="images/fast-forward-circle-regular-24%20(1).png" alt="">
                </a>
                <button type="button" id="close-mobile-menu" class="-m-2.5 rounded-md p-2.5 text-[#7C7C7B]">
                    <span class="sr-only">Close menu</span>
                    <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="mt-6 flow-root">
                <div class="-my-6 divide-y divide-gray-500/10">
                    <div class="space-y-2 py-6">
                        <a href="index.php" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold text-[#D6D3CD] hover:bg-gray-50">Accueil</a>
                        <a href="movies.php" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold text-[#D6D3CD] hover:bg-gray-50">Films</a>
                        <a href="categories.php" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold text-[#D6D3CD] hover:bg-gray-50">Categories</a>
                    </div>

                    <div class="py-6">
                        <form class="flex w-full">
                            <input type="text" placeholder="Search..." class="w-full rounded-l-md border-[#7C7C7B] shadow-sm focus:border-indigo-500 focus:ring-[#7C7C7B] text-[#7C7C7B]">
                            <button type="submit" class="rounded-r-md border border-l-0 border-indigo-600 bg-indigo-600 px-4 text-sm font-semibold text-white hover:bg-indigo-700">
                                Search
                            </button>
                        </form>
                    </div>

                    <div class="py-6 flex justify-between">
                        <a href="cart.php" class="flex items-center gap-2 rounded-lg px-3 py-2 text-base font-semibold text-[#7C7C7B] hover:bg-gray-50">
                            <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                            </svg>
                            Cart
                        </a>
                        <a href="<?php echo isset($_SESSION['user_id']) ? 'account.php' : 'connexion.php'; ?>" class="flex items-center gap-2 rounded-lg px-3 py-2 text-base font-semibold text-[#7C7C7B] hover:bg-gray-50">
                            <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                            </svg>
                            <?php echo isset($_SESSION['user_id']) ? 'Account' : 'Log in'; ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
    document.getElementById('mobile-menu-button').addEventListener('click', function() {
        document.getElementById('mobile-menu').classList.toggle('hidden');
    });

    document.getElementById('close-mobile-menu').addEventListener('click', function() {
        document.getElementById('mobile-menu').classList.add('hidden');
    });
</script>
</body>
</html>
