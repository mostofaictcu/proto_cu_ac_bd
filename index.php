<?php
$siteTitle = getenv('SITE_TITLE') ?: 'Prototypes of Chittagong university applications';
$siteSubtitle = getenv('SITE_SUBTITLE') ?: 'Explore official prototype applications, portals, and digital systems developed for Chittagong University.';

$apps = [];

// 1. Prefer APPS_JSON (single config source, easy to maintain)
$appsJson = getenv('APPS_JSON');
if (!empty($appsJson)) {
    $cleanJson = trim(trim($appsJson), '"\'');
    $decoded = json_decode($cleanJson, true);
    if (is_array($decoded)) {
        $apps = $decoded;
    }
}

// 2. Fallback to indexed apps (APP_1_URL, APP_1_TITLE, APP_1_LOGO, etc.)
if (empty($apps)) {
    for ($i = 1; $i <= 10; $i++) {
        $url = getenv("APP_{$i}_URL") ?: getenv("APP_URL_{$i}");
        if (!empty($url)) {
            $apps[] = [
                'url' => $url,
                'title' => getenv("APP_{$i}_TITLE") ?: getenv("APP_TITLE_{$i}") ?: "Application #{$i}",
                'logo' => getenv("APP_{$i}_LOGO") ?: getenv("APP_LOGO_{$i}") ?: ''
            ];
        }
    }
}

// 3. Fallback to primary app variables (APP_URL, APP_TITLE, APP_LOGO)
if (empty($apps)) {
    $appUrl = getenv('APP_URL') ?: getenv('APP_LINK') ?: 'https://cu.ac.bd';
    $appTitle = getenv('APP_TITLE') ?: 'Chittagong University Portal';
    $appLogo = getenv('APP_LOGO') ?: 'https://cu.ac.bd/wp-content/uploads/2024/03/university-of-chittagong-seeklogo.com-removebg-preview-removebg-preview-1-60x81.png';

    if (!empty($appUrl)) {
        $apps[] = [
            'url' => $appUrl,
            'title' => $appTitle,
            'logo' => $appLogo
        ];
    }
}

$currentYear = date('Y');
?>
<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($siteTitle) ?></title>
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="logo.svg">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass-card {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(51, 65, 85, 0.6);
        }
        .glass-card:hover {
            border-color: rgba(16, 185, 129, 0.5);
            box-shadow: 0 20px 40px -15px rgba(16, 185, 129, 0.15);
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }
        .animate-float {
            animation: float 4s ease-in-out infinite;
        }
    </style>
</head>
<body class="h-full bg-gradient-to-br from-slate-950 via-slate-900 to-emerald-950 text-slate-100 flex flex-col justify-between antialiased selection:bg-emerald-500 selection:text-white">

    <!-- Header / Hero Section -->
    <main class="max-w-6xl mx-auto px-6 py-16 md:py-24 flex-grow w-full">
        <!-- Top Animated Logo & Badge -->
        <div class="flex flex-col items-center text-center">
            <div class="mb-8 animate-float filter drop-shadow-[0_0_25px_rgba(16,185,129,0.3)]">
                <img src="logo.svg" alt="CU Prototypes Logo" class="w-24 h-28 md:w-32 md:h-36 object-contain">
            </div>

            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm font-medium mb-6 shadow-lg shadow-emerald-950/50">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
                Chittagong University ICT Cell
            </div>
            
            <h1 class="text-4xl sm:text-5xl md:text-7xl font-extrabold tracking-tight text-white mb-6 max-w-4xl leading-tight">
                <?= htmlspecialchars($siteTitle) ?>
            </h1>
            
            <p class="text-lg md:text-xl text-slate-400 max-w-2xl font-light leading-relaxed mb-16">
                <?= htmlspecialchars($siteSubtitle) ?>
            </p>
        </div>

        <!-- App Link Block Section -->
        <div class="w-full max-w-5xl mx-auto">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-xl font-bold text-white flex items-center gap-3">
                    <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    Featured Application Portals
                </h2>
                <span class="text-xs font-semibold px-3 py-1 rounded-full bg-slate-800 text-slate-300 border border-slate-700"><?= count($apps) ?> Active Link<?= count($apps) === 1 ? '' : 's' ?></span>
            </div>

            <!-- Dynamic Apps Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($apps as $index => $app): 
                    $title = $app['title'] ?? 'Application Portal';
                    $url = $app['url'] ?? '#';
                    $logo = $app['logo'] ?? '';
                    $initial = strtoupper(mb_substr($title, 0, 1));
                ?>
                    <div class="glass-card rounded-2xl p-6 md:p-8 transition-all duration-300 flex flex-col justify-between group">
                        <div>
                            <div class="flex items-center gap-4 mb-6">
                                <?php if (!empty($logo)): ?>
                                    <div class="w-14 h-14 rounded-xl bg-slate-900/80 p-2.5 flex items-center justify-center border border-slate-700/80 shadow-inner flex-shrink-0">
                                        <img src="<?= htmlspecialchars($logo) ?>" alt="<?= htmlspecialchars($title) ?>" class="w-full h-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-white font-bold text-xl\'><?= $initial ?></span>'">
                                    </div>
                                <?php else: ?>
                                    <div class="w-14 h-14 rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-500 flex items-center justify-center text-white font-bold text-xl shadow-lg flex-shrink-0">
                                        <?= $initial ?>
                                    </div>
                                <?php endif; ?>
                                <div class="overflow-hidden">
                                    <span class="text-xs uppercase tracking-wider text-emerald-400 font-semibold block mb-1">App Block #<?= $index + 1 ?></span>
                                    <h3 class="text-lg md:text-xl font-bold text-white group-hover:text-emerald-300 transition-colors truncate">
                                        <?= htmlspecialchars($title) ?>
                                    </h3>
                                </div>
                            </div>
                            <p class="text-slate-400 text-sm mb-6 line-clamp-2">
                                Click below to launch the live application instance and explore features.
                            </p>
                        </div>
                        <div class="pt-4 border-t border-slate-800/80">
                            <a href="<?= htmlspecialchars($url) ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center gap-2 w-full px-5 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-semibold text-sm shadow-lg shadow-emerald-900/30 hover:shadow-emerald-500/20 transition-all duration-200">
                                <span>Open Application</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="w-full border-t border-slate-800/80 py-8 bg-slate-950/80 backdrop-blur-xl text-slate-400 text-sm">
        <div class="max-w-6xl mx-auto px-6 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-slate-400">&copy; <?= $currentYear ?> Chittagong University. All rights reserved.</p>
            <div class="flex items-center gap-3 text-xs text-slate-400 bg-slate-900/80 px-4 py-2 rounded-xl border border-slate-800">
                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>Powered by ICT Cell</span>
            </div>
        </div>
    </footer>

</body>
</html>
