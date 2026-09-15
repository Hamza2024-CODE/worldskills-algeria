<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\Country;
use App\Models\CountryDelegation;
use App\Models\CountrySkillSelection;
use App\Models\DelegationMember;
use App\Models\Edition;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            GeographySeeder::class,
            SkillsAndEquipmentSeeder::class,
            CmsAndMediaSeeder::class,
            LogisticsAndReadinessSeeder::class,
            CisAssessmentModulesSeeder::class,
        ]);

        // Create Super Admin User
        $superAdmin = User::updateOrCreate(
            ['email' => 'admin@worldskills.dz'],
            [
                'uuid' => (string) Str::uuid(),
                'name' => 'Super Administrator',
                'password' => Hash::make('password123'),
                'is_active' => true,
            ]
        );
        $superAdmin->assignRole(RoleEnum::SUPER_ADMIN->value);

        // Create Media Manager User
        $mediaAdmin = User::updateOrCreate(
            ['email' => 'media@worldskills.dz'],
            [
                'uuid' => (string) Str::uuid(),
                'name' => 'مسؤول الفريق الإعلامي',
                'password' => Hash::make('password123'),
                'is_active' => true,
            ]
        );
        $mediaAdmin->assignRole(RoleEnum::MEDIA_MANAGER->value);

        // Create Executive Viewer User (Minister / High Official Read-Only)
        $execViewer = User::updateOrCreate(
            ['email' => 'viewer@worldskills.dz'],
            [
                'uuid' => (string) Str::uuid(),
                'name' => 'المراقب التنفيذي الوزاري',
                'password' => Hash::make('password123'),
                'is_active' => true,
            ]
        );
        $execViewer->assignRole(RoleEnum::EXECUTIVE_VIEWER->value);

        // Create Default Active Edition 2026
        $edition = Edition::updateOrCreate(
            ['year' => 2026],
            [
                'uuid' => (string) Str::uuid(),
                'name_ar' => 'أولمبياد المهن الجزائر 2026',
                'name_fr' => 'WorldSkills Algeria 2026',
                'name_en' => 'WorldSkills Algeria 2026',
                'is_active' => true,
                'status' => 'ACTIVE',
            ]
        );

        // Algeria Country & Admin
        $algeria = Country::where('iso2', 'DZ')->first();
        if ($algeria) {
            $algeriaAdmin = User::updateOrCreate(
                ['email' => 'dz.admin@worldskills.dz'],
                [
                    'uuid' => (string) Str::uuid(),
                    'name' => 'مسؤول الوفد الجزائري',
                    'password' => Hash::make('password123'),
                    'country_id' => $algeria->id,
                    'is_active' => true,
                ]
            );
            $algeriaAdmin->assignRole(RoleEnum::COUNTRY_ADMIN->value);

            // Seed Skill Selections for Algeria
            $skills = Skill::limit(5)->get();
            foreach ($skills as $index => $skill) {
                CountrySkillSelection::updateOrCreate(
                    ['edition_id' => $edition->id, 'country_id' => $algeria->id, 'skill_id' => $skill->id],
                    [
                        'status' => $index % 2 === 0 ? 'APPROVED' : 'REQUESTED',
                        'requested_at' => now(),
                    ]
                );
            }

            // Seed Delegation Members for Algeria
            $delegation = CountryDelegation::updateOrCreate(
                ['edition_id' => $edition->id, 'country_id' => $algeria->id],
                ['head_of_delegation_user_id' => $algeriaAdmin->id, 'total_members_count' => 3, 'status' => 'ACTIVE']
            );

            DelegationMember::updateOrCreate(
                ['delegation_id' => $delegation->id, 'first_name' => 'أحمد', 'last_name' => 'بن علي'],
                [
                    'uuid' => (string) Str::uuid(),
                    'member_type' => 'PARTICIPANT',
                    'email' => 'ahmed.benali@mfep.gov.dz',
                    'phone' => '+213 555 123 456',
                    'passport_number' => '123456789',
                    'gender' => 'male',
                ]
            );

            DelegationMember::updateOrCreate(
                ['delegation_id' => $delegation->id, 'first_name' => 'ياسين', 'last_name' => 'قادري'],
                [
                    'uuid' => (string) Str::uuid(),
                    'member_type' => 'EXPERT',
                    'email' => 'yassine.kadri@mfep.gov.dz',
                    'phone' => '+213 661 987 654',
                    'passport_number' => '987654321',
                    'gender' => 'male',
                ]
            );
        }
    }
}
