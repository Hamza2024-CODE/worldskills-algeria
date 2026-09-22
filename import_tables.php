<?php
require "vendor/autoload.php";
$app = require_once "bootstrap/app.php";
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$cfg = config('database.connections.mysql');
$sqlFile = "/home/hamza-boubakar-seddike/htdocs/worldskills.dz/scratch_legacy_tables.sql";

echo "Starting import of {$sqlFile} into {$cfg['database']} on {$cfg['host']}...\n";

$cmd = sprintf(
    "/opt/lampp/bin/mysql --default-character-set=utf8mb4 -h %s -P %s -u %s -p%s %s < %s 2>&1",
    escapeshellarg($cfg['host']),
    escapeshellarg($cfg['port']),
    escapeshellarg($cfg['username']),
    escapeshellarg($cfg['password']),
    escapeshellarg($cfg['database']),
    escapeshellarg($sqlFile)
);

$startTime = microtime(true);
exec($cmd, $output, $returnCode);
$elapsed = round(microtime(true) - $startTime, 2);

echo "Import finished in {$elapsed} seconds with exit code: {$returnCode}\n";
if (!empty($output)) {
    echo "Output / Messages:\n" . implode("\n", array_slice($output, 0, 25)) . "\n";
}
