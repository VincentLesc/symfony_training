<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210516173542 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE challenge_participation ADD image_name VARCHAR(255) NOT NULL');
        $this->addSql('DROP INDEX UNIQ_8157AA0F86CC499D ON profile');
        $this->addSql('ALTER TABLE profile CHANGE pseudo pseudo VARCHAR(32) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE challenge_participation DROP image_name');
        $this->addSql('ALTER TABLE profile CHANGE pseudo pseudo VARCHAR(32) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8157AA0F86CC499D ON profile (pseudo)');
    }
}
