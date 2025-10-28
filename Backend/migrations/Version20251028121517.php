<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251028121517 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE permission_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE permissions_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE permissions (id INT NOT NULL, nomperm VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE users_permission DROP CONSTRAINT fk_37223d3e67b3b43d');
        $this->addSql('ALTER TABLE users_permission DROP CONSTRAINT fk_37223d3efed90cca');
        $this->addSql('ALTER TABLE permission_roles DROP CONSTRAINT fk_60b943b438c751c4');
        $this->addSql('ALTER TABLE permission_roles DROP CONSTRAINT fk_60b943b4fed90cca');
        $this->addSql('DROP TABLE permission');
        $this->addSql('DROP TABLE users_permission');
        $this->addSql('DROP TABLE permission_roles');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE permissions_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE permission_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE permission (id INT NOT NULL, name_perm VARCHAR(255) NOT NULL, description VARCHAR(500) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE users_permission (users_id INT NOT NULL, permission_id INT NOT NULL, PRIMARY KEY(users_id, permission_id))');
        $this->addSql('CREATE INDEX idx_37223d3e67b3b43d ON users_permission (users_id)');
        $this->addSql('CREATE INDEX idx_37223d3efed90cca ON users_permission (permission_id)');
        $this->addSql('CREATE TABLE permission_roles (permission_id INT NOT NULL, roles_id INT NOT NULL, PRIMARY KEY(permission_id, roles_id))');
        $this->addSql('CREATE INDEX idx_60b943b438c751c4 ON permission_roles (roles_id)');
        $this->addSql('CREATE INDEX idx_60b943b4fed90cca ON permission_roles (permission_id)');
        $this->addSql('ALTER TABLE users_permission ADD CONSTRAINT fk_37223d3e67b3b43d FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE users_permission ADD CONSTRAINT fk_37223d3efed90cca FOREIGN KEY (permission_id) REFERENCES permission (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE permission_roles ADD CONSTRAINT fk_60b943b438c751c4 FOREIGN KEY (roles_id) REFERENCES roles (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE permission_roles ADD CONSTRAINT fk_60b943b4fed90cca FOREIGN KEY (permission_id) REFERENCES permission (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE permissions');
    }
}
