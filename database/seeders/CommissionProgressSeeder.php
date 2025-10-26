<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CommissionProgressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        
        // Get all commissions with their statuses
        $commissions = DB::table('commisions')->get();
        
        // Global progress ID counter
        $progressId = 1;
        
        foreach ($commissions as $commission) {
            
            // Add progress images based on commission status
            switch ($commission->progress_status) {
                case 'in_progress_sketch':
                    // Commission is in sketch phase - add 1-2 sketch images
                    for ($i = 0; $i < rand(1, 2); $i++) {
                        DB::table('commission_progress')->insert([
                            'com_progress_id' => $progressId++,
                            'commission_id' => $commission->commission_id,
                            'image_link' => 'commissions/' . $commission->commission_id . '/sketch_' . ($i + 1) . '.jpg',
                            'stage' => 'sketch',
                            'description' => 'Initial sketch progress - ' . $faker->sentence,
                            'created_at' => $faker->dateTimeBetween($commission->started_at ?? '-1 week', 'now'),
                            'updated_at' => now(),
                        ]);
                    }
                    break;
                    
                case 'review':
                    // Commission under review - has sketch images submitted
                    DB::table('commission_progress')->insert([
                        'com_progress_id' => $progressId++,
                        'commission_id' => $commission->commission_id,
                        'image_link' => 'commissions/' . $commission->commission_id . '/sketch_final.jpg',
                        'stage' => 'sketch',
                        'description' => 'Sketch completed and submitted for review',
                        'created_at' => $faker->dateTimeBetween($commission->started_at ?? '-1 week', 'now'),
                        'updated_at' => now(),
                    ]);
                    break;
                    
                case 'revision':
                    // Commission in revision - has original sketch + revision request
                    DB::table('commission_progress')->insert([
                        'com_progress_id' => $progressId++,
                        'commission_id' => $commission->commission_id,
                        'image_link' => 'commissions/' . $commission->commission_id . '/sketch_v1.jpg',
                        'stage' => 'sketch',
                        'description' => 'Initial sketch',
                        'created_at' => $faker->dateTimeBetween($commission->started_at ?? '-2 weeks', '-1 week'),
                        'updated_at' => now(),
                    ]);
                    // Add a revision image
                    DB::table('commission_progress')->insert([
                        'com_progress_id' => $progressId++,
                        'commission_id' => $commission->commission_id,
                        'image_link' => 'commissions/' . $commission->commission_id . '/sketch_revision.jpg',
                        'stage' => 'sketch_revision',
                        'description' => 'Revised based on customer feedback: ' . $faker->sentence,
                        'created_at' => $faker->dateTimeBetween('-3 days', 'now'),
                        'updated_at' => now(),
                    ]);
                    break;
                    
                case 'in_progress_coloring':
                    // Has approved sketch + coloring progress
                    DB::table('commission_progress')->insert([
                        'com_progress_id' => $progressId++,
                        'commission_id' => $commission->commission_id,
                        'image_link' => 'commissions/' . $commission->commission_id . '/sketch_approved.jpg',
                        'stage' => 'sketch',
                        'description' => 'Approved sketch',
                        'created_at' => $faker->dateTimeBetween($commission->started_at ?? '-2 weeks', '-1 week'),
                        'updated_at' => now(),
                    ]);
                    // Add coloring progress images
                    for ($i = 0; $i < rand(1, 3); $i++) {
                        DB::table('commission_progress')->insert([
                            'com_progress_id' => $progressId++,
                            'commission_id' => $commission->commission_id,
                            'image_link' => 'commissions/' . $commission->commission_id . '/coloring_' . ($i + 1) . '.jpg',
                            'stage' => 'coloring',
                            'description' => 'Coloring progress - ' . $faker->sentence,
                            'created_at' => $faker->dateTimeBetween('-1 week', 'now'),
                            'updated_at' => now(),
                        ]);
                    }
                    break;
                    
                case 'completed':
                    // Full progression: sketch -> coloring -> final
                    DB::table('commission_progress')->insert([
                        'com_progress_id' => $progressId++,
                        'commission_id' => $commission->commission_id,
                        'image_link' => 'commissions/' . $commission->commission_id . '/sketch.jpg',
                        'stage' => 'sketch',
                        'description' => 'Initial sketch',
                        'created_at' => $faker->dateTimeBetween($commission->started_at ?? '-2 months', '-1 month'),
                        'updated_at' => now(),
                    ]);
                    DB::table('commission_progress')->insert([
                        'com_progress_id' => $progressId++,
                        'commission_id' => $commission->commission_id,
                        'image_link' => 'commissions/' . $commission->commission_id . '/coloring.jpg',
                        'stage' => 'coloring',
                        'description' => 'Coloring phase',
                        'created_at' => $faker->dateTimeBetween('-1 month', '-2 weeks'),
                        'updated_at' => now(),
                    ]);
                    DB::table('commission_progress')->insert([
                        'com_progress_id' => $progressId++,
                        'commission_id' => $commission->commission_id,
                        'image_link' => 'commissions/' . $commission->commission_id . '/final.jpg',
                        'stage' => 'final',
                        'description' => 'Final completed artwork',
                        'created_at' => $faker->dateTimeBetween('-2 weeks', $commission->completed_at ?? 'now'),
                        'updated_at' => now(),
                    ]);
                    break;
                    
                case 'cancelled':
                    // May have some initial progress before cancellation
                    if (rand(0, 1)) {
                        DB::table('commission_progress')->insert([
                            'com_progress_id' => $progressId++,
                            'commission_id' => $commission->commission_id,
                            'image_link' => 'commissions/' . $commission->commission_id . '/sketch_partial.jpg',
                            'stage' => 'sketch',
                            'description' => 'Work in progress before cancellation',
                            'created_at' => $faker->dateTimeBetween($commission->started_at ?? '-1 month', '-1 week'),
                            'updated_at' => now(),
                        ]);
                    }
                    break;
                    
                // pending and accepted have no progress images yet
                default:
                    break;
            }
        }
    }
}
