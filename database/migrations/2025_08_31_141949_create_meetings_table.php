<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('agenda');
            $table->dateTime('date_time');
            $table->enum('type', ['online', 'offline']);
            $table->string('location')->nullable();
            $table->string('meeting_link')->nullable();
            $table->text('minutes')->nullable();
            $table->text('decisions')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('meeting_member', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meeting_id')->constrained()->onDelete('cascade');
            $table->foreignId('member_id')->constrained()->onDelete('cascade');
            $table->enum('attendance', ['present', 'absent', 'excused'])->default('absent');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('meeting_member');
        Schema::dropIfExists('meetings');
    }
};
