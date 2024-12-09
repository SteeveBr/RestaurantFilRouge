<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240721165333 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE menu_category (id INT AUTO_INCREMENT NOT NULL, menu_id_id INT NOT NULL, category_id_id INT NOT NULL, INDEX IDX_2A1D5C57EEE8BD30 (menu_id_id), INDEX IDX_2A1D5C579777D11E (category_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE menu_category ADD CONSTRAINT FK_2A1D5C57EEE8BD30 FOREIGN KEY (menu_id_id) REFERENCES menu (id)');
        $this->addSql('ALTER TABLE menu_category ADD CONSTRAINT FK_2A1D5C579777D11E FOREIGN KEY (category_id_id) REFERENCES category (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE menu_category DROP FOREIGN KEY FK_2A1D5C57EEE8BD30');
        $this->addSql('ALTER TABLE menu_category DROP FOREIGN KEY FK_2A1D5C579777D11E');
        $this->addSql('DROP TABLE menu_category');
    }
}
