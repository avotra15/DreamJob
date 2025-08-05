<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250805132333 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE roles_id_seq1 CASCADE');
        $this->addSql('DROP SEQUENCE users_id_seq1 CASCADE');
        $this->addSql('CREATE SEQUENCE job_details_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE job_details (id INT NOT NULL, email_id INT DEFAULT NULL, fichier VARCHAR(255) NOT NULL, titre VARCHAR(255) NOT NULL, description VARCHAR(500) NOT NULL, logo VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E8C9BC11A832C1C9 ON job_details (email_id)');
        $this->addSql('ALTER TABLE job_details ADD CONSTRAINT FK_E8C9BC11A832C1C9 FOREIGN KEY (email_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE roles ALTER id TYPE INT');
        $this->addSql('ALTER TABLE roles ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE users ALTER id TYPE INT');
        $this->addSql('ALTER TABLE users ALTER id DROP DEFAULT');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE job_details_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE roles_id_seq1 INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE users_id_seq1 INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('ALTER TABLE job_details DROP CONSTRAINT FK_E8C9BC11A832C1C9');
        $this->addSql('DROP TABLE job_details');
        $this->addSql('ALTER TABLE users ALTER id TYPE BIGINT');
        $this->addSql('CREATE SEQUENCE users_id_seq');
        $this->addSql('SELECT setval(\'users_id_seq\', (SELECT MAX(id) FROM users))');
        $this->addSql('ALTER TABLE users ALTER id SET DEFAULT nextval(\'users_id_seq\')');
        $this->addSql('ALTER TABLE roles ALTER id TYPE BIGINT');
        $this->addSql('CREATE SEQUENCE roles_id_seq');
        $this->addSql('SELECT setval(\'roles_id_seq\', (SELECT MAX(id) FROM roles))');
        $this->addSql('ALTER TABLE roles ALTER id SET DEFAULT nextval(\'roles_id_seq\')');
    }
}
