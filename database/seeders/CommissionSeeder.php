<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CommissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        
        // Get client and artist IDs
        $clientIds = DB::table('members')->where('role', 'client')->pluck('member_id');
        $artistId = DB::table('members')->where('role', 'artist')->first()->member_id;

        // Define realistic commission scenarios
        $scenarios = [
            // Scenario 1: New pending commissions (just submitted)
            [
                'progress_status' => 'pending',
                'payment_status' => 'pending',
                'started_at' => null,
                'completed_at' => null,
                'fully_paid_at' => null,
                'cancellation_reason' => null,
                'count' => 3
            ],
            // Scenario 2: Accepted, waiting for DP payment
            [
                'progress_status' => 'accepted',
                'payment_status' => 'pending',
                'started_at' => null,
                'completed_at' => null,
                'fully_paid_at' => null,
                'cancellation_reason' => null,
                'count' => 2
            ],
            // Scenario 3: DP paid, artist working on sketch
            [
                'progress_status' => 'in_progress_sketch',
                'payment_status' => 'dp',
                'started_at' => '-1 week to -1 day',
                'completed_at' => null,
                'fully_paid_at' => null,
                'cancellation_reason' => null,
                'count' => 4
            ],
            // Scenario 4: Sketch under review
            [
                'progress_status' => 'review',
                'payment_status' => 'dp',
                'started_at' => '-2 weeks to -1 week',
                'completed_at' => null,
                'fully_paid_at' => null,
                'cancellation_reason' => null,
                'count' => 2
            ],
            // Scenario 5: In revision (customer requested changes)
            [
                'progress_status' => 'revision',
                'payment_status' => 'dp',
                'started_at' => '-3 weeks to -2 weeks',
                'completed_at' => null,
                'fully_paid_at' => null,
                'cancellation_reason' => null,
                'count' => 2
            ],
            // Scenario 6: Coloring in progress (sketch approved)
            [
                'progress_status' => 'in_progress_coloring',
                'payment_status' => 'dp',
                'started_at' => '-3 weeks to -2 weeks',
                'completed_at' => null,
                'fully_paid_at' => null,
                'cancellation_reason' => null,
                'count' => 3
            ],
            // Scenario 7: Completed and fully paid
            [
                'progress_status' => 'completed',
                'payment_status' => 'paid',
                'started_at' => '-2 months to -1 month',
                'completed_at' => '-2 weeks to -1 week',
                'fully_paid_at' => '-1 week to -1 day',
                'cancellation_reason' => null,
                'count' => 2
            ],
            // Scenario 8: Completed but awaiting full payment
            [
                'progress_status' => 'completed',
                'payment_status' => 'dp',
                'started_at' => '-1 month to -2 weeks',
                'completed_at' => '-1 week to -1 day',
                'fully_paid_at' => null,
                'cancellation_reason' => null,
                'count' => 2
            ],
            // Scenario 9: Cancelled by customer
            [
                'progress_status' => 'cancelled',
                'payment_status' => 'refunded',
                'started_at' => '-1 month to -2 weeks',
                'completed_at' => null,
                'fully_paid_at' => null,
                'cancellation_reason' => 'Customer changed their mind',
                'count' => 1
            ],
        ];

        $commissionId = 1;
        // Sample reference images (external placeholders or your local assets)
        $sampleImages = [
            'https://picsum.photos/seed/comm1/800/600',
            'https://picsum.photos/seed/comm2/800/600',
            'https://picsum.photos/seed/comm3/800/600',
            'https://picsum.photos/seed/comm4/800/600',
            'https://picsum.photos/seed/comm5/800/600',
            '/assets/comm_sample/sample1.jpg',
            '/assets/comm_sample/sample2.jpg',
        ];
        
        foreach ($scenarios as $scenario) {
            for ($i = 0; $i < $scenario['count']; $i++) {
                $createdAt = $faker->dateTimeBetween('-2 months', '-1 day');
                
                // Generate dates based on scenario
                $startedAt = null;
                $completedAt = null;
                $fullyPaidAt = null;
                
                if ($scenario['started_at']) {
                    list($start, $end) = explode(' to ', $scenario['started_at']);
                    $startedAt = $faker->dateTimeBetween($start, $end);
                }
                
                if ($scenario['completed_at']) {
                    list($start, $end) = explode(' to ', $scenario['completed_at']);
                    $completedAt = $faker->dateTimeBetween($start, $end);
                }
                
                if ($scenario['fully_paid_at']) {
                    list($start, $end) = explode(' to ', $scenario['fully_paid_at']);
                    $fullyPaidAt = $faker->dateTimeBetween($start, $end);
                }
                
                DB::table('commissions')->insert([
                    'commission_id' => $commissionId,
                    'member_id' => $faker->randomElement($clientIds),
                    'category' => $faker->randomElement(['Fullbody', 'Headshot', 'Halfbody', 'Chibi', 'Custom']),
                    'description' => $faker->paragraph,
                    // 70% chance to include a reference image
                    'reference_image' => (rand(0, 9) < 7) ? $faker->randomElement($sampleImages) : null,
                    'deadline' => $faker->dateTimeBetween('+1 week', '+3 months'),
                    'price' => $faker->numberBetween(50000, 500000), // Rp 50.000 - Rp 500.000
                    'payment_status' => $scenario['payment_status'],
                    'progress_status' => $scenario['progress_status'],
                    'cancellation_reason' => $scenario['cancellation_reason'],
                    'started_at' => $startedAt,
                    'completed_at' => $completedAt,
                    'fully_paid_at' => $fullyPaidAt,
                    'created_at' => $createdAt,
                    'updated_at' => now(),
                ]);
                
                $commissionId++;
            }
        }
    }
}
