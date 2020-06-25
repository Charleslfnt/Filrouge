<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200421132058 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE fournisseurs ADD produits_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE fournisseurs ADD CONSTRAINT FK_D3EF0041CD11A2CF FOREIGN KEY (produits_id) REFERENCES produits (id)');
        $this->addSql('CREATE INDEX IDX_D3EF0041CD11A2CF ON fournisseurs (produits_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE fournisseurs DROP FOREIGN KEY FK_D3EF0041CD11A2CF');
        $this->addSql('DROP INDEX IDX_D3EF0041CD11A2CF ON fournisseurs');
        $this->addSql('ALTER TABLE fournisseurs DROP produits_id');
    }
}
