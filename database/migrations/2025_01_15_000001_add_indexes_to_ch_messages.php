<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('ch_messages', function (Blueprint $table) {
            // Add indexes for better query performance
            if (!$this->indexExists('ch_messages', 'ch_messages_to_id_created_at_index')) {
                $table->index(['to_id', 'created_at'], 'ch_messages_to_id_created_at_index');
            }
            
            if (!$this->indexExists('ch_messages', 'ch_messages_from_id_index')) {
                $table->index('from_id', 'ch_messages_from_id_index');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ch_messages', function (Blueprint $table) {
            $table->dropIndex('ch_messages_to_id_created_at_index');
            $table->dropIndex('ch_messages_from_id_index');
        });
    }

    /**
     * Check if index exists
     */
    private function indexExists(string $table, string $index): bool
    {
        $connection = Schema::getConnection();
        $databaseName = $connection->getDatabaseName();
        
        $result = $connection->select(
            "SELECT COUNT(*) as count 
             FROM information_schema.statistics 
             WHERE table_schema = ? 
             AND table_name = ? 
             AND index_name = ?",
            [$databaseName, $table, $index]
        );
        
        return $result[0]->count > 0;
    }
};
