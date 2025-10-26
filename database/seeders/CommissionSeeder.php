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
                'status_notes' => null,
                'cancellation_reason' => null,
                'count' => 3
            ],
            // Scenario 2: Accepted, waiting for DP payment
            [
                'progress_status' => 'accepted',
                'payment_status' => 'pending',
                'started_at' => null,
                'completed_at' => null,
                'status_notes' => 'Commission accepted. Please proceed with down payment.',
                'cancellation_reason' => null,
                'count' => 2
            ],
            // Scenario 3: DP paid, artist working on sketch
            [
                'progress_status' => 'in_progress_sketch',
                'payment_status' => 'dp',
                'started_at' => $faker->dateTimeBetween('-1 week', '-1 day'),
                'completed_at' => null,
                'status_notes' => 'Working on initial sketch',
                'cancellation_reason' => null,
                'count' => 4
            ],
            // Scenario 4: Sketch under review
            [
                'progress_status' => 'review',
                'payment_status' => 'dp',
                'started_at' => $faker->dateTimeBetween('-2 weeks', '-1 week'),
                'completed_at' => null,
                'status_notes' => 'Sketch submitted for review',
                'cancellation_reason' => null,
                'count' => 2
            ],
            // Scenario 5: In revision (customer requested changes)
            [
                'progress_status' => 'revision',
                'payment_status' => 'dp',
                'started_at' => $faker->dateTimeBetween('-3 weeks', '-2 weeks'),
                'completed_at' => null,
                'status_notes' => 'Customer requested changes to the sketch',
                'cancellation_reason' => null,
                'count' => 2
            ],
            // Scenario 6: Coloring in progress (sketch approved)
            [
                'progress_status' => 'in_progress_coloring',
                'payment_status' => 'dp',
                'started_at' => $faker->dateTimeBetween('-3 weeks', '-2 weeks'),
                'completed_at' => null,
                'status_notes' => 'Sketch approved, now coloring',
                'cancellation_reason' => null,
                'count' => 3
            ],
            // Scenario 7: Completed and fully paid
            [
                'progress_status' => 'completed',
                'payment_status' => 'paid',
                'started_at' => $faker->dateTimeBetween('-2 months', '-1 month'),
                'completed_at' => $faker->dateTimeBetween('-1 week', 'now'),
                'status_notes' => 'Commission completed successfully',
                'cancellation_reason' => null,
                'count' => 3
            ],
            // Scenario 8: Cancelled by customer
            [
                'progress_status' => 'cancelled',
                'payment_status' => 'refunded',
                'started_at' => $faker->dateTimeBetween('-1 month', '-2 weeks'),
                'completed_at' => null,
                'status_notes' => null,
                'cancellation_reason' => 'Customer changed their mind',
                'count' => 1
            ],
        ];

        $commissionId = 1;
        
        foreach ($scenarios as $scenario) {
            for ($i = 0; $i < $scenario['count']; $i++) {
                $createdAt = $faker->dateTimeBetween('-2 months', '-1 day');
                
                DB::table('commisions')->insert([
                    'commission_id' => $commissionId,
                    'member_id' => $faker->randomElement($clientIds),
                    'category' => $faker->randomElement(['Fullbody', 'Headshot', 'Halfbody', 'Chibi', 'Custom']),
                    'description' => $faker->paragraph,
                    'deadline' => $faker->dateTimeBetween('+1 week', '+3 months'),
                    'price' => $faker->randomFloat(2, 100, 500),
                    'payment_status' => $scenario['payment_status'],
                    'progress_status' => $scenario['progress_status'],
                    'status_notes' => $scenario['status_notes'],
                    'cancellation_reason' => $scenario['cancellation_reason'],
                    'started_at' => $scenario['started_at'],
                    'completed_at' => $scenario['completed_at'],
                    'created_at' => $createdAt,
                    'updated_at' => now(),
                ]);
                
                $commissionId++;
            }
        }
    }
}
