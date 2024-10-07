<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241006083415 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        // $this->addSql('INSERT INTO user (id, username, roles, password) VALUES (1, "admin", ["ROLE_ADMIN"], "$2y$13$QgLfBXU3cQI4pDh20Br2WOfmNy4XCy0xDCU0ZwLtsGeQq3Y0Y2.x2")');
        // $this->addSql('INSERT INTO user (id, username, roles, password) VALUES (1, "manager", ["ROLE_MANAGER"], "$2y$13$Sn4t6W/gNyq11i7utWW.Yuun9M5mbkmtDfOEMxrq8UooRgrYWv3kC")');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user');
    }
}