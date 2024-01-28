<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240128215624 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE delivery_data DROP user_id');
        $this->addSql('ALTER TABLE user ADD delivery_data_id INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6493DEB1EE2 FOREIGN KEY (delivery_data_id) REFERENCES delivery_data (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6493DEB1EE2 ON user (delivery_data_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE delivery_data ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6493DEB1EE2');
        $this->addSql('DROP INDEX IDX_8D93D6493DEB1EE2 ON user');
        $this->addSql('ALTER TABLE user DROP delivery_data_id');
    }
}
