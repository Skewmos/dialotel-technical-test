<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231214083535 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE proposal (id INT AUTO_INCREMENT NOT NULL, prestation_id INT DEFAULT NULL, client_id INT DEFAULT NULL, provider_id INT NOT NULL, INDEX IDX_BFE594729E45C554 (prestation_id), INDEX IDX_BFE5947219EB6921 (client_id), INDEX IDX_BFE59472A53A8AA (provider_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE proposal ADD CONSTRAINT FK_BFE594729E45C554 FOREIGN KEY (prestation_id) REFERENCES prestation (id)');
        $this->addSql('ALTER TABLE proposal ADD CONSTRAINT FK_BFE5947219EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE proposal ADD CONSTRAINT FK_BFE59472A53A8AA FOREIGN KEY (provider_id) REFERENCES client (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE proposal DROP FOREIGN KEY FK_BFE594729E45C554');
        $this->addSql('ALTER TABLE proposal DROP FOREIGN KEY FK_BFE5947219EB6921');
        $this->addSql('ALTER TABLE proposal DROP FOREIGN KEY FK_BFE59472A53A8AA');
        $this->addSql('DROP TABLE proposal');
    }
}
