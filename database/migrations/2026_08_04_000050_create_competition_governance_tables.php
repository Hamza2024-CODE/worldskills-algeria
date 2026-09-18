<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. CIS Evaluation Tables
        Schema::create('competition_assessment_modules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('skill_id')->constrained('skills')->cascadeOnDelete();
            $table->foreignId('edition_id')->nullable()->constrained('editions')->nullOnDelete();
            $table->string('code')->nullable(); // Module A, Module B
            $table->string('title_ar');
            $table->string('title_fr');
            $table->string('title_en')->nullable();
            $table->decimal('max_score', 8, 2)->default(100.00);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('competition_assessment_criteria', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->constrained('competition_assessment_modules')->cascadeOnDelete();
            $table->string('title_ar');
            $table->string('title_fr');
            $table->enum('type', ['JUDGEMENT', 'MEASUREMENT'])->default('MEASUREMENT');
            $table->decimal('max_score', 8, 2)->default(10.00);
            $table->text('description')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('participant_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->constrained('registrations')->cascadeOnDelete();
            $table->foreignId('module_id')->constrained('competition_assessment_modules')->cascadeOnDelete();
            $table->decimal('total_score', 8, 2)->default(0.00);
            $table->boolean('is_locked')->default(false);
            $table->timestamp('locked_at')->nullable();
            $table->foreignId('locked_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('participant_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->constrained('participant_assessments')->cascadeOnDelete();
            $table->foreignId('criterion_id')->constrained('competition_assessment_criteria')->cascadeOnDelete();
            $table->foreignId('judge_user_id')->constrained('users')->cascadeOnDelete();
            $table->decimal('score', 8, 2)->default(0.00);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('score_moderations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->constrained('participant_assessments')->cascadeOnDelete();
            $table->foreignId('chief_expert_user_id')->constrained('users')->cascadeOnDelete();
            $table->decimal('previous_score', 8, 2);
            $table->decimal('adjusted_score', 8, 2);
            $table->text('reason');
            $table->timestamps();
        });

        Schema::create('competition_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->constrained('registrations')->cascadeOnDelete();
            $table->foreignId('skill_id')->constrained('skills')->cascadeOnDelete();
            $table->decimal('final_score', 8, 2)->default(0.00);
            $table->integer('rank')->nullable();
            $table->enum('award', ['GOLD', 'SILVER', 'BRONZE', 'MEDALLION_FOR_EXCELLENCE', 'NONE'])->default('NONE');
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        // 2. Certificates Table
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->uuid('certificate_uuid')->unique();
            $table->string('verification_token_hash')->unique();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('registration_id')->nullable()->constrained('registrations')->nullOnDelete();
            $table->foreignId('skill_id')->nullable()->constrained('skills')->nullOnDelete();
            $table->enum('certificate_type', ['PARTICIPATION', 'WINNER_GOLD', 'WINNER_SILVER', 'WINNER_BRONZE', 'MEDALLION_EXCELLENCE', 'EXPERT_JUDGE', 'DELEGATION_OFFICIAL'])->default('PARTICIPATION');
            $table->enum('status', ['VALID', 'REVOKED', 'EXPIRED'])->default('VALID');
            $table->timestamp('issued_at')->useCurrent();
            $table->timestamp('revoked_at')->nullable();
            $table->text('revocation_reason')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
        });

        // 3. Accreditation & Dynamic Zones
        Schema::create('accreditation_zones', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // ZONE_1_WORKSHOP, ZONE_2_CATERING, ZONE_3_VIP
            $table->string('name_ar');
            $table->string('name_fr');
            $table->string('color_hex')->default('#0066FF');
            $table->timestamps();
        });

        Schema::create('badges', function (Blueprint $table) {
            $table->id();
            $table->uuid('badge_uuid')->unique();
            $table->string('access_token')->unique();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('role_title')->default('PARTICIPANT');
            $table->json('allowed_zone_ids')->nullable();
            $table->enum('status', ['ACTIVE', 'EXPIRED', 'BLOCKED'])->default('ACTIVE');
            $table->timestamp('valid_until')->nullable();
            $table->timestamps();
        });

        // 4. System Notifications Bus Table
        Schema::create('app_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('type'); // SCORE_LOCKED, REGISTRATION_APPROVED, etc.
            $table->string('title_ar');
            $table->text('message_ar');
            $table->string('action_url')->nullable();
            $table->enum('severity', ['INFO', 'SUCCESS', 'WARNING', 'DANGER'])->default('INFO');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });

        // 5. Live TV Settings & Slides
        Schema::create('live_tv_slides', function (Blueprint $table) {
            $table->id();
            $table->string('title_ar');
            $table->string('title_fr')->nullable();
            $table->enum('slide_type', ['LEADERBOARD', 'MEDAL_TALLY', 'COUNTDOWN', 'ANNOUNCEMENT', 'SPONSOR'])->default('ANNOUNCEMENT');
            $table->text('content')->nullable();
            $table->string('image_url')->nullable();
            $table->integer('display_duration_sec')->default(10);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('live_tv_announcements', function (Blueprint $table) {
            $table->id();
            $table->string('ticker_text_ar');
            $table->string('ticker_text_fr')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 6. Technical Appeals Governance Tables
        Schema::create('technical_appeals', function (Blueprint $table) {
            $table->id();
            $table->uuid('appeal_uuid')->unique();
            $table->foreignId('skill_id')->constrained('skills')->cascadeOnDelete();
            $table->foreignId('submitted_by_user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('participant_registration_id')->nullable()->constrained('registrations')->nullOnDelete();
            $table->string('subject');
            $table->text('description');
            $table->enum('status', ['SUBMITTED', 'ELIGIBILITY_CHECK', 'UNDER_REVIEW', 'HEARING', 'DECISION_PENDING', 'UPHELD', 'REJECTED', 'PARTIALLY_UPHELD', 'CLOSED'])->default('SUBMITTED');
            $table->enum('priority', ['NORMAL', 'HIGH', 'URGENT'])->default('NORMAL');
            $table->timestamp('submitted_at')->useCurrent();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamp('decided_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('technical_appeal_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appeal_id')->constrained('technical_appeals')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('event_type'); // STATUS_CHANGE, COMMENT, EVIDENCE_ADDED
            $table->text('event_details');
            $table->timestamps();
        });

        Schema::create('technical_appeal_decisions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appeal_id')->constrained('technical_appeals')->cascadeOnDelete();
            $table->foreignId('decided_by_user_id')->constrained('users')->cascadeOnDelete();
            $table->enum('decision', ['UPHELD', 'REJECTED', 'PARTIALLY_UPHELD']);
            $table->text('reasoning');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('technical_appeal_decisions');
        Schema::dropIfExists('technical_appeal_events');
        Schema::dropIfExists('technical_appeals');
        Schema::dropIfExists('live_tv_announcements');
        Schema::dropIfExists('live_tv_slides');
        Schema::dropIfExists('app_notifications');
        Schema::dropIfExists('badges');
        Schema::dropIfExists('accreditation_zones');
        Schema::dropIfExists('certificates');
        Schema::dropIfExists('competition_results');
        Schema::dropIfExists('score_moderations');
        Schema::dropIfExists('participant_scores');
        Schema::dropIfExists('participant_assessments');
        Schema::dropIfExists('competition_assessment_criteria');
        Schema::dropIfExists('competition_assessment_modules');
    }
};
