<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCapsulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('capsules', function (Blueprint $table) {
            $table->id(); // Identifiant unique
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // FK vers users
            $table->boolean('is_public')->default(false); // Public ou privé
            $table->enum('status', ['En attente', 'Prête à ouvrir']);
            $table->enum('type', ['temporelle', 'compte à rebours', 'auto-destructrice']);
            $table->timestamp('open_date')->nullable(); // Date d'ouverture
            $table->timestamps(); // Champs created_at et updated_at
            $table->timestamp('end_date')->nullable(); // Date de fin
            $table->enum('status_type', ['envoyée', 'reçue'])->default('envoyée'); // Type de statut : envoyée ou reçue

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('capsules');
    }
}