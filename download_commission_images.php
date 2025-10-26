<?php

/**
 * Script to download placeholder commission images
 * Run this after seeding the database to populate images
 * 
 * Usage: php download_commission_images.php
 */

require __DIR__ . '/vendor/autoload.php';

use Illuminate\Support\Facades\DB;

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Placeholder image service - using picsum.photos for random art-like images
$imageService = 'https://picsum.photos/800/600'; // Random images
// Alternative: 'https://loremflickr.com/800/600/art,sketch' for art-themed

$publicPath = __DIR__ . '/public';
$commissionsPath = $publicPath . '/commissions';

// Create main commissions directory if not exists
if (!file_exists($commissionsPath)) {
    mkdir($commissionsPath, 0755, true);
    echo "✓ Created commissions directory\n";
}

// Get all commission progress entries
$progressEntries = DB::table('commission_progress')->get();

echo "Found " . count($progressEntries) . " progress images to download\n\n";

$downloadCount = 0;
$skipCount = 0;

foreach ($progressEntries as $progress) {
    $imagePath = $publicPath . '/' . $progress->image_link;
    $directory = dirname($imagePath);
    
    // Create directory if not exists
    if (!file_exists($directory)) {
        mkdir($directory, 0755, true);
        echo "✓ Created directory: " . basename(dirname($directory)) . "/" . basename($directory) . "\n";
    }
    
    // Skip if file already exists
    if (file_exists($imagePath)) {
        echo "- Skipped (exists): {$progress->image_link}\n";
        $skipCount++;
        continue;
    }
    
    // Download image with some variety based on stage
    $seed = $progress->com_progress_id; // Use progress ID as seed for consistent images
    $imageUrl = "https://picsum.photos/seed/{$seed}/800/600";
    
    // Add stage-specific variations
    switch ($progress->stage) {
        case 'sketch':
        case 'sketch_revision':
            // Grayscale for sketches
            $imageUrl = "https://picsum.photos/seed/{$seed}/800/600?grayscale";
            break;
        case 'coloring':
        case 'coloring_revision':
            // Blur effect for work in progress
            $imageUrl = "https://picsum.photos/seed/{$seed}/800/600?blur=1";
            break;
        case 'final':
            // Full color, sharp
            $imageUrl = "https://picsum.photos/seed/{$seed}/800/600";
            break;
    }
    
    // Download the image
    try {
        $imageData = @file_get_contents($imageUrl);
        
        if ($imageData === false) {
            echo "✗ Failed to download: {$progress->image_link}\n";
            continue;
        }
        
        file_put_contents($imagePath, $imageData);
        echo "✓ Downloaded: {$progress->image_link}\n";
        $downloadCount++;
        
        // Small delay to avoid rate limiting
        usleep(200000); // 0.2 seconds
        
    } catch (Exception $e) {
        echo "✗ Error downloading {$progress->image_link}: " . $e->getMessage() . "\n";
    }
}

echo "\n";
echo "========================================\n";
echo "Download Summary:\n";
echo "========================================\n";
echo "Total entries: " . count($progressEntries) . "\n";
echo "Downloaded: {$downloadCount}\n";
echo "Skipped (already exists): {$skipCount}\n";
echo "Failed: " . (count($progressEntries) - $downloadCount - $skipCount) . "\n";
echo "========================================\n";
echo "\nImages saved to: public/commissions/\n";
