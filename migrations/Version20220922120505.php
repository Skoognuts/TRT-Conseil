<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220922120505 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE administrator (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_58DF0651A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE candidate (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_C8B28E44A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE consultant (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_441282A1A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recruiter (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, company VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_DE8633D8A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE administrator ADD CONSTRAINT FK_58DF0651A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE candidate ADD CONSTRAINT FK_C8B28E44A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE consultant ADD CONSTRAINT FK_441282A1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE recruiter ADD CONSTRAINT FK_DE8633D8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE administrator DROP FOREIGN KEY FK_58DF0651A76ED395');
        $this->addSql('ALTER TABLE candidate DROP FOREIGN KEY FK_C8B28E44A76ED395');
        $this->addSql('ALTER TABLE consultant DROP FOREIGN KEY FK_441282A1A76ED395');
        $this->addSql('ALTER TABLE recruiter DROP FOREIGN KEY FK_DE8633D8A76ED395');
        $this->addSql('DROP TABLE administrator');
        $this->addSql('DROP TABLE candidate');
        $this->addSql('DROP TABLE consultant');
        $this->addSql('DROP TABLE recruiter');
    }
}
