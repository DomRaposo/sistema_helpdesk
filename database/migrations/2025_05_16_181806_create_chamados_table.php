<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\StatusTicketEnum;
use App\Enums\AssuntoTicketEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('chamados', function (Blueprint $table) {
            $table->id();
            $table-> string('titulo');
            $table->text('descricao');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('status', StatusTicketEnum::values())->default(StatusTicketEnum::ABERTO);
            $table->enum('assunto', AssuntoTicketEnum::values());
            $table->date('data_abertura');
            $table->timestamps();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chamados');
    }
};
