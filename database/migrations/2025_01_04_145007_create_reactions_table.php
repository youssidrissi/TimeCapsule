<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reactions', function (Blueprint $table) {
            $table->id(); // Identifiant unique
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // FK vers users
            $table->foreignId('capsule_id')->constrained()->onDelete('cascade'); // FK vers capsules
            $table->enum('type', ['like', 'comment']); // Type de réaction
            $table->text('comment_text')->nullable(); // Texte du commentaire (si type = 'comment')
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
        Schema::dropIfExists('reactions');
    }
}
