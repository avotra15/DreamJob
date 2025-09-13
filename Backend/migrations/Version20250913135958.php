<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250913135958 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE users_permission (users_id INT NOT NULL, permission_id INT NOT NULL, PRIMARY KEY(users_id, permission_id))');
        $this->addSql('CREATE INDEX IDX_37223D3E67B3B43D ON users_permission (users_id)');
        $this->addSql('CREATE INDEX IDX_37223D3EFED90CCA ON users_permission (permission_id)');
        $this->addSql('ALTER TABLE users_permission ADD CONSTRAINT FK_37223D3E67B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE users_permission ADD CONSTRAINT FK_37223D3EFED90CCA FOREIGN KEY (permission_id) REFERENCES permission (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE permission ADD description VARCHAR(255) DEFAULT \'\' NOT NULL');
        //$this->addSql('ALTER TABLE permission ADD description VARCHAR(500) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE users_permission DROP CONSTRAINT FK_37223D3E67B3B43D');
        $this->addSql('ALTER TABLE users_permission DROP CONSTRAINT FK_37223D3EFED90CCA');
        $this->addSql('DROP TABLE users_permission');
        $this->addSql('ALTER TABLE permission DROP description');
    }
}
