<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Booking;
use App\Models\Notification;
use Illuminate\Support\Facades\Hash;

class BookingSystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        // Create regular users
        $users = [
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Bob Johnson',
                'email' => 'bob@example.com',
                'password' => Hash::make('password'),
            ],
        ];

        foreach ($users as $userData) {
            $user = User::create($userData);
            
            // Create some bookings for each user
            $bookingTitles = [
                'Business Meeting',
                'Vacation Trip',
                'Conference Attendance',
                'Team Building Event',
                'Client Presentation',
            ];

            $descriptions = [
                'Important business meeting with stakeholders',
                'Family vacation to the beach',
                'Annual industry conference',
                'Team building workshop',
                'Client presentation and demo',
            ];

            for ($i = 0; $i < rand(1, 3); $i++) {
                $checkInDate = now()->addDays(rand(1, 30));
                $checkOutDate = $checkInDate->copy()->addDays(rand(1, 7));
                
                $booking = Booking::create([
                    'user_id' => $user->id,
                    'title' => $bookingTitles[array_rand($bookingTitles)],
                    'description' => $descriptions[array_rand($descriptions)],
                    'check_in_date' => $checkInDate,
                    'check_in_time' => '09:00',
                    'check_out_date' => $checkOutDate,
                    'check_out_time' => '17:00',
                    'status' => ['pending', 'confirmed', 'cancelled'][array_rand(['pending', 'confirmed', 'cancelled'])],
                ]);

                // Create notifications for bookings
                $user->notifications()->create([
                    'data' => [
                        'booking_id' => $booking->id,
                        'title' => 'Booking Created',
                        'message' => "Your booking '{$booking->title}' has been created successfully.",
                        'type' => 'booking_created',
                    ],
                ]);

                // Create admin notification
                $admin->notifications()->create([
                    'data' => [
                        'booking_id' => $booking->id,
                        'title' => 'New Booking',
                        'message' => "User {$user->name} has created a new booking: {$booking->title}",
                        'type' => 'admin_notification',
                    ],
                ]);
            }
        }

        // Create some additional notifications
        $admin->notifications()->create([
            'data' => [
                'title' => 'System Welcome',
                'message' => 'Welcome to the booking system! You can manage all bookings and users from the admin panel.',
                'type' => 'admin_notification',
            ],
        ]);

        $this->command->info('Booking system seeded successfully!');
        $this->command->info('Admin credentials: admin@example.com / password');
        $this->command->info('User credentials: john@example.com / password');
    }
}
