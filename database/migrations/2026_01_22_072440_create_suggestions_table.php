<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up()
{
    Schema::create('suggestions', function (Blueprint $table) {
        $table->id();
        $table->string('name'); 
        
        // Hatalı olan satır: $table->ip('ip_address')->nullable();
        // Aşağıdaki DOĞRU olan satır ile değiştirin:
        $table->ipAddress('ip_address')->nullable(); 
        
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suggestions');
    }
};
