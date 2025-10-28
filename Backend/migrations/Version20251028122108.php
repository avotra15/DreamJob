<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251028122108 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE page_perm_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE page_perm (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE page_perm_roles (page_perm_id INT NOT NULL, roles_id INT NOT NULL, PRIMARY KEY(page_perm_id, roles_id))');
        $this->addSql('CREATE INDEX IDX_8107C0AB3FA7A ON page_perm_roles (page_perm_id)');
        $this->addSql('CREATE INDEX IDX_8107C0AB38C751C4 ON page_perm_roles (roles_id)');
        $this->addSql('CREATE TABLE page_perm_pages (page_perm_id INT NOT NULL, pages_id INT NOT NULL, PRIMARY KEY(page_perm_id, pages_id))');
        $this->addSql('CREATE INDEX IDX_174D0B193FA7A ON page_perm_pages (page_perm_id)');
        $this->addSql('CREATE INDEX IDX_174D0B19401ADD27 ON page_perm_pages (pages_id)');
        $this->addSql('CREATE TABLE page_perm_permissions (page_perm_id INT NOT NULL, permissions_id INT NOT NULL, PRIMARY KEY(page_perm_id, permissions_id))');
        $this->addSql('CREATE INDEX IDX_69383ECE3FA7A ON page_perm_permissions (page_perm_id)');
        $this->addSql('CREATE INDEX IDX_69383ECE9C3E4F87 ON page_perm_permissions (permissions_id)');
        $this->addSql('ALTER TABLE page_perm_roles ADD CONSTRAINT FK_8107C0AB3FA7A FOREIGN KEY (page_perm_id) REFERENCES page_perm (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE page_perm_roles ADD CONSTRAINT FK_8107C0AB38C751C4 FOREIGN KEY (roles_id) REFERENCES roles (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE page_perm_pages ADD CONSTRAINT FK_174D0B193FA7A FOREIGN KEY (page_perm_id) REFERENCES page_perm (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE page_perm_pages ADD CONSTRAINT FK_174D0B19401ADD27 FOREIGN KEY (pages_id) REFERENCES pages (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE page_perm_permissions ADD CONSTRAINT FK_69383ECE3FA7A FOREIGN KEY (page_perm_id) REFERENCES page_perm (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE page_perm_permissions ADD CONSTRAINT FK_69383ECE9C3E4F87 FOREIGN KEY (permissions_id) REFERENCES permissions (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE page_perm_id_seq CASCADE');
        $this->addSql('ALTER TABLE page_perm_roles DROP CONSTRAINT FK_8107C0AB3FA7A');
        $this->addSql('ALTER TABLE page_perm_roles DROP CONSTRAINT FK_8107C0AB38C751C4');
        $this->addSql('ALTER TABLE page_perm_pages DROP CONSTRAINT FK_174D0B193FA7A');
        $this->addSql('ALTER TABLE page_perm_pages DROP CONSTRAINT FK_174D0B19401ADD27');
        $this->addSql('ALTER TABLE page_perm_permissions DROP CONSTRAINT FK_69383ECE3FA7A');
        $this->addSql('ALTER TABLE page_perm_permissions DROP CONSTRAINT FK_69383ECE9C3E4F87');
        $this->addSql('DROP TABLE page_perm');
        $this->addSql('DROP TABLE page_perm_roles');
        $this->addSql('DROP TABLE page_perm_pages');
        $this->addSql('DROP TABLE page_perm_permissions');
    }
}
