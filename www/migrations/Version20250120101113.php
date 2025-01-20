<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250120101113 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE personne_profession (personne_id INT NOT NULL, profession_id INT NOT NULL, INDEX IDX_409A456DA21BD112 (personne_id), INDEX IDX_409A456DFDEF8996 (profession_id), PRIMARY KEY(personne_id, profession_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE personne_profession ADD CONSTRAINT FK_409A456DA21BD112 FOREIGN KEY (personne_id) REFERENCES personne (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE personne_profession ADD CONSTRAINT FK_409A456DFDEF8996 FOREIGN KEY (profession_id) REFERENCES profession (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personne_profession DROP FOREIGN KEY FK_409A456DA21BD112');
        $this->addSql('ALTER TABLE personne_profession DROP FOREIGN KEY FK_409A456DFDEF8996');
        $this->addSql('DROP TABLE personne_profession');
    }
}
