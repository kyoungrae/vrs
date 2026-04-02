<?php
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = \App\MainUser::where('USERNAME','admin')->first(['USERNAME','ISACTIVE','PASSWORD','ID']);
echo "User: " . ($user ? $user->USERNAME : 'null') . PHP_EOL;
echo "IsActive: " . ($user ? $user->IsActive : 'null') . PHP_EOL;
echo "ID: " . ($user ? $user->ID : 'null') . PHP_EOL;
