<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210515062347 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE challenge (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(128) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, display_at DATETIME NOT NULL, hide_at DATETIME DEFAULT NULL, participation_starts_at DATETIME NOT NULL, participation_ends_at DATETIME NOT NULL, vote_begins_at DATETIME NOT NULL, vote_ends_at DATETIME NOT NULL, deliberation_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE challenge_participation (id INT AUTO_INCREMENT NOT NULL, challenge_id INT NOT NULL, profile_id INT NOT NULL, title VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_223360DC98A21AC6 (challenge_id), INDEX IDX_223360DCCCFA12B8 (profile_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE challenge_participation_vote (id INT AUTO_INCREMENT NOT NULL, participation_id INT NOT NULL, profile_id INT NOT NULL, created_at DATETIME NOT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_F1898DCD6ACE3B73 (participation_id), INDEX IDX_F1898DCDCCFA12B8 (profile_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE challenge_translation (id INT AUTO_INCREMENT NOT NULL, challenge_id INT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, locale VARCHAR(4) NOT NULL, rules LONGTEXT NOT NULL, INDEX IDX_CDD5EDD298A21AC6 (challenge_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE challenge_participation ADD CONSTRAINT FK_223360DC98A21AC6 FOREIGN KEY (challenge_id) REFERENCES challenge (id)');
        $this->addSql('ALTER TABLE challenge_participation ADD CONSTRAINT FK_223360DCCCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id)');
        $this->addSql('ALTER TABLE challenge_participation_vote ADD CONSTRAINT FK_F1898DCD6ACE3B73 FOREIGN KEY (participation_id) REFERENCES challenge_participation (id)');
        $this->addSql('ALTER TABLE challenge_participation_vote ADD CONSTRAINT FK_F1898DCDCCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id)');
        $this->addSql('ALTER TABLE challenge_translation ADD CONSTRAINT FK_CDD5EDD298A21AC6 FOREIGN KEY (challenge_id) REFERENCES challenge (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE challenge_participation DROP FOREIGN KEY FK_223360DC98A21AC6');
        $this->addSql('ALTER TABLE challenge_translation DROP FOREIGN KEY FK_CDD5EDD298A21AC6');
        $this->addSql('ALTER TABLE challenge_participation_vote DROP FOREIGN KEY FK_F1898DCD6ACE3B73');
        $this->addSql('DROP TABLE challenge');
        $this->addSql('DROP TABLE challenge_participation');
        $this->addSql('DROP TABLE challenge_participation_vote');
        $this->addSql('DROP TABLE challenge_translation');
    }
}
