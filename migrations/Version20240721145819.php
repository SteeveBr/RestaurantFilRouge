<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240721145819 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE restaurant ADD name VARCHAR(32) NOT NULL, ADD description LONGTEXT NOT NULL, ADD am_opening_time LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', ADD pm_opening_time LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', ADD max_guest INT NOT NULL, ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE restaurant DROP name, DROP description, DROP am_opening_time, DROP pm_opening_time, DROP max_guest, DROP created_at, DROP updated_at');
    }
}
