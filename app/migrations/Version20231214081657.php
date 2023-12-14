<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231214081657 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE prestation DROP FOREIGN KEY FK_51C88FAD26122B23');
        $this->addSql('ALTER TABLE prestation DROP FOREIGN KEY FK_51C88FAD8FDDAB70');
        $this->addSql('DROP INDEX IDX_51C88FAD8FDDAB70 ON prestation');
        $this->addSql('DROP INDEX IDX_51C88FAD26122B23 ON prestation');
        $this->addSql('ALTER TABLE prestation ADD owner_id INT DEFAULT NULL, ADD provider_id INT DEFAULT NULL, DROP owner_id_id, DROP provider_id_id');
        $this->addSql('ALTER TABLE prestation ADD CONSTRAINT FK_51C88FAD7E3C61F9 FOREIGN KEY (owner_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE prestation ADD CONSTRAINT FK_51C88FADA53A8AA FOREIGN KEY (provider_id) REFERENCES client (id)');
        $this->addSql('CREATE INDEX IDX_51C88FAD7E3C61F9 ON prestation (owner_id)');
        $this->addSql('CREATE INDEX IDX_51C88FADA53A8AA ON prestation (provider_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE prestation DROP FOREIGN KEY FK_51C88FAD7E3C61F9');
        $this->addSql('ALTER TABLE prestation DROP FOREIGN KEY FK_51C88FADA53A8AA');
        $this->addSql('DROP INDEX IDX_51C88FAD7E3C61F9 ON prestation');
        $this->addSql('DROP INDEX IDX_51C88FADA53A8AA ON prestation');
        $this->addSql('ALTER TABLE prestation ADD owner_id_id INT DEFAULT NULL, ADD provider_id_id INT DEFAULT NULL, DROP owner_id, DROP provider_id');
        $this->addSql('ALTER TABLE prestation ADD CONSTRAINT FK_51C88FAD26122B23 FOREIGN KEY (provider_id_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE prestation ADD CONSTRAINT FK_51C88FAD8FDDAB70 FOREIGN KEY (owner_id_id) REFERENCES client (id)');
        $this->addSql('CREATE INDEX IDX_51C88FAD8FDDAB70 ON prestation (owner_id_id)');
        $this->addSql('CREATE INDEX IDX_51C88FAD26122B23 ON prestation (provider_id_id)');
    }
}
