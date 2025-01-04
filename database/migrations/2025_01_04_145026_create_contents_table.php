<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->id(); // Identifiant unique
            $table->foreignId('capsule_id')->constrained()->onDelete('cascade'); // FK vers capsules
            $table->enum('type', ['text', 'image', 'video', 'audio']); // Type de contenu
            $table->string('file_path')->nullable(); // Chemin du fichier (si image/vidéo/audio)
            $table->text('text_content')->nullable(); // Texte (si type = 'text')
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
        Schema::dropIfExists('contents');
    }
}
