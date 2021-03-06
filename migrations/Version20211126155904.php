<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211126155904 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add token attribute in user class';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user ADD token VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user DROP token');
    }
}
