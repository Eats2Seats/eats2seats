<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('liability_file_name');
            $table->string('liability_file_url');
            $table->string('tax_file_name');
            $table->string('tax_file_url');
            $table->foreignId('reviewed_by')
                ->nullable()
                ->constrained('users');
            $table->enum('review_status', [
                'approved',
                'rejected',
                'pending',
            ]);
            $table->text('review_message')
                ->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_documents');
    }
}
