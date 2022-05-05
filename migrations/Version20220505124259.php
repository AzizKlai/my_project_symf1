<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220505124259 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE hobby (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hobby_personne (hobby_id INT NOT NULL, personne_id INT NOT NULL, INDEX IDX_46360CAE322B2123 (hobby_id), INDEX IDX_46360CAEA21BD112 (personne_id), PRIMARY KEY(hobby_id, personne_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profile (id INT AUTO_INCREMENT NOT NULL, personne_id INT DEFAULT NULL, github VARCHAR(100) NOT NULL, facebook VARCHAR(100) NOT NULL, email VARCHAR(100) NOT NULL, UNIQUE INDEX UNIQ_8157AA0FA21BD112 (personne_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE hobby_personne ADD CONSTRAINT FK_46360CAE322B2123 FOREIGN KEY (hobby_id) REFERENCES hobby (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE hobby_personne ADD CONSTRAINT FK_46360CAEA21BD112 FOREIGN KEY (personne_id) REFERENCES personne (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT FK_8157AA0FA21BD112 FOREIGN KEY (personne_id) REFERENCES personne (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hobby_personne DROP FOREIGN KEY FK_46360CAE322B2123');
        $this->addSql('DROP TABLE hobby');
        $this->addSql('DROP TABLE hobby_personne');
        $this->addSql('DROP TABLE profile');
    }
}
