<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id(); // Identifiant unique
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // FK vers users
            $table->string('message'); // Message de notification
            $table->boolean('is_read')->default(false); // Notification lue ou non
            $table->foreignId('related_capsule_id')->nullable()->constrained('capsules')->onDelete('cascade'); // FK vers capsules
            $table->timestamps(); // Champs created_at et updated_at
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
