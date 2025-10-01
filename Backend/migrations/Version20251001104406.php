<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251001104406 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE permission_roles (permission_id INT NOT NULL, roles_id INT NOT NULL, PRIMARY KEY(permission_id, roles_id))');
        $this->addSql('CREATE INDEX IDX_60B943B4FED90CCA ON permission_roles (permission_id)');
        $this->addSql('CREATE INDEX IDX_60B943B438C751C4 ON permission_roles (roles_id)');
        $this->addSql('ALTER TABLE permission_roles ADD CONSTRAINT FK_60B943B4FED90CCA FOREIGN KEY (permission_id) REFERENCES permission (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE permission_roles ADD CONSTRAINT FK_60B943B438C751C4 FOREIGN KEY (roles_id) REFERENCES roles (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE permission_roles DROP CONSTRAINT FK_60B943B4FED90CCA');
        $this->addSql('ALTER TABLE permission_roles DROP CONSTRAINT FK_60B943B438C751C4');
        $this->addSql('DROP TABLE permission_roles');
    }
}
