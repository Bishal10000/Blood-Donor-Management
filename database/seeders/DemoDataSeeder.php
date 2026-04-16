<?php

namespace Database\Seeders;

use App\Models\BloodAvailability;
use App\Models\BloodRequest;
use App\Models\Donor;
use App\Models\DonorNotification;
use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@bloodbank.local'],
            [
                'name' => 'admin',
                'address' => 'Admin Office',
                'phone' => '9800000000',
                'blood_type' => 'O+',
                'age' => 30,
                'password' => Hash::make('admin123'),
                'user_type' => 'admin',
            ]
        );

        $donorUser = User::updateOrCreate(
            ['email' => 'donor@bloodbank.local'],
            [
                'name' => 'donor_demo',
                'address' => 'Kathmandu',
                'phone' => '9811111111',
                'blood_type' => 'A+',
                'age' => 28,
                'password' => Hash::make('demo1234'),
                'user_type' => 'donor',
            ]
        );

        $receiverUser = User::updateOrCreate(
            ['email' => 'receiver@bloodbank.local'],
            [
                'name' => 'receiver_demo',
                'address' => 'Pokhara',
                'phone' => '9822222222',
                'blood_type' => 'A+',
                'age' => 34,
                'password' => Hash::make('demo1234'),
                'user_type' => 'receiver',
            ]
        );

        $bothUser = User::updateOrCreate(
            ['email' => 'both@bloodbank.local'],
            [
                'name' => 'both_demo',
                'address' => 'Lalitpur',
                'phone' => '9833333333',
                'blood_type' => 'B+',
                'age' => 26,
                'password' => Hash::make('demo1234'),
                'user_type' => 'donor,receiver',
            ]
        );

        $donorOne = Donor::updateOrCreate(
            ['user_id' => $donorUser->id, 'email' => $donorUser->email],
            [
                'name' => 'Donor Demo',
                'phone' => '9811111111',
                'blood_group' => 'A+',
                'province' => 'Bagmati',
                'district' => 'Kathmandu',
                'is_active' => true,
            ]
        );

        $donorTwo = Donor::updateOrCreate(
            ['user_id' => $bothUser->id, 'email' => $bothUser->email],
            [
                'name' => 'Both Demo',
                'phone' => '9833333333',
                'blood_group' => 'B+',
                'province' => 'Bagmati',
                'district' => 'Lalitpur',
                'is_active' => true,
            ]
        );

        BloodAvailability::updateOrCreate(
            ['district' => 'Kathmandu', 'blood_group' => 'A+', 'contact' => '015000001'],
            [
                'health_post' => 'City Blood Center',
                'province' => 'Bagmati',
                'municipality' => 'Kathmandu Metropolitan',
                'address' => 'Putalisadak, Kathmandu',
                'available_units' => 12,
            ]
        );

        $pendingRequest = BloodRequest::updateOrCreate(
            ['user_id' => $receiverUser->id, 'name' => 'Receiver Demo', 'status' => 'pending'],
            [
                'email' => $receiverUser->email,
                'phone' => '9822222222',
                'blood_group' => 'A+',
                'province' => 'Bagmati',
                'district' => 'Kathmandu',
                'note' => 'Emergency case for surgery.',
                'requested_at' => now()->subHours(2),
            ]
        );

        BloodRequest::updateOrCreate(
            ['user_id' => $bothUser->id, 'name' => 'Both Demo Request', 'status' => 'approved'],
            [
                'email' => $bothUser->email,
                'phone' => '9833333333',
                'blood_group' => 'B+',
                'province' => 'Bagmati',
                'district' => 'Lalitpur',
                'note' => 'Approved sample request.',
                'requested_at' => now()->subDay(),
            ]
        );

        UserNotification::updateOrCreate(
            ['user_id' => $receiverUser->id, 'message' => 'Your request is currently under review.'],
            [
                'user_email' => $receiverUser->email,
                'status' => 'unread',
            ]
        );

        UserNotification::updateOrCreate(
            ['user_id' => $receiverUser->id, 'message' => 'Potential donors found near Kathmandu.'],
            [
                'user_email' => $receiverUser->email,
                'status' => 'read',
            ]
        );

        DonorNotification::updateOrCreate(
            ['donor_id' => $donorOne->id, 'message' => 'Potential blood receivers found for your donation (A+).'],
            [
                'donor_email' => $donorOne->email,
                'status' => 'unread',
            ]
        );

        DonorNotification::updateOrCreate(
            ['donor_id' => $donorTwo->id, 'message' => 'No local requests found, but potential receivers are available nearby.'],
            [
                'donor_email' => $donorTwo->email,
                'status' => 'read',
            ]
        );

        // Keep a linked pending request for admin approve/reject demo.
        $pendingRequest->refresh();
        $admin->refresh();
    }
}
