<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200311122408 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE categories CHANGE cat_name cat_name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE fournisseurs DROP four_phone, DROP four_email, CHANGE four_name four_name VARCHAR(255) NOT NULL, CHANGE four_ville four_ville VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE produits DROP pro_cat, DROP pro_ajout, DROP pro_stock, CHANGE pro_libelle pro_libelle VARCHAR(255) NOT NULL, CHANGE pro_ref pro_ref VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE utilisateurs ADD user_cp INT NOT NULL, ADD user_ville VARCHAR(50) NOT NULL, ADD user_pays VARCHAR(50) NOT NULL, DROP user_phone, CHANGE user_name user_name VARCHAR(255) NOT NULL, CHANGE user_firstname user_firstname VARCHAR(255) NOT NULL, CHANGE user_email user_email VARCHAR(255) NOT NULL, CHANGE user_password user_password VARCHAR(255) NOT NULL, CHANGE user_role user_role SMALLINT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE categories CHANGE cat_name cat_name VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE fournisseurs ADD four_phone INT NOT NULL COMMENT \'numéro de téléphone\', ADD four_email VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'email\', CHANGE four_name four_name VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE four_ville four_ville VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE produits ADD pro_cat INT NOT NULL, ADD pro_ajout DATE NOT NULL, ADD pro_stock INT NOT NULL, CHANGE pro_libelle pro_libelle VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE pro_ref pro_ref VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE utilisateurs ADD user_phone INT DEFAULT NULL COMMENT \'numéro de téléphone\', DROP user_cp, DROP user_ville, DROP user_pays, CHANGE user_name user_name VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Nom\', CHANGE user_email user_email VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'émail\', CHANGE user_password user_password VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'mot de passe haché\', CHANGE user_role user_role SMALLINT NOT NULL COMMENT \'role du user\', CHANGE user_firstname user_firstname VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'prénom\'');
    }
}
