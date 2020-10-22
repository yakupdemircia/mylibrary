<?php
declare(strict_types=1);

use ElasticAdapter\Indices\Mapping;
use ElasticAdapter\Indices\Settings;
use ElasticMigrations\Facades\Index;
use ElasticMigrations\MigrationInterface;

final class CreateBooksIndex implements MigrationInterface
{
    /**
     * Run the migration.
     */
    public function up(): void
    {
        Index::create('books', function (Mapping $mapping, Settings $settings) {
            $mapping->text('title');
            $mapping->text('isbn');
            $mapping->text('author');
            $mapping->text('publisher');
            $mapping->text('description');
        });
    }

    /**
     * Reverse the migration.
     */
    public function down(): void
    {
        Index::dropIfExists('books');
    }
}
