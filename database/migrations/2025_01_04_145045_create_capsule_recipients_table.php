<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCapsuleRecipientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('capsule_recipients', function (Blueprint $table) {
            $table->id(); // Identifiant unique
            $table->foreignId('capsule_id')->constrained()->onDelete('cascade'); // FK vers capsules
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // FK vers users (destinataire)
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
        Schema::dropIfExists('capsule_recipients');
    }
}
