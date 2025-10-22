<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('ministries', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('abbreviation')->nullable();
            $table->string('category')->nullable();
            $table->string('theme')->nullable();
            $table->string('location')->nullable();
            $table->text('mission_statement')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

            Schema::create('sabbath_schools', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('code')->nullable();
            $table->string('division')->nullable();
            $table->text('description')->nullable();
            $table->string('meeting_location')->nullable();
            $table->string('meeting_time')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
         Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('phone_number')->unique();
            $table->string('email')->nullable();
            $table->string('membership_number')->nullable();
            $table->date('dob')->nullable();
            $table->enum('gender', ['Male', 'Female'])->nullable();
            $table->enum('membership_status', ['Active', 'Guest', 'Inactive'])->default('Active');
            $table->enum('baptism_status' ,['Active',  'Inactive'])->default('Active');
            $table->string('pin')->nullable();
            $table->string('pin_fail_count')->nullable();
             $table->enum('pin_status' ,['Active', 'Pending', 'Inactive'])->default('Active');
            $table->date('baptism_date')->nullable();
            $table->string('marital_status')->nullable();
            $table->text('address')->nullable();
            $table->string('photo')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('contribution_types', function (Blueprint $table) {
            $table->id();
            $table->string('contribution_name');
            $table->integer('church_percentage');
            $table->integer('conference_percentage');
            $table->string('description')->nullable();
            $table->timestamps();
        });

          Schema::create('stewardships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->nullable()->constrained('members')->onDelete('set null');
            $table->enum('payment_method', [
                'Cash',
                'Bank',
                'Mobile Money',
                'Cheque',
                'Other'
            ])->default('Cash');
            $table->string('transaction_reference')->nullable();
            $table->string('receipt_number')->nullable()->unique();
            $table->string('attachment_image_url')->nullable();
            $table->string('total_amount')->nullable();
            $table->string('description')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('recorded_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
           });

        Schema::create('transactions', function (Blueprint $table) {

            $table->id();
            $table->decimal('amount');
            $table->foreignId('stewardships_id')->nullable()->constrained('stewardships')->onDelete('cascade');
            $table->foreignId('contribution_type_id')->nullable()->constrained('contribution_types')->onDelete('cascade');

              $table->timestamps();

        });



         Schema::create('incomes', function (Blueprint $table) {
            $table->id();
            $table->string('description')->nullable();
            $table->string('source_name')->nullable();
            $table->string('source_contact')->nullable();
            $table->decimal('amount', 12, 2);
            $table->date('date_received')->default(now());
            $table->enum('payment_method', [
                'Cash',
                'Bank',
                'Mobile Money',
                'Cheque',
                'Other'
            ])->default('Cash');
            $table->string('transaction_reference')->nullable();
            $table->string('receipt_number')->nullable()->unique();
            $table->string('account_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('bank_name')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('recorded_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
          Schema::create('sabbath_schools_has_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sabbath_school_id')->constrained('sabbath_schools')->onDelete('cascade');
            $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
              $table->string('role')->nullable();
            $table->timestamps();
        });
            Schema::create('ministries_has_leader', function (Blueprint $table) {
            $table->foreignId('ministry_id')->constrained('ministries')->onDelete('cascade');
            $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
            $table->string('role')->nullable();
            $table->timestamps();
        });

        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->enum('category', [
                'Salaries',
                'Utilities',
                'Maintenance',
                'Event',
                'Project',
                'Supplies',
                'Other'
            ])->default('Other');
            $table->string('description')->nullable();
            $table->decimal('amount', 12, 2);
            $table->date('date_incurred')->default(now());
            $table->enum('payment_method', [
                'Cash',
                'Bank',
                'Mobile Money',
                'Cheque',
                'Other'
            ])->default('Cash');
            $table->string('transaction_reference')->nullable();
            $table->string('receipt_number')->nullable()->unique();
            $table->string('account_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('bank_name')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->foreignId('ministry_id')->nullable()->constrained('ministries')->onDelete('set null');
            $table->foreignId('recorded_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->string('category')->nullable();
             $table->string('image_url')->nullable();
            $table->dateTime('publish_date')->nullable();
            $table->dateTime('expiry_date')->nullable();
            $table->boolean('is_published')->default(false);
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('messages', function (Blueprint $table) {
           $table->id();
            $table->string('content')->nullable();
            $table->string('message_type')->nullable();
        });
    }
    public function down(): void
    {
       Schema::dropIfExists('messages');
        Schema::dropIfExists('announcements');
        Schema::dropIfExists('expenses');
        Schema::dropIfExists('ministries_has_leader');
        Schema::dropIfExists('sabbath_schools_has_members');
        Schema::dropIfExists('incomes');
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('stewardships');
        Schema::dropIfExists('members');
        Schema::dropIfExists('sabbath_schools');
        Schema::dropIfExists('ministries');
        }
    };
